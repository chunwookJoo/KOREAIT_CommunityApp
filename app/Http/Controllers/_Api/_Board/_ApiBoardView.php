<?php

namespace App\Http\Controllers\_Api\_Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 게시물 내용
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_board.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/board/view/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		board_id			7						글 고유 번호	필수
 *
 * 결과
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		board_group			901						게시판 코드
 * 		board_name			"자유 게시판"			게시판 이름
 * 		title				"테스트"				글 제목
 * 		author				"박경용"				작성자			이름 또는 별명
 * 		content				"흑흑 개발은 힘들다."	글 내용
 * 		time_write			"2021-01-13 17:36:21"	게시 시각
 * 		time_modify			"2021-01-13 18:41:55"	수정 시각
 * 		is_notice			1						공지 글 여부	1 / 0
 * 		readnum				6						조회 수
 *
 */

class _ApiBoardView extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$db_result = DB::select(
				'CALL koreaitedu.board_get_detail(?);',
				array($request->board_id)
			);
			return response()->json($db_result[0]);
		} catch (\Throwable $th) {
			Log::error($th);
			$db_result = ['RESULT' => '500'];
			return response()->json($db_result);
		}
	}
}
