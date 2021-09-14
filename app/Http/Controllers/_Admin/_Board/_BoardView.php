<?php

namespace App\Http\Controllers\_Admin\_Board;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Pagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class _BoardView extends Controller
{
	public function __invoke(Request $request)
	{
		$user_id = $request->cookie("admin_id");

		try {
			// 자기 자신의 게시물인지 확인
			$db_params = [$request->board_id, $user_id];

			$db_result = DB::select(
				"CALL koreaitedu.board_is_mine(?,?);",
				$db_params
			);
			// 접속자가 게시물 주인, 관리자, 일반 사용자 중 무엇인지 구분 하여 권한 번호 부여
			if ($db_result[0]->RESULT == 100) {
				$manage = 2;
			} else {
				$db_params = [$user_id];

				$db_result = DB::select(
					"CALL koreaitedu.user_get_role(?);",
					$db_params
				);

				$manage = $db_result[0]->role_id <= 500 ? 1 : 0;
			}

			$db_params_board = [$request->board_id];

			$db_result_board = DB::select(
				"CALL koreaitedu.board_get_detail(?);",
				$db_params_board
			);

			$page_size = 20;
			$page_num = $request->page_num ? $request->page_num : 1;
			$offset = ($page_num - 1) * $page_size;

			$db_params_reply = [
				$request->board_id,
				$user_id,
				$offset,
				$page_size,
			];
			$db_params_count = [$request->board_id, $page_size];

			$db_result_reply = DB::select(
				"CALL koreaitedu.reply_get_list(?,?,?,?);",
				$db_params_reply
			);
			$db_result_count = DB::select(
				"CALL koreaitedu.reply_get_count(?,?);",
				$db_params_count
			);

			$page_count = $db_result_count[0]->page_count;
			$result_page = Pagination::get_pages($page_num, $page_count);

			return view("_admin._board._view", [
				"board_id" => $request->board_id,
				"request" => $request,
				"result_board" => $db_result_board[0],
				"result_reply" => $db_result_reply,
				"result_page" => $result_page,
				"manage" => $manage,
			]);
		} catch (\Throwable $th) {
			Log::error($th);
			return redirect()
				->back()
				->with("alert", "시스템 오류가 발생했습니다.");
		}
	}
}
