<?php

namespace App\Http\Controllers\_Api\_Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 게시물 좋아요 누르기
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_board.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/board/like/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		board_id			44						글 고유 번호	필수
 * 		user_id				20073004				사용자 학번		필수
 *
 * 결과 (단일)
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		RESULT				100						삽입 성공
 * 							110						삭제 성공
 * 							400						게시물 없음
 * 							410						사용자 없음
 * 							500						내부 오류
 *
 */

class _ApiBoardLike extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$db_result = DB::select(
				'CALL koreaitedu.board_set_like(?,?);',
				array(
					$request->board_id,
					$request->user_id,
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
