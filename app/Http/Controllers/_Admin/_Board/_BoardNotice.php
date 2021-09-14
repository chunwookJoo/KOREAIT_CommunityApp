<?php

namespace App\Http\Controllers\_Admin\_Board;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use App\Http\Controllers\Pagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _BoardNotice extends Controller
{
	public function get(Request $request)
	{
		$page_size = 15;
		$page_num = $request->page_num ? $request->page_num : 1;
		$offset = ($page_num - 1) * $page_size;

		try {
			$curl = CurlController::getInstance();

			// curl을 사용한 API Response 가져오기
			$response_college = $curl->curlGet(env("URL_MAJOR"));
			$response_depart = [];

			foreach ($response_college as $college) {
				array_push($response_depart, [
					"sosokCode" => $college["sosokCode"],
					"minor" => $curl->curlGet(
						env("URL_MINOR") . $college["sosokCode"]
					),
				]);
			}

			$db_params = [$request->cookie("admin_id")];

			$db_result_user = DB::select(
				"CALL koreaitedu.user_get_role(?);",
				$db_params
			);
			$db_result_group = DB::select(
				"CALL koreaitedu.notice_get_group(?);",
				$db_params
			);

			$db_params_notice = [
				$request->board_group ?? 701,
				0,
				30,
				null,
				$request->college ?? $db_result_user[0]->college,
				$request->depart ?? $db_result_user[0]->depart,
			];

			$db_result_notice = DB::select(
				"CALL koreaitedu.notice_get_list(?,?,?,?,?,?);",
				$db_params_notice
			);

			if ($request->board_group >= 900) {
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

				$db_result_list = DB::select(
					"CALL koreaitedu.board_get_list(?,?,?,?,?);",
					$db_params_list
				);
				$db_result_count = DB::select(
					"CALL koreaitedu.board_get_count(?,?,?,?);",
					$db_params_count
				);
			} else {
				$db_params_list = [
					$request->college ?? $db_result_user[0]->college,
					$offset,
					$page_size,
					$request->search_key,
					$request->search_value,
				];
				$db_params_count = [
					$request->college ?? $db_result_user[0]->college,
					$page_size,
					$request->search_key,
					$request->search_value,
				];

				$db_result_list = DB::select(
					"CALL koreaitedu.board_get_college(?,?,?,?,?);",
					$db_params_list
				);
				$db_result_count = DB::select(
					"CALL koreaitedu.board_get_college_count(?,?,?,?);",
					$db_params_count
				);
			}

			$page_count = $db_result_count[0]->page_count;
			$result_page = Pagination::get_pages($page_num, $page_count);

			return view("_admin._board._notice", [
				"request" => $request,
				"result_group" => $db_result_group,
				"result_college" => $response_college,
				"result_depart" => $response_depart,
				"result_notice" => $db_result_notice,
				"result_list" => $db_result_list,
				"result_page" => $result_page,
				"result_user" => $db_result_user[0],
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

		try {
			foreach ($request->board_id as $key => $value) {
				$db_params = [$key, $user_id, $value == "on" ? 1 : 0];

				DB::select("CALL koreaitedu.notice_switch(?,?,?);", $db_params);
			}
			return redirect()->route("_BoardNotice", [
				"board_group" => $request->board_group,
				"college" => $request->college,
				"depart" => $request->depart,
				"search_key" => $request->search_key,
				"search_value" => $request->search_value,
			]);
		} catch (\Throwable $th) {
			Log::error($th);
			return redirect()
				->back()
				->with("alert", "시스템 오류가 발생했습니다.");
		}
	}
}
