<?php

namespace App\Http\Controllers\_Admin;

use App\Http\Controllers\_Api\_ApiRequestSender;
use App\Http\Controllers\_ProcedureController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _Notify extends Controller
{
	public function get(Request $request)
	{
		$id = Cookie::get("admin_id");
		try {
			$curl = CurlController::getInstance();

			// 학사 API에서 학부 정보 가져오기
			$url = env("URL_MAJOR", null);
			$response_college = $curl->curlGet($url);

			// 학사 API에서 학과 정보 가져오기
			$url = env("URL_MINOR", null);
			$response_depart = [];
			foreach ($response_college as $college) {
				$response_depart[$college["sosokCode"]] = $curl->curlGet(
					$url . $college["sosokCode"]
				);
			}

			// 유저 권한 정보 가져오기
			$db_params = [$id];
			$db_controller = new _ProcedureController(
				"user_get_role",
				$db_params
			);
			$db_result_user = $db_controller->query_one();

			// 학부/학과/학년에 따라 명단 가져오기
			$db_params = [
				$request->college ?? ($db_result_user->college ?? null),
				$request->depart,
				$request->year,
			];
			$db_controller = new _ProcedureController(
				"firebase_get_sosok",
				$db_params
			);
			$db_result = $db_controller->query();

			// 할 일: fcm token 은닉
			return view("_admin._notify", [
				"request" => $request,
				"result_firebase" => $db_result ?? null,
				"result_college" => $response_college,
				"result_depart" => $response_depart,
				"result_year" => [1, 2, 3],
				"result_user" => $db_result_user,
			]);
		} catch (\Throwable $th) {
			Log::error($th);
			return redirect()
				->back()
				->with("alert", "시스템 오류가 발생했습니다.");
		}
	}

	public function post(Request $request)
	{
		$id = Cookie::get("admin_id");
		$success = 0;
		$failed = 0;
		try {
			// 메시지 작성 후 ID 반환받기
			$db_params = [$request->title, $request->content];
			$db_controller = new _ProcedureController(
				"firebase_add_message",
				$db_params
			);
			$db_result = $db_controller->query_one();
			$message_id = $db_result->message_id;

			// 메시지 송신자 측에 연결하기
			$db_params = [$message_id, $id];
			$db_controller = new _ProcedureController(
				"firebase_add_sender_entry",
				$db_params
			);
			$db_controller->query();

			foreach ($request->notification as $student_id) {
				// 메시지 수신자 측에 연결하기
				$db_params = [$message_id, $student_id];
				$db_controller = new _ProcedureController(
					"firebase_add_receiver_entry",
					$db_params
				);
				$db_result = $db_controller->query_one();
				Log::info($db_result->firebase_key);

				// 푸시 메시지 보내기
				$result = _ApiRequestSender::send_fcm(
					$request,
					$db_result->firebase_key
				);
				$result["RESULT"] == 110 ? $success++ : $failed++;
			}

			$fcm_result = [
				"success" => $success,
				"failed" => $failed,
			];

			return redirect()
				->route("_Notify", [
					"college" => $request->college,
					"depart" => $request->depart,
					"year" => $request->year,
					"result" => $fcm_result,
				])
				->with("alert", "성공: " . $success . '\n실패: ' . $failed);
		} catch (\Throwable $th) {
			Log::error($th);
			return redirect()
				->back()
				->with("alert", "시스템 오류가 발생했습니다.");
		}
	}
}
