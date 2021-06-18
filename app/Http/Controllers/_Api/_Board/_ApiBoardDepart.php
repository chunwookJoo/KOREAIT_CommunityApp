<?php

namespace App\Http\Controllers\_Api\_Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 학과 게시물 목록
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_board.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/board/depart/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		college				융합스마트				학부 이름		필수
 * 		depart				컴퓨터공학				학과 이름		필수
 * 		page_num			1						목록 번호		필수
 * 		page_size			20						목록 크기		필수
 * 		search_key			title					제목
 * 							content					내용
 * 							title+content			제목+내용
 * 		search_value		테스트					검색어
 *
 * 결과
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		board_id			7						글 고유 번호
 * 		title				"테스트"				제목
 * 		reply_count			1						댓글 수
 * 		author				"박경용"				작성자			이름 또는 별명
 * 		readnum				0						조회수
 * 		like_count			1						좋아요 수
 * 		time_write			"2021-01-13 17:36:21"	작성 시간
 *
 */

class _ApiBoardDepart extends Controller
{
	public function __invoke(Request $request)
	{
		$page_offset = ($request->page_num - 1) * $request->page_size;

		try {
			$db_result = DB::select(
				'CALL koreaitedu.board_get_depart(?,?,?,?,?,?);',
				array(
					$request->college,
					$request->depart,
					$page_offset,
					$request->page_size,
					$request->search_key,
					$request->search_value,
				)
			);
			return response()->json($db_result);
		} catch (\Throwable $th) {
			Log::error($th);
			$db_result = ['RESULT' => '500'];
			return response()->json($db_result);
		}
	}
}
