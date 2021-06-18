<?php

namespace App\Http\Controllers\_Api\_Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 학부 게시판 레코드 수 및 페이지 수
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_board.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/board/colcnt/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		college				융합스마트				학부 이름		필수
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

class _ApiBoardCollegeCount extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$db_result = DB::select(
				'CALL koreaitedu.board_get_college_count(?,?,?,?);',
				array(
					$request->college,
					$request->page_size,
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
