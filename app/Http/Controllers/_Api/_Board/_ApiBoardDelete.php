<?php

namespace App\Http\Controllers\_Api\_Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 게시물 삭제
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_board.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/board/delete/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 *		board_id			8						글 고유 번호	필수
 * 		user_id				20073004				접속자 학번		필수, 확인용
 *
 * 결과
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		RESULT				100						성공
 * 							400						게시물 없음
 * 							410						학번 틀림		게시자 학번 필요
 * 							500						내부 오류
 *
 */
class _ApiBoardDelete extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$db_result = DB::select(
				'CALL koreaitedu.board_delete(?,?);',
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
