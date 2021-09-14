<?php

namespace App\Http\Controllers\_Admin\_Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _RoleSet extends Controller
{
	public function get(Request $request)
	{
		try {
			$db_params = [$request->cookie("admin_id")];

			$db_result = DB::select(
				"CALL koreaitedu.role_get_list(?);",
				$db_params
			);
			return view("_admin._role._set", ["result" => $db_result]);
		} catch (\Throwable $th) {
			Log::error($th);
			return view("_admin._role._set")->with(
				"alert",
				"시스템 오류가 발생했습니다."
			);
		}
	}

	public function post(Request $request)
	{
		try {
			$db_params = [
				$request->user_id,
				$request->role_option,
				$request->cookie("admin_id"),
			];

			DB::select("CALL koreaitedu.user_set_role(?,?,?);", $db_params);
			return redirect()
				->back()
				->with("alert", "역할 설정이 완료되었습니다.");
		} catch (\Throwable $th) {
			Log::error($th);
			return redirect()
				->back()
				->with("alert", "시스템 오류가 발생했습니다.");
		}
	}
}
