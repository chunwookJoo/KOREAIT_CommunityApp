<?php

namespace App\Http\Controllers\_Admin\_Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _BoardModify extends Controller
{
	public function get(Request $request)
	{
		try {
			$db_params = [$request->board_id];
			$db_result = DB::select(
				"CALL koreaitedu.board_get_detail(?);",
				$db_params
			);

			return view("_admin._board._edit", [
				"board_id" => $request->board_id,
				"result_board" => $db_result[0],
				"result_group" => null,
				"result_college" => null,
				"result_depart" => null,
			]);
		} catch (\Throwable $th) {
			Log::error($th);
			return redirect()
				->back()
				->with("alert", "시스템 오류가 발생했습니다.");
		}
	}

	public function post(Request $request)
	{
		$user_id = Cookie::get("admin_id");

		$is_notice = $request->board_is_notice;
		$is_notice = $is_notice == "on" || $is_notice == 1 ? 1 : 0;

		try {
			$db_params = [
				$request->board_id,
				$user_id,
				$request->board_title,
				$request->board_content,
				$is_notice,
				$request->college,
				$request->depart,
			];
			DB::select(
				"CALL koreaitedu.board_modify(?,?,?,?,?,?,?);",
				$db_params
			);
			return redirect()
				->route("_BoardView", ["board_id" => $request->board_id])
				->with("alert", "게시물 수정 완료");
		} catch (\Throwable $th) {
			Log::error($th);
			return redirect()
				->back()
				->with("alert", "시스템 오류가 발생했습니다.");
		}
	}
}
