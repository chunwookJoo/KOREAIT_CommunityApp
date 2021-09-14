<?php

namespace App\Http\Controllers\_Admin\_Board;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _BoardWrite extends Controller
{
	public function get(Request $request)
	{
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

		try {
			$db_params = [$request->cookie("admin_id")];

			$db_result = [
				DB::select("CALL koreaitedu.notice_get_group(?);", $db_params),
				DB::select("CALL koreaitedu.board_get_group();"),
			];
			return view("_admin._board._edit", [
				"board_id" => null,
				"result_board" => null,
				"result_group" => $db_result,
				"result_college" => $response_college,
				"result_depart" => $response_depart,
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

		$college = $request->board_group == 701 ? $request->college : null;

		try {
			$db_params = [
				$request->board_group,
				$user_id,
				$request->board_title,
				$request->board_content,
				$is_notice,
				$college,
				null,
			];

			$db_result = DB::select(
				"CALL koreaitedu.board_write(?,?,?,?,?,?,?);",
				$db_params
			);
			return redirect()
				->route("_BoardView", [
					"board_id" => $db_result[0]->board_id,
				])
				->with("alert", "게시물 작성 완료");
		} catch (\Throwable $th) {
			Log::error($th);
			return redirect()
				->back()
				->with("alert", "시스템 오류가 발생했습니다.");
		}
	}
}
