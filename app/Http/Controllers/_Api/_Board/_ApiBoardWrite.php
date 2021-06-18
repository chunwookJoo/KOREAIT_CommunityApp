<?php

namespace App\Http\Controllers\_Api\_Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 게시물 생성
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_board.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/board/write/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		board_group			901						게시판 코드		필수
 * 		user_id				20073004				학번			필수
 * 		board_title			API 테스트				글 제목			필수
 * 		board_content		밥 먹으러 집에 갑니다.	글 내용			필수
 * 		board_is_notice		on						공지 여부	 	"on" / NULL
 *
 * 결과
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		board_id			8						글 고유 번호
 *
 */

class _ApiBoardWrite extends Controller
{
	public function __invoke(Request $request)
	{
		// 공지 여부 확인
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
				'CALL koreaitedu.board_write(?,?,?,?,?,?,?);',
				array(
					$request->board_group,
					$request->user_id,
					$request->board_title,
					$request->board_content,
					$is_notice,
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
