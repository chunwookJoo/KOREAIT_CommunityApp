<?php

namespace App\Http\Controllers\_Api\_User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 학부/학과별 명단 조회
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_user.php" 파일 참고
 *
 * 호출 (GET), https://app.koreait.kr/article/user/attend/list/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		sosok_code			"1"						정보보안		필수
 * 							"3"						게임
 * 							"E"						인공지능
 * 							"F"						디지털디자인
 * 							"11"					컴퓨터보안
 * 							"185"					해킹
 * 							"191"					융합보안
 * 							"192"					디지털포렌식
 * 							"193"					정보보안
 * 							"31"					게임기획
 * 							"310"					게임아트디자인
 * 							"311"					게임인공지능프로그래밍
 * 							"32"					게임프로그래밍
 * 							"37"					게임그래픽
 * 							"E1"					컴퓨터공학
 * 							"E2"					드론로봇
 * 							"E3"					사물인터넷
 * 							"E4"					소프트웨어공학
 * 							"E5"					빅데이터인공지능
 * 							"F1"					시각디자인
 * 							"F2"					만화애니메이션
 * 							"F3"					멀티미디어
 * 							"F4"					일러스트레이션
 * 							"F5"					웹툰
 *
 * 결과 (목록)
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		user_name			"박경용"				사용자 이름
 * 		nickname			NULL					사용자 별명
 * 		college				"융합스마트"			사용자 계열
 * 		depart				"컴퓨터공학"			사용자 학과
 * 		year				1						사용자 학년		DB에 rank로 조회
 *
 */

class _ApiUserAttendList extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$curl = new CurlController();
			$response = null;

			if ($request->sosok_code != 'ALL')
				// 학사 API에서 출석 명단 조회
				$response = $curl->curlGet(env('URL_ATTEND_LIST') . $request->sosok_code);
			else {
				// 학사 API에서 학부 명단 조회
				$response = array();
				$url = env("URL_MAJOR", null);
				$response_college = $curl->curlGet($url);

				foreach ($response_college as $college) {
					$response = array_merge($response, $curl->curlGet(env('URL_ATTEND_LIST') . $college['sosokCode']));
				}
			}

			return response()->json($response);
		} catch (\Throwable $th) {
			Log::error($th);
			$db_result = ['RESULT' => '500'];
			return response()->json($db_result);
		}
	}
}
