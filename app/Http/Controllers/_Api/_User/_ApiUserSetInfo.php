<?php

namespace App\Http\Controllers\_Api\_User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 사용자 정보 입력/수정
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_user.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/user/set/info/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		user_id				20073004				사용자 학번		필수
 * 		user_name			박경용					사용자 이름		필수
 * 		college				융합스마트				사용자 계열		필수
 * 		depart				컴퓨터공학				사용자 학과		필수
 * 		year				1						사용자 학년		필수, DB에 rank로 저장
 *
 * 결과 (단일)
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		RESULT				100						삽입 성공
 * 							110						수정 성공
 * 							500						내부 오류
 *
 */

class _ApiUserSetInfo extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$db_result = DB::select(
				'CALL koreaitedu.user_set_info(?,?,?,?,?);',
				array(
					$request->user_id,
					$request->user_name,
					$request->college,
					$request->depart,
					$request->year,
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
