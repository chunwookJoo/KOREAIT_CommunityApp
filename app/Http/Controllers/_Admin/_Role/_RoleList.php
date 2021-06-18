<?php

namespace App\Http\Controllers\_Admin\_Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _RoleList extends Controller
{
	public function __invoke(Request $request)
	{
		$method = strtolower($request->method());
		if ($method == 'get') {
			try {
				$db_result_user = DB::select(
					'CALL koreaitedu.role_get_user_list(?);',
					[$request->cookie('admin_id')]
				);

				$db_result_role = DB::select(
					'CALL koreaitedu.role_get_list(?);',
					[$request->cookie('admin_id')]
				);

				return view(
					'_admin._role._list',
					[
						'result_user' => $db_result_user,
						'result_role' => $db_result_role
					]
				);
			} catch (\Throwable $th) {
				Log::error($th);
				return redirect()->back()->with('alert', '시스템 오류가 발생했습니다.');
			}
		} else if ($method == 'post') {
			try {
				$db_result = DB::select(
					'CALL koreaitedu.user_set_role(?,?,?);',
					[
						$request->user_id,
						$request->role_option,
						$request->cookie('admin_id'),
					]
				);
				return redirect()->back()->with('alert', '역할 설정이 완료되었습니다.');
			} catch (\Throwable $th) {
				Log::error($th);
				return redirect()->back()->with('alert', '시스템 오류가 발생했습니다.');
			}
		}
	}
}
