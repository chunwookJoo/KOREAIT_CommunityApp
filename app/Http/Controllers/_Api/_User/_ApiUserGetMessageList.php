<?php

namespace App\Http\Controllers\_Api\_User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 사용자 수신 메시지 목록
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_user.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/user/message/list/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		user_id				20073004				사용자 학번		필수
 * 		page_num			1						목록 번호		필수
 * 		page_size			20						목록 크기		필수
 *
 * 결과 (목록)
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		message_id			13						메시지 ID
 * 		title				"테스트"				메시지 제목
 * 		time_sent			"2021-04-30 21:22:41"	수신 시간
 *
 */

class _ApiUserGetMessageList extends Controller
{
	public function __invoke(Request $request)
	{
		$page_offset = ($request->page_num - 1) * $request->page_size;
		try {
			$db_result = DB::select(
				'CALL koreaitedu.firebase_get_message_list(?,?,?,?);',
				array(
					$request->user_id,
					$page_offset,
					$request->page_num,
					0,
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
