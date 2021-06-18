<?php

namespace App\Http\Controllers\_Admin;

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
		$id = Cookie::get('admin_id');

		try {
			// DB에서 역할 정보 가져오기
			$db_result_role = DB::select(
				'CALL koreaitedu.user_get_role(?);',
				array($id)
			);

			// DB에서 사용자 역할 가져오기
			$result_role = array(
				'id' => $id,
				'role_name' => $db_result_role[0]->role_name,
				'user_name' => $db_result_role[0]->user_name,
			);

			// DB에서 페이지 목록 가져오기
			$db_result_menu = DB::select(
				'CALL koreaitedu.admin_page_get_list(?);',
				array($id)
			);
			return view('_admin._layout._nav', [
				'result_role' => $result_role,
				'result_menu' => $db_result_menu,
				]);
		} catch (\Throwable $th) {
			Log::error($th);
			return view('_admin._layout._nav',
			 	[
					'result_menu' => [],
				 	'result_role' => [],
				])->with('alert', '시스템 오류가 발생했습니다.');
		}
	}
}
