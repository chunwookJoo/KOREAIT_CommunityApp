<?php

namespace App\Http\Controllers\_Api\_User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 사용자 별명 입력
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_user.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/user/set/nickname/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		user_id				20073004				사용자 학번		필수
 * 		nickname			용						사용자 별명		필수
 *
 * 결과 (단일)
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		RESULT				100						입력 성공
 * 							400						사용자 없음
 * 							500						내부 오류
 *
 */

class _ApiUserSetNickname extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$db_result = DB::select(
				'CALL koreaitedu.user_set_nickname(?,?);',
				array(
					$request->user_id,
					$request->nickname,
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
