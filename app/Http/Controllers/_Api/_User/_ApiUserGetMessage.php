<?php

namespace App\Http\Controllers\_Api\_User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 사용자 수신 메시지 조회
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_user.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/user/message/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		message_id			13						메시지 ID		필수
 *
 * 결과 (단일)
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		RESULT				100						조회 성공
 * 							400						메시지 없음
 * 		title				"테스트"				메시지 제목
 * 		content				"아아, 테스트"			메시지 내용
 * 		time_sent			"2021-04-30 21:22:41"	보낸 시간
 * 		college				"인공지능"				보낸 사람 소속
 * 		name				"박경용"				보낸 사람 이름
 *
 */

class _ApiUserGetMessage extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$db_result = DB::select(
				'CALL koreaitedu.firebase_get_message(?);',
				array(
					$request->message_id,
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
