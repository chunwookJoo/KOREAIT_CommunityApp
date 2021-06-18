<?php

namespace App\Http\Controllers\_Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _Notify extends Controller
{
	public function __invoke(Request $request)
	{
		$method = strtolower($request->method());
		if ($method == 'get') {
			try {
				$curl = new CurlController();

				// curl을 사용한 API Response 가져오기
				$url = env("URL_MAJOR", null);
				$response_college = $curl->curlGet($url);

				$url = env("URL_MINOR", null);

				$response_depart = [];
				foreach ($response_college as $college) {
					array_push($response_depart, [
						'sosokCode' => $college['sosokCode'],
						'minor' => $curl->curlGet($url . $college['sosokCode']),
					]);
				}

				$db_result_user = DB::select(
					'CALL koreaitedu.user_get_role(?);',
					[$request->cookie('admin_id')]
				);

				$db_result = DB::select(
					'CALL koreaitedu.firebase_get_sosok(?,?,?);',
					array(
						$request->college ?? (($db_result_user[0]->college == "") ? null : $db_result_user[0]->college),
						$request->depart,
						$request->year,
					)
				);

				return view(
					'_admin._notify',
					[
						'request' => $request,
						'result_firebase' => $db_result ?? null,
						'result_college' => $response_college,
						'result_depart' => $response_depart,
						'result_year' => [1, 2, 3],
						'result_user' => $db_result_user[0],
					]
				);
			} catch (\Throwable $th) {
				Log::error($th);
				return redirect()->back()->with('alert', '시스템 오류가 발생했습니다.');
			}
		} else if ($method == 'post') {
			$httpClient = new Client([
				'base_uri' => env('FCM_BASE_URL'),
				'headers' => [
					'Authorization' => "key=" . env('FCM_SERVER_TOKEN'),
					'Content-Type' => 'application/json',
					'project_id' => env('FCM_SENDER_ID'),
				],
			]);

			try {
				$success = 0;
				$failed = 0;

				$db_result_message_id = DB::select(
					'CALL koreaitedu.firebase_add_message(?,?);',
					array(
						$request->title,
						$request->body,
					)
				);

				$message_id = $db_result_message_id[0]->message_id;

				DB::select(
					'CALL koreaitedu.firebase_add_sender_entry(?,?);',
					array(
						$message_id,
						$request->cookie('admin_id')
					)
				);

				foreach ($request->notification as $student_id => $firebase_key) {
					$fcm_request = new Psr7Request('POST', 'fcm/send', [], json_encode([
						'to' => $firebase_key,
						'notification' => [
							'title' => $request->title,
							'body' => $request->body,
						],
					]));

					DB::select(
						'CALL koreaitedu.firebase_add_receiver_entry(?,?);',
						array(
							$message_id,
							$student_id
						)
					);

					$fcm_response = $httpClient->send($fcm_request);
					$fcm_response_json = json_decode($fcm_response->getBody(), true);

					try {
						if ($fcm_response_json['results']['0']['error'] == 'NotRegistered') {
							$db_result = DB::select(
								'CALL koreaitedu.firebase_delete_key(?);',
								array(
									$firebase_key
								)
							);
							$failed++;
						}
					} catch (\Throwable $th) {
						$success++;
					}
				}

				$fcm_result = [
					'success' => $success,
					'failed' => $failed,
				];

				return redirect()
					->route(
						'_Notify',
						[
							'college' => $request->college,
							'depart' => $request->depart,
							'year' => $request->year,
							'result' => $fcm_result,
						]
					)->with('alert', '성공: ' . $success . '\n실패: ' . $failed);
			} catch (\Throwable $th) {
				Log::error($th);
				return redirect()->back()->with('alert', '시스템 오류가 발생했습니다.');
			}
		}
	}
}
