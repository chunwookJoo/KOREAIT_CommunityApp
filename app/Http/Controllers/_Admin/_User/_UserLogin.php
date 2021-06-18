<?php

namespace App\Http\Controllers\_Admin\_User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _UserLogin extends Controller
{
	public function __invoke(Request $request)
	{
		$method = strtolower($request->method());
		if ($method == 'get') {
			return view('_admin._user._login');
		} else if ($method == 'post') {
			$ip = $request->ip();

			$id = null;

			// 디버그용 루트 관리자 계정
			if ($request->id == env('ADMIN_ID') && $request->pw == env('ADMIN_PW')) {
				$id = 'koreaitedu';
			} else {
				$id = $request->id;
				$pw = $request->pw;
				$params = $id . '/' . $pw;
				$url = null;

				// API 접속 URL 세팅
				if ($request->position == "student") {
					$url = env("URL_LOGIN", false);
				} else if ($request->position == "staff") {
					$url = env("URL_LOGIN_PROF", false);
				}

				// curl을 사용한 API Response 가져오기
				$curl = new CurlController();
				$response = $curl->curlGet($url . $params);

				if ($response[0]['RESULT'] == 400) {
					return redirect()->back()->with('alert', '계정이 존재하지 않습니다.');
				} else if ($response[0]['RESULT'] == 410) {
					return redirect()->back()->with('alert', '비밀번호 오류입니다.');
				} else if ($response[0]['RESULT'] == 500) {
					return redirect()->back()->with('alert', '시스템 오류가 발생했습니다.');
				} else if ($response[0]['RESULT'] == 100) {
					// 사용자 정보 가져오기
					$user_name = $college = $depart = $rank = $class = null;

					if ($request->position == "student") {
						$user_name = $response[0]['studentName'];
						$rank = $response[0]['gradeYear'];
						$sosok = $response[0]['sosokName'];
						$sosok_array = explode(' ', $sosok);
						$college = $sosok_array[0];
						$depart = $sosok_array[1];
						$class = $response[0]['className'];
					} else if ($request->position == "staff") {
						$user_name = $response[0]['staffName'];
						$rank = $response[0]['title'];;
						$college = str_replace("계열", "", $response[0]['part']);
					}

					try {
						// DB의 사용자 정보 조회
						$db_result = DB::select(
							'CALL koreaitedu.user_get_info(?);',
							array($id)
						);

						if ($db_result[0]->RESULT == 400) {
							// 사용자 등록되지 않음
							DB::statement(
								'CALL koreaitedu.user_set_info(?,?,?,?,?,?);',
								array(
									$id,
									$user_name,
									$college,
									$depart,
									$rank,
									$class,
								)
							);

							DB::statement(
								'CALL koreaitedu.user_set_role(?,?,?);',
								array(
									$id,
									700,
									"role_by_system"
								)
							);
						}

						// 사용자 이름, 계열, 학과, 학년 불일치 시
						else if (
							$db_result[0]->user_name != $user_name ||
							$db_result[0]->college != $college ||
							$db_result[0]->depart != $depart ||
							$db_result[0]->year != $rank ||
							$db_result[0]->class != $class
						) {
							// 사용자 이름, 계열, 학과, 학년 불일치
							DB::statement(
								'CALL koreaitedu.user_set_info(?,?,?,?,?,?);',
								array(
									$id,
									$user_name,
									$college,
									$depart,
									$rank,
									$class,
								)
							);
						}
					} catch (\Throwable $th) {
						Log::error($th);
						return redirect()->route('_Main')->with('alert', '시스템 오류가 발생했습니다.');
					}
				}
			}

			try {
				$db_result = DB::select(
					'CALL koreaitedu.user_get_role(?);',
					array($id)
				);

				// 관리자 페이지 접근 권한 확인, 고급 사용자 이상 필요
				if ($db_result[0]->role_id < 900) {

					// 로그인 내역 기록
					DB::statement('CALL koreaitedu.log_admin(?,?);', array($id, $ip));
					return redirect()
						->route('_Main')
						->cookie('admin_id', $id, 30);
				} else redirect()->back()->with('alert', '접근 권한이 없습니다.');
			} catch (\Throwable $th) {
				Log::error($th);
				return redirect()->route('_Main')->with('alert', '시스템 오류가 발생했습니다.');
			}

			return redirect()->route('_Main')->with('alert', '시스템 오류가 발생했습니다.');;
		}
	}
}
