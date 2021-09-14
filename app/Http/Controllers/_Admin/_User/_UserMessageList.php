<?php

namespace App\Http\Controllers\_Admin\_User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Pagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _UserMessageList extends Controller
{
	public function __invoke(Request $request)
	{
		$user_id = $request->cookie("admin_id");
		$page_size = 15;

		if ($request->page_num) {
			$page_num = $request->page_num;
			$offset = ($request->page_num - 1) * $page_size;
		} else {
			$page_num = 1;
			$offset = 0;
		}
		try {
			$db_result_list = DB::select(
				"CALL koreaitedu.firebase_get_message_list(?,?,?,?);",
				[$user_id, $offset, $page_size, 1]
			);
			$db_result_count = DB::select(
				"CALL koreaitedu.firebase_get_message_count(?,?,?);",
				[$user_id, $page_size, 1]
			);

			$page_count = $db_result_count[0]->page_count;
			$result_page = Pagination::get_pages($page_num, $page_count);

			return view("_admin._user._messageList", [
				"request" => $request,
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
