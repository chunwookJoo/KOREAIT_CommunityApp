<?php

namespace App\Http\Controllers\_Api\_Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 페이징을 위한 레코드 수 및 페이지 수
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_board.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/board/mycount/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		board_group			901						게시판 코드		필수
 * 		user_id				20073004				사용자 학번		필수
 * 		page_size			20						목록 크기		필수
 * 		search_key			title					제목
 * 							content					내용
 * 							title+content			제목+내용
 * 		search_value		테스트					검색어
 *
 * 결과
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		record_count		21						전체 레코드 수
 * 		page_count			2						전체 페이지 수
 *
 */

class _ApiBoardMyCount extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			if (
				$request->board_is_notice == 'on' ||
				$request->board_is_notice == 1
			) {
				$is_notice = 1;
			} else {
				$is_notice = 0;
			}

			$db_result = DB::select(
				'CALL koreaitedu.board_get_mycount(?,?,?,?,?,?);',
				array(
					$request->board_group,
					$request->user_id,
					$request->page_size,
					$is_notice,
					$request->search_key,
					$request->search_value,
				)
			);
			return response()->json($db_result[0]);
		} catch (\Throwable $th) {
			Log::error($th);
			$db_result = ['RESULT' => '500'];
			return response()->json($db_result);
		}
	}
}
