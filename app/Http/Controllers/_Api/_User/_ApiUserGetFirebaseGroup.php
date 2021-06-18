<?php

namespace App\Http\Controllers\_Api\_User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 계열/학과/학년을 이용한 Firebase 키 조회
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_user.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/user/get/firebase/group
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		college				융합스마트				사용자 계열		필수
 * 		depart				컴퓨터공학				사용자 학과		필수
 * 		year				1						사용자 학년		필수, DB에 rank로 조회
 *
 * 결과 (목록)
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		user_id				"20073004"				사용자 학번
 * 		user_name			"박경용"				사용자 이름
 * 		device_name			"LM-V510N"				기기 정보
 * 		firebase_key		"d_fkAQ..."				Firebase 키
 *
 */

class _ApiUserGetFirebaseGroup extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$db_result = DB::select(
				'CALL koreaitedu.firebase_get_sosok(?,?,?);',
				array(
					$request->college,
					$request->depart,
					$request->year,
				)
			);
			return response()->json($db_result);
		} catch (\Throwable $th) {
			Log::error($th);
			$db_result = ['RESULT' => '500'];
			return response()->json($db_result);
		}
	}
}
