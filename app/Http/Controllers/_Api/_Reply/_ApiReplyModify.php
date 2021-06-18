<?php

namespace App\Http\Controllers\_Api\_Reply;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 댓글 수정
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_reply.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/reply/modify/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		reply_id			2						댓글 고유 번호	필수
 * 		user_id				20073004				접속자 학번		필수
 * 		reply_content		댓글 내용				댓글 내용		필수
 *
 * 결과
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		RESULT				100						성공
 * 							400						댓글 없음
 * 							410						학번 틀림		게시자 학번 필요
 * 							500						내부 오류
 *
 */
class _ApiReplyModify extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$db_result = DB::select(
				'CALL koreaitedu.reply_modify(?,?,?);',
				array(
					$request->reply_id,
					$request->user_id,
					$request->reply_content,
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
