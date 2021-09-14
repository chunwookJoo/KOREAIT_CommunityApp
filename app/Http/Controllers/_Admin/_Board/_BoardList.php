<?php

namespace App\Http\Controllers\_Admin\_Board;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Pagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _BoardList extends Controller
{
	public function __invoke(Request $request)
	{
		$page_size = 15;
		$page_num = $request->page_num ? $request->page_num : 1;
		$offset = ($page_num - 1) * $page_size;

		try {
			$db_params_list = [
				$request->board_group ?? 0,
				$offset,
				$page_size,
				$request->search_key,
				$request->search_value,
			];
			$db_params_count = [
				$request->board_group ?? 0,
				$page_size,
				$request->search_key,
				$request->search_value,
			];

			$db_result_group = DB::select("CALL koreaitedu.board_get_group();");
			$db_result_list = DB::select(
				"CALL koreaitedu.board_get_list(?,?,?,?,?);",
				$db_params_list
			);
			$db_result_count = DB::select(
				"CALL koreaitedu.board_get_count(?,?,?,?);",
				$db_params_count
			);

			$page_count = $db_result_count[0]->page_count;
			$result_page = Pagination::get_pages($page_num, $page_count);

			return view("_admin._board._list", [
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
