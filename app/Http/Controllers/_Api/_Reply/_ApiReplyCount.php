<?php

namespace App\Http\Controllers\_Api\_Reply;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 댓글 레코드 수 및 페이지 수
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_reply.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/reply/count/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		board_id			44						글 고유 번호	필수
 * 		page_size			20						목록 크기		필수
 *
 * 결과 (단일)
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		RESULT				100						조회 성공
 * 							400						게시물 없음
 * 							500						내부 오류
 * 		record_count		21						전체 레코드 수
 * 		page_count			2						전체 페이지 수
 *
 */

class _ApiReplyCount extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$db_result = DB::select(
				'CALL koreaitedu.reply_get_count(?,?);',
				array(
					$request->board_id,
					$request->page_size,
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
