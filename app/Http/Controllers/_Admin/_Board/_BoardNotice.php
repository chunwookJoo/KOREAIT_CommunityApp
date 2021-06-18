<?php

namespace App\Http\Controllers\_Admin\_Board;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _BoardNotice extends Controller
{
	public function __invoke(Request $request)
	{
		$method = strtolower($request->method());
		if ($method == 'get') {
			$page_size = 15;

			if ($request->page_num) {
				$page_num = $request->page_num;
				$offset = ($request->page_num - 1)
					* $page_size;
			} else {
				$page_num = 1;
				$offset = 0;
			}

			try {
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

				$db_result_user = DB::select(
					'CALL koreaitedu.user_get_role(?);',
					[$request->cookie('admin_id')]
				);

				$db_result_group = DB::select(
					'CALL koreaitedu.notice_get_group(?);',
					[$request->cookie('admin_id')]
				);

				$db_result_notice = DB::select(
					'CALL koreaitedu.notice_get_list(?,?,?,?,?,?);',
					[
						$request->board_group ?? 701,
						0,
						30,
						null,
						$request->college ?? $db_result_user[0]->college,
						$request->depart ?? $db_result_user[0]->depart,
					]
				);

				if ($request->board_group >= 900) {
					$db_result_list = DB::select(
						'CALL koreaitedu.board_get_list(?,?,?,?,?);',
						[
							$request->board_group ?? 0,
							$offset,
							$page_size,
							$request->search_key,
							$request->search_value,
						]
					);
					$db_result_count = DB::select(
						'CALL koreaitedu.board_get_count(?,?,?,?);',
						[
							$request->board_group ?? 0,
							$page_size,
							$request->search_key,
							$request->search_value,
						]
					);
				} else if ($request->board_group == 702) {
					$db_result_list = DB::select(
						'CALL koreaitedu.board_get_depart(?,?,?,?,?,?);',
						[
							$request->college,
							$request->depart,
							$offset,
							$page_size,
							$request->search_key,
							$request->search_value,
						]
					);
					$db_result_count = DB::select(
						'CALL koreaitedu.board_get_depart_count(?,?,?,?,?);',
						[
							$request->college,
							$request->depart,
							$page_size,
							$request->search_key,
							$request->search_value,
						]
					);
				} else {
					$db_result_list = DB::select(
						'CALL koreaitedu.board_get_college(?,?,?,?,?);',
						[
							$request->college ?? $db_result_user[0]->college,
							$offset,
							$page_size,
							$request->search_key,
							$request->search_value,
						]
					);
					$db_result_count = DB::select(
						'CALL koreaitedu.board_get_college_count(?,?,?,?);',
						[
							$request->college ?? $db_result_user[0]->college,
							$page_size,
							$request->search_key,
							$request->search_value,
						]
					);
				}

				$page_count = $db_result_count[0]->page_count;
				$result_page = [
					($page_num - 10 >= $page_count - 10) ? (($page_num - 10 > 0) ? ($page_num - 10) : null) : null,
					($page_num - 9 >= $page_count - 10) ? (($page_num - 9 > 0) ? ($page_num - 9) : null) : null,
					($page_num - 8 >= $page_count - 10) ? (($page_num - 8 > 0) ? ($page_num - 8) : null) : null,
					($page_num - 7 >= $page_count - 10) ? (($page_num - 7 > 0) ? ($page_num - 7) : null) : null,
					($page_num - 6 >= $page_count - 10) ? (($page_num - 6 > 0) ? ($page_num - 6) : null) : null,
					($page_num - 5 > 0) ? ($page_num - 5) : null,
					($page_num - 4 > 0) ? ($page_num - 4) : null,
					($page_num - 3 > 0) ? ($page_num - 3) : null,
					($page_num - 2 > 0) ? ($page_num - 2) : null,
					($page_num - 1 > 0) ? ($page_num - 1) : null,
					$page_num,
					($page_num + 1 <= $page_count) ? ($page_num + 1) : null,
					($page_num + 2 <= $page_count) ? ($page_num + 2) : null,
					($page_num + 3 <= $page_count) ? ($page_num + 3) : null,
					($page_num + 4 <= $page_count) ? ($page_num + 4) : null,
					($page_num + 5 <= $page_count) ? ($page_num + 5) : null,
					($page_num + 6 <= 11) ? (($page_num + 6 <= $page_count) ? ($page_num + 6) : null) : null,
					($page_num + 7 <= 11) ? (($page_num + 7 <= $page_count) ? ($page_num + 7) : null) : null,
					($page_num + 8 <= 11) ? (($page_num + 8 <= $page_count) ? ($page_num + 8) : null) : null,
					($page_num + 9 <= 11) ? (($page_num + 9 <= $page_count) ? ($page_num + 9) : null) : null,
					($page_num + 10 <= 11) ? (($page_num + 10 <= $page_count) ? ($page_num + 10) : null) : null,
				];

				return view(
					'_admin._board._notice',
					[
						'request' => $request,
						'result_group' => $db_result_group,
						'result_college' => $response_college,
						'result_depart' => $response_depart,
						'result_notice' => $db_result_notice,
						'result_list' => $db_result_list,
						'result_page' => $result_page,
						'result_user' => $db_result_user[0],
					]
				);
			} catch (\Throwable $th) {
				Log::error($th);
				return redirect()->back()->with('alert', '시스템 오류가 발생했습니다.');
			}
		} else if ($method == 'post') {
			$user_id = Cookie::get('admin_id');

			try {
				foreach ($request->board_id as $key => $value) {
					$db_result = DB::select(
						'CALL koreaitedu.notice_switch(?,?,?);',
						array(
							$key,
							$user_id,
							($value == "on") ? 1 : 0,
						)
					);
				}
				return redirect()
					->route(
						'_BoardNotice',
						[
							'board_group' => $request->board_group,
							'college' => $request->college,
							'depart' => $request->depart,
							'search_key' => $request->search_key,
							'search_value' => $request->search_value,
						]
					);
			} catch (\Throwable $th) {
				Log::error($th);
				return redirect()->back()
					->with('alert', '시스템 오류가 발생했습니다.');
			}
		}
	}
}
