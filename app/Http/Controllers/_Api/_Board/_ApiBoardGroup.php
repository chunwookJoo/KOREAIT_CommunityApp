<?php

namespace App\Http\Controllers\_Api\_Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ======================================================================
 * 게시판 목록
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_board.php" 파일 참고
 *
 * 호출 (GET), https://app.koreait.kr/article/board/group/
 *
 * 결과
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		board_group			901						게시판 코드
 * 		board_name			"자유게시판"			게시판 이름
 *
 */

class _ApiBoardGroup extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$db_result = DB::select(
				'CALL koreaitedu.board_get_group();'
			);
			return response()->json($db_result);
		} catch (\Throwable $th) {
			Log::error($th);
			$db_result = ['RESULT' => '500'];
			return response()->json($db_result);
		}
	}
}
