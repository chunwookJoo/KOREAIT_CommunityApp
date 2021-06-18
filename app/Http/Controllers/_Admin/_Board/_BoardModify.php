<?php

namespace App\Http\Controllers\_Admin\_Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _BoardModify extends Controller
{
	public function __invoke(Request $request)
	{
		$method = strtolower($request->method());
		if ($method == 'get') {
			try {
				$db_result = DB::select(
					'CALL koreaitedu.board_get_detail(?);',
					[$request->board_id]
				);
				return view(
					'_admin._board._edit',
					[
						'board_id' => $request->board_id,
						'result_board' => $db_result[0],
						'result_group' => null,
						'result_college' => null,
						'result_depart' => null,
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

			try {
				$db_result = DB::select(
					'CALL koreaitedu.board_modify(?,?,?,?,?,?,?);',
					array(
						$request->board_id,
						$user_id,
						$request->board_title,
						$request->board_content,
						$is_notice,
						$request->college,
						$request->depart,
					)
				);
				return redirect()
					->route(
						'_BoardView',
						['board_id' => $request->board_id]
					)->with('alert', '게시물 수정 완료');
			} catch (\Throwable $th) {
				Log::error($th);
				return redirect()->back()
					->with('alert', '시스템 오류가 발생했습니다.');
			}
		}
	}
}
