<?php

namespace App\Http\Controllers\_Api\_Reply;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 댓글 생성
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_reply.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/reply/write/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		board_id			44						글 고유 번호	필수
 * 		user_id				20073004				학번			필수
 * 		reply_content		댓글입니다.				댓글 내용			필수
 * 		parent_reply		1						부모 댓글 번호
 *
 * 결과
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		reply_id			8						글 고유 번호
 *
 */

class _ApiReplyWrite extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$db_result = DB::select(
				'CALL koreaitedu.reply_write(?,?,?,?);',
				array(
					$request->board_id,
					$request->user_id,
					$request->reply_content,
					$request->parent_reply,
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
