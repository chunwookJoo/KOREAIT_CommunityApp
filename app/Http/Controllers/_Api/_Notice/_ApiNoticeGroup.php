<?php

namespace App\Http\Controllers\_Api\_Notice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 공지 게시 가능 게시판 목록
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_notice.php" 파일 참고
 *
 * 호출 (POST), https://app.koreait.kr/article/notice/group/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		user_id				20073004				사용자 학번		필수
 *
 * 결과 (목록)
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		board_group			901						게시판 코드
 * 		board_name			"자유게시판"			게시판 이름
 *
 */

class _ApiNoticeGroup extends Controller
{
	public function __invoke(Request $request)
	{
		$user_id = $request->cookie('admin_id');

		try {
			$db_result = DB::select(
				'CALL koreaitedu.notice_get_group(?);',
				[$user_id]
			);
			return response()->json($db_result);
		} catch (\Throwable $th) {
			Log::error($th);
			$db_result = ['RESULT' => '500'];
			return response()->json($db_result);
		}
	}
}
