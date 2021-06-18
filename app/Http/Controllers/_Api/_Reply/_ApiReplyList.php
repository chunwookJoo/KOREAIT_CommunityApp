<?php

namespace App\Http\Controllers\_Api\_Reply;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 댓글 목록
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_reply.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/reply/list/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		board_id			44						글 고유 번호	필수
 * 		user_id				20073004				접속자 학번		필수
 * 		page_num			1						목록 번호		필수
 * 		page_size			20						목록 크기		필수
 *
 * 결과 (목록)
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		author				"박경용"				작성자			이름 또는 별명
 * 		content				"댓글입니다."			댓글 내용
 * 		parent_reply		2						부모 댓글 번호
 * 		like_count			1						좋아요 수
 * 		my_like				1						좋아요 여부
 * 		time_write			"2021-01-13 17:36:21"	작성 시간
 *
 */

class _ApiReplyList extends Controller
{
	public function __invoke(Request $request)
	{
		$page_offset = ($request->page_num - 1) * $request->page_size;
		try {
			$db_result = DB::select(
				'CALL koreaitedu.reply_get_list(?,?,?,?);',
				array(
					$request->board_id,
					$request->user_id,
					$page_offset,
					$request->page_size,
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
