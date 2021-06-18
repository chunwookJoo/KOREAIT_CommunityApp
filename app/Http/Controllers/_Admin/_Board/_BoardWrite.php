<?php

namespace App\Http\Controllers\_Admin\_Board;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _BoardWrite extends Controller
{
	public function __invoke(Request $request)
	{
		$method = strtolower($request->method());
		if ($method == 'get') {

			$curl = new CurlController();

			// curl을 사용한 API Response 가져오기
			$url = env("URL_MAJOR", false);
			$response_college = $curl->curlGet($url);

			$url = env("URL_MINOR", false);
			$response_depart = [];
			foreach ($response_college as $college) {
				array_push($response_depart, [
					'sosokCode' => $college['sosokCode'],
					'minor' => $curl->curlGet($url . $college['sosokCode']),
				]);
			}

			try {
				$db_result = [
					DB::select(
						'CALL koreaitedu.notice_get_group(?);',
						[$request->cookie('admin_id')]
					), DB::select(
						'CALL koreaitedu.board_get_group();'
					)
				];
				return view(
					'_admin._board._edit',
					[
						'board_id' => null,
						'result_board' => null,
						'result_group' => $db_result,
						'result_college' => $response_college,
						'result_depart' => $response_depart,
					]
				);
			} catch (\Throwable $th) {
				Log::error($th);
				return redirect()->back()
					->with('alert', '시스템 오류가 발생했습니다.');
			}
		} else if ($method == 'post') {
			$user_id = Cookie::get('admin_id');

			if (
				$request->board_is_notice == 'on' ||
				$request->board_is_notice == 1
			) {
				$is_notice = 1;
			} else {
				$is_notice = 0;
			}

			if ($request->board_group == 701) {
				$college = $request->college;
				$depart = null;
			} else if ($request->board_group == 702) {
				$college = $request->college;
				$depart = $request->depart;
			} else {
				$college = null;
				$depart = null;
			}

			try {
				$db_result = DB::select(
					'CALL koreaitedu.board_write(?,?,?,?,?,?,?);',
					array(
						$request->board_group,
						$user_id,
						$request->board_title,
						$request->board_content,
						$is_notice,
						$college,
						$depart,
					)
				);
				return redirect()
					->route(
						'_BoardView',
						['board_id' => $db_result[0]->board_id]
					)->with('alert', '게시물 작성 완료');
			} catch (\Throwable $th) {
				Log::error($th);
				return redirect()->back()
					->with('alert', '시스템 오류가 발생했습니다.');
			}
		}
	}
}
