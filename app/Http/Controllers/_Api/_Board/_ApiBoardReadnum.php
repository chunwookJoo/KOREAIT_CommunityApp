<?php

namespace App\Http\Controllers\_Api\_Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 게시물 조회 수 올리기
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_board.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/board/readnum/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		board_id			7						글 고유 번호	필수
 *
 * 결과
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		RESULT				100						성공
 * 							400						게시글 없음
 * 							500						내부 오류
 *
 */

class _ApiBoardReadnum extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$db_result = DB::select(
				'CALL koreaitedu.board_read(?);',
				array($request->board_id)
			);
			return response()->json($db_result[0]);
		} catch (\Throwable $th) {
			Log::error($th);
			$db_result = ['RESULT' => 500];
			return response()->json($db_result);
		}
	}
}
