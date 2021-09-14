<?php

namespace App\Http\Controllers\_Admin;

use App\Http\Controllers\_ProcedureController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _Main extends Controller
{
	public function __invoke(Request $request)
	{
		// 쿠키 내 관리자 id 가져오기
		$id = Cookie::get("admin_id");

		try {
			// DB에서 역할 정보 가져오기
			$db_params = [$id];
			$db_controller = new _ProcedureController(
				"user_get_role",
				$db_params
			);
			$db_result = $db_controller->query_one();

			$result_role = [
				"id" => $id,
				"role_name" => $db_result->role_name,
				"user_name" => $db_result->user_name,
			];

			// DB에서 페이지 목록 가져오기
			$db_controller = new _ProcedureController(
				"admin_page_get_list",
				$db_params
			);
			$db_result_menu = $db_controller->query();

			return view("_admin._layout._nav", [
				"result_role" => $result_role,
				"result_menu" => $db_result_menu,
			]);
		} catch (\Throwable $th) {
			Log::error($th);
			return view("_admin._layout._nav", [
				"result_menu" => [],
				"result_role" => [],
			])->with("alert", "시스템 오류가 발생했습니다.");
		}
	}
}
