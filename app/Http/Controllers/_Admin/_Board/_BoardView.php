<?php

namespace App\Http\Controllers\_Admin\_Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class _BoardView extends Controller
{
	public function __invoke(Request $request)
	{
		$user_id = $request->cookie('admin_id');

		try {
			// 자기 자신의 게시물인지 확인
			$db_result = DB::select(
				'CALL koreaitedu.board_is_mine(?,?);',
				[
					$request->board_id,
					$user_id,
				]
			);
			// 접속자가 게시물 주인, 관리자, 일반 사용자 중 무엇인지 구분 하여 권한 번호 부여
			if ($db_result[0]->RESULT == 100) {
				$manage = 2;
			} else {
				$db_result = DB::select(
					'CALL koreaitedu.user_get_role(?);',
					[
						$user_id,
					]
				);

				if ($db_result[0]->role_id <= 500) {
					$manage = 1;
				} else {
					$manage = 0;
				}
			}

			$db_result_board = DB::select(
				'CALL koreaitedu.board_get_detail(?);',
				[$request->board_id]
			);

			$page_size = 20;

			if ($request->page_num) {
				$page_num = $request->page_num;
				$offset = ($request->page_num - 1)
					* $page_size;
			} else {
				$page_num = 1;
				$offset = 0;
			}

			$db_result_reply = DB::select(
				'CALL koreaitedu.reply_get_list(?,?,?,?);',
				[
					$request->board_id,
					$user_id,
					$offset,
					$page_size,
				]
			);

			$db_result_count = DB::select(
				'CALL koreaitedu.reply_get_count(?,?);',
				[
					$request->board_id,
					$page_size,
				]
			);

			$page_count = $db_result_count[0]->page_count;
			$result_page = [
				($page_num - 10 >= $page_count - 10) ? (($page_num - 10 > 0) ? ($page_num - 10) : null) : null,
				($page_num - 9 >= $page_count - 10) ? (($page_num - 9 > 0) ? ($page_num - 9) : null) : null,
				($page_num - 8 >= $page_count - 10) ? (($page_num - 8 > 0) ? ($page_num - 8) : null) : null,
				($page_num - 7 >= $page_count - 10) ? (($page_num - 7 > 0) ? ($page_num - 7) : null) : null,
				($page_num - 6 >= $page_count - 10) ? (($page_num - 6 > 0) ? ($page_num - 6) : null) : null,
				($page_num - 5 > 0) ? ($page_num - 5) : null,
				($page_num - 4 > 0) ? ($page_num - 4) : null,
				($page_num - 3 > 0) ? ($page_num - 3) : null,
				($page_num - 2 > 0) ? ($page_num - 2) : null,
				($page_num - 1 > 0) ? ($page_num - 1) : null,
				$page_num,
				($page_num + 1 <= $page_count) ? ($page_num + 1) : null,
				($page_num + 2 <= $page_count) ? ($page_num + 2) : null,
				($page_num + 3 <= $page_count) ? ($page_num + 3) : null,
				($page_num + 4 <= $page_count) ? ($page_num + 4) : null,
				($page_num + 5 <= $page_count) ? ($page_num + 5) : null,
				($page_num + 6 <= 11) ? (($page_num + 6 <= $page_count) ? ($page_num + 6) : null) : null,
				($page_num + 7 <= 11) ? (($page_num + 7 <= $page_count) ? ($page_num + 7) : null) : null,
				($page_num + 8 <= 11) ? (($page_num + 8 <= $page_count) ? ($page_num + 8) : null) : null,
				($page_num + 9 <= 11) ? (($page_num + 9 <= $page_count) ? ($page_num + 9) : null) : null,
				($page_num + 10 <= 11) ? (($page_num + 10 <= $page_count) ? ($page_num + 10) : null) : null,
			];

			return view(
				'_admin._board._view',
				[
					'board_id' => $request->board_id,
					'request' => $request,
					'result_board' => $db_result_board[0],
					'result_reply' => $db_result_reply,
					'result_page' => $result_page,
					'manage' => $manage,
				]
			);
		} catch (\Throwable $th) {
			Log::error($th);
			return redirect()->back()
				->with('alert', '시스템 오류가 발생했습니다.');
		}
	}
}
