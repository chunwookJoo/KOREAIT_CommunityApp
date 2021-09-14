<?php

namespace App\Http\Controllers\_Admin\_Board;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Pagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _BoardMyList extends Controller
{
	public function __invoke(Request $request)
	{
		$user_id = $request->cookie("admin_id");

		$page_size = 15;
		$page_num = $request->page_num ? $request->page_num : 1;
		$offset = ($page_num - 1) * $page_size;

		$is_notice = $request->board_is_notice;
		$is_notice = $is_notice == "on" || $is_notice == 1 ? 1 : 0;

		try {
			$db_params_list = [
				$request->board_group ?? 0,
				$user_id,
				$offset,
				$page_size,
				$is_notice,
				$request->search_key,
				$request->search_value,
			];
			$db_params_count = [
				$request->board_group ?? 0,
				$user_id,
				$page_size,
				$is_notice,
				$request->search_key,
				$request->search_value,
			];

			$db_result_group = DB::select("CALL koreaitedu.board_get_group();");
			$db_result_list = DB::select(
				"CALL koreaitedu.board_get_mylist(?,?,?,?,?,?,?);",
				$db_params_list
			);
			$db_result_count = DB::select(
				"CALL koreaitedu.board_get_mycount(?,?,?,?,?,?);",
				$db_params_count
			);

			$page_count = $db_result_count[0]->page_count;
			$result_page = Pagination::get_pages($page_num, $page_count);

			return view("_admin._board._myList", [
				"request" => $request,
				"result_group" => $db_result_group,
				"result_list" => $db_result_list,
				"result_page" => $result_page,
			]);
		} catch (\Throwable $th) {
			Log::error($th);
			return redirect()
				->back()
				->with("alert", "시스템 오류가 발생했습니다.");
		}
	}
}
