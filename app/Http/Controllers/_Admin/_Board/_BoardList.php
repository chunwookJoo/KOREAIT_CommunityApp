<?php

namespace App\Http\Controllers\_Admin\_Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _BoardList extends Controller
{
	public function __invoke(Request $request)
	{
		$page_size = 15;

		if ($request->page_num) {
			$page_num = $request->page_num;
			$offset = ($request->page_num - 1)
				* $page_size;
		} else {
			$page_num = 1;
			$offset = 0;
		}
		try {
			$db_result_group = DB::select(
				'CALL koreaitedu.board_get_group();'
			);
			$db_result_list = DB::select(
				'CALL koreaitedu.board_get_list(?,?,?,?,?);',
				[
					$request->board_group ?? 0,
					$offset,
					$page_size,
					$request->search_key,
					$request->search_value,
				]
			);
			$db_result_count = DB::select(
				'CALL koreaitedu.board_get_count(?,?,?,?);',
				[
					$request->board_group ?? 0,
					$page_size,
					$request->search_key,
					$request->search_value,
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
				'_admin._board._list',
				[
					'request' => $request,
					'result_group' => $db_result_group,
					'result_list' => $db_result_list,
					'result_page' => $result_page,
				]
			);
		} catch (\Throwable $th) {
			Log::error($th);
			return redirect()->back()->with('alert', '시스템 오류가 발생했습니다.');
		}
	}
}
