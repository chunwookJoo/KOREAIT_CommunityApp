<?php

namespace App\Http\Controllers\_Api\_User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 사용자 Firebase 키 조회
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_user.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/user/get/firebase/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		user_id				20073004				사용자 학번		필수
 *
 * 결과 (목록)
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		device_name			"LM-V510N"				기기 정보
 * 		firebase_key		"d_fkAQ..."				Firebase 키
 * 		last_login			"2021-01-20 02:20:38"	마지막 로그인
 *
 */

class _ApiUserGetFirebase extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$db_result = DB::select(
				'CALL koreaitedu.user_get_firebase_key(?);',
				array(
					$request->user_id,
				)
			);
			return response()->json($db_result[0]);
		} catch (\Throwable $th) {
			Log::error($th);
			$db_result = ['RESULT' => '500'];
			return response()->json($db_result);
		}
	}
}
