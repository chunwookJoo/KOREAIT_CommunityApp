<?php

namespace App\Http\Controllers\_Api\_User;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
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
 * 		content				"아아, 테스트"			메시지 내용
 *
 * 결과 (단일)
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		RESULT				100						전송 성공
 * 							400						사용자 키 없음	앱 설치 안됨
 * 		message_id			16
 *
 */

class _ApiUserSendMessage extends Controller
{
	public function __invoke(Request $request)
	{
		// GuzzleHttp\Client로 http 요청 준비
		$httpClient = new Client([
			'base_uri' => env('FCM_BASE_URL'),
			'headers' => [
				'Authorization' => "key=" . env('FCM_SERVER_TOKEN'),
				'Content-Type' => 'application/json',
				'project_id' => env('FCM_SENDER_ID'),
			],
		]);

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

				$firebase_key = $db_result_firebase_key[0]->firebase_key;

				// GuzzleHttp\Client 객체에 JSON 요청 넣기
				$fcm_request = new Psr7Request('POST', 'fcm/send', [], json_encode([
					'to' => $firebase_key,
					'notification' => [
						'title' => $request->title,
						'body' => $request->content,
					],
				]));

				$fcm_response = $httpClient->send($fcm_request);
				$fcm_response_json = json_decode($fcm_response->getBody(), true);

				try {
					// fcm 메시지 응답, 실패 시에만 error 속성이 존재
					if ($fcm_response_json['results']['0']['error'] == 'NotRegistered') {
						// 키에 해당하는 기기가 없으면 DB에서 사용자 키 삭제
						$db_result = DB::select(
							'CALL koreaitedu.firebase_delete_key(?);',
							array(
								$firebase_key
							)
						);
					}
					$result["MESSAGE"] = $result["MESSAGE"] . "전송에 실패했습니다.\n";
				} catch (\Throwable $th) {
					// 성공 시에는 error 속성이 존재하지 않으므로 접근 시 에러 처리
					$result["MESSAGE"] = $result["MESSAGE"] . "전송에 성공했습니다.\n";
				}

				return response()->json($result);
			} else if ($db_result_firebase_key[0]->RESULT == 400) {
				$result["MESSAGE"] = $result["MESSAGE"] . "전송에 실패했습니다.\n";
				return response()->json($result);
			}
		} catch (\Throwable $th) {
			Log::error($th);
			$db_result = ['RESULT' => '500'];
			return response()->json($db_result);
		}
	}
}
