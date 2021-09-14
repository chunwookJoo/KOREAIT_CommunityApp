<?php

namespace App\Http\Controllers\_Admin\_Log;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Pagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _LogApp extends Controller
{
	public function __invoke(Request $request)
	{
		$page_size = 20;
		$page_num = $request->page_num ? $request->page_num : 1;
		$offset = ($page_num - 1) * $page_size;

		try {
			$db_params_log = [
				$request->user_id,
				$request->ip_address,
				$offset,
				$page_size,
				$request->segment(3),
			];
			$db_params_count = [
				$request->user_id,
				$request->ip_address,
				$page_size,
				$request->segment(3),
			];

			$db_result_log = DB::select(
				"CALL koreaitedu.log_get(?,?,?,?,?);",
				$db_params_log
			);
			$db_result_count = DB::select(
				"CALL koreaitedu.log_get_count(?,?,?,?);",
				$db_params_count
			);

			$page_count = $db_result_count[0]->page_count;
			$result_page = Pagination::get_pages($page_num, $page_count);

			return view("_admin._log._" . $request->segment(3), [
				"request" => $request,
				"result_log" => $db_result_log,
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
