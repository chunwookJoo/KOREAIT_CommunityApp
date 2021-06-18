<?php

namespace App\Http\Controllers\_Api\_User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 사용자 수신 메시지 개수
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_user.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/user/message/count/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		user_id				"20073004"				사용자 학번		필수
 *		page_size			20						목록 크기		필수
 *
 * 결과 (단일)
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		RESULT				100						조회 성공
 * 							400						사용자 없음
 * 		record_count		21						전체 레코드 수
 * 		page_count			2						전체 페이지 수
 *
 */

class _ApiUserGetMessageCount extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$db_result = DB::select(
				'CALL koreaitedu.firebase_get_message_count(?,?,?);',
				array(
					$request->user_id,
					$request->page_size,
					0,
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
