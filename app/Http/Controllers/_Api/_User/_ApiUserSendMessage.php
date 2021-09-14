<?php

namespace App\Http\Controllers\_Api\_User;

use App\Http\Controllers\_Api\_ApiRequestSender;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * PUSH 메시지 전송
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_user.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/user/message/send/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		sender_id			"2021234"				사번/학번		필수
 * 		student_id			"20073004"				학번			필수
 * 		title				"테스트"				메시지 제목		필수
 * 		content				"아아, 테스트"			메시지 내용		필수
 * 		phone				"01012345678"			송신자 번호		푸시 실패 시 MMS, 옵션
 * 		callback			"01087654321"			수신자 번호		푸시 실패 시 MMS, 옵션
 *
 * 결과 (단일)
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		RESULT				100						전송 성공
 * 							400						사용자 없음		앱 등록 안함
 * 							410						키 없음			기기 로그인 안함
 *
 */

class _ApiUserSendMessage extends Controller
{
	public function __invoke(Request $request)
	{
		$result = array(
			"MESSAGE" => "",
		);

		try {
			$db_result_firebase_key = DB::select(
				'CALL koreaitedu.user_get_firebase_key(?);',
				array(
					$request->student_id,
				)
			);

			// key 조회 후 DB에 수신자 존재 시
			if ($db_result_firebase_key[0]->RESULT != 400) {
				// firebase 메시지 DB에 저장
				$db_result_message_id = DB::select(
					'CALL koreaitedu.firebase_add_message(?,?);',
					array(
						$request->title,
						$request->content,
					)
				);

				$message_id = $db_result_message_id[0]->message_id;

				// 메시지에 송신자 연결
				$db_result = DB::select(
					'CALL koreaitedu.firebase_add_sender_entry(?,?);',
					array(
						$message_id,
						$request->sender_id
					)
				);

				// 송신자가 학사 앱 관리자 페이지에 로그인한 적이 없으면
				if ($db_result[0]->RESULT == 400) {
					$result["MESSAGE"] = $result["MESSAGE"] . "학사 앱 관리자 페이지에 로그인해주세요.\n";
				}

				// 메시지에 수신자 연결
				$db_result = DB::select(
					'CALL koreaitedu.firebase_add_receiver_entry(?,?);',
					array(
						$message_id,
						$request->student_id
					)
				);

				if ($db_result_firebase_key[0]->RESULT == 100) {
					// 등록된 사용자의 firebase_key가 있으면 푸시 전송
					$firebase_key = $db_result_firebase_key[0]->firebase_key;
					$result = _ApiRequestSender::send_fcm($request, $firebase_key, $result);
				} else {
					// 등록된 사용자의 firebase_key가 없으면 SMS 전송
					$result = _ApiRequestSender::send_sms($request, $result);
				}

				return response()->json($result);
			} else {
				// 수신자 정보가 등록되어 있지 않으면 SMS 전송
				$result = _ApiRequestSender::send_sms($request, $result);
				return response()->json($result);
			}
		} catch (\Throwable $th) {
			Log::error($th);
			$db_result = ['RESULT' => '500'];
			return response()->json($db_result);
		}
	}
}
