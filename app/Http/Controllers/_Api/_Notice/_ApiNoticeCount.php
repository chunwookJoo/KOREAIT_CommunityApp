<?php

namespace App\Http\Controllers\_Api\_Notice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 공지글 페이징을 위한 레코드 수 및 페이지 수
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_board.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/notice/count/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		board_group			901						게시판 코드		필수
 * 		page_size			20						목록 크기		필수
 *
 * 결과 (단일)
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		RESULT				100						성공
 * 							400						게시판 없음
 * 							500						내부 오류
 * 		record_count		21						전체 레코드 수
 * 		page_count			2						전체 페이지 수
 *
 */

class _ApiNoticeCount extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$db_result = DB::select(
				'CALL koreaitedu.notice_get_count(?,?,?,?,?);',
				array(
					$request->board_group,
					$request->page_size,
					null,
					null,
					null,
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
