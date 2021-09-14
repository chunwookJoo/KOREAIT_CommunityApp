<?php

namespace App\Http\Controllers\_Api;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class _ApiRequestSender
{
	public static function send_sms(Request $request, $result = ['MESSAGE' => ''])
	{
		// SMS 전송을 위한 Client 생성
		$smsClient = new Client([
			'base_uri' => env('URL_HAKSA'),
			'headers' => [
				'X-Korit-Msg-Client-Token' => env('SMS_TOKEN'),
			],
		]);

		try {
			// FORM 요청 전송 후 JSON 응답 수신
			$sms_response = $smsClient->request('POST', env('SMS_SEND'),  [
				'form_params' => [
					'PHONE' => $request->phone,
					'CALLBACK' => $request->callback,
					'SUBJECT' => $request->title,
					'MSG' => $request->content,
				]
			]);
			$sms_response_json = json_decode($sms_response->getBody(), true);

			if ($sms_response_json[0]['RESULT'] == '100') $result['MESSAGE'] = $result['MESSAGE'] . '문자 전송에 성공했습니다.\n';
			else $result['MESSAGE'] = $result['MESSAGE'] . '문자 전송에 실패했습니다.\n';
			$result['RESULT'] = $sms_response_json[0]['RESULT'];
		} catch (\Throwable $th) {
			Log::error($th);
			$result['MESSAGE'] = $result['MESSAGE'] . '문자 전송에 실패했습니다.\n';
			$result['RESULT'] = '500';
		}

		return $result;
	}
	public static function send_fcm(Request $request, $firebase_key, $result = ['MESSAGE' => ''])
	{
		// FCM 전송을 위한 Client 생성
		$fcmClient = new Client([
			'base_uri' => env('FCM_BASE_URL'),
			'headers' => [
				'Authorization' => 'key=' . env('FCM_SERVER_TOKEN'),
				'Content-Type' => 'application/json',
				'project_id' => env('FCM_SENDER_ID'),
			],
		]);

		try {
			// JSON 요청 전송 후 JSON 응답 수신
			$fcm_response = $fcmClient->request('POST', 'fcm/send', [
				'json' => [
					'to' => $firebase_key,
					'notification' => [
						'title' => $request->title,
						'body' => $request->content,
					],
				]
			]);
			$fcm_response_json = json_decode($fcm_response->getBody(), true);

			try {
				// fcm 메시지 응답, 실패 시에만 error 속성이 존재
				if ($fcm_response_json['results']['0']['error'] == 'NotRegistered') {
					// 키에 해당하는 기기가 없으면 DB에서 사용자 키 삭제
					DB::select(
						'CALL koreaitedu.firebase_delete_key(?);',
						array(
							$firebase_key
						)
					);
				}

				$result['MESSAGE'] = $result['MESSAGE'] . '푸시 전송에 실패했습니다.\n';
				$result['RESULT'] = '420';
			} catch (\Throwable $th) {
				// 성공 시에는 error 속성이 존재하지 않으므로 접근 시 에러 처리됨
				$result['MESSAGE'] = $result['MESSAGE'] . '푸시 전송에 성공했습니다.\n';
				$result['RESULT'] = '110';
			}
		} catch (\Throwable $th) {
			$result['MESSAGE'] = $result['MESSAGE'] . '푸시 전송에 실패했습니다.\n';
			$result['RESULT'] = '500';
		}

		return $result;
	}
}
