<?php

namespace App\Http\Controllers\_Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _Home extends Controller
{
	public function __invoke(Request $request)
	{
		// 쿠키 내 관리자 id 가져오기
		$id = Cookie::get('admin_id');

		try {
			// DB에서 역할 정보 가져오기
			$db_result = DB::select(
				'CALL koreaitedu.user_get_role(?);',
				array($id)
			);

			$result = array(
				'id' => $id,
				'role_name' => $db_result[0]->role_name,
				'user_name' => $db_result[0]->user_name,
			);
			return view('_admin._home', ['result' => $result]);
		} catch (\Throwable $th) {
			Log::error($th);
			return view('_admin._home', ['result' => null])->with('alert', '시스템 오류가 발생했습니다.');
		}
	}
}
