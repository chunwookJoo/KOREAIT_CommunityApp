<?php

namespace App\Http\Controllers\_Api\_User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 사용자 수신 메시지 삭제
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_user.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/user/message/delete/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		message_id			13						메시지 ID		필수
 * 		user_id				"20073004"				사용자 학번		필수
 *
 * 결과 (단일)
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		RESULT				100						삭제 성공
 * 							400						사용자 없음
 * 							410						메시지 없음
 *
 */

class _ApiUserGetMessageDelete extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$db_result = DB::select(
				'CALL koreaitedu.firebase_delete_receiver_entry(?,?);',
				array(
					$request->message_id,
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
