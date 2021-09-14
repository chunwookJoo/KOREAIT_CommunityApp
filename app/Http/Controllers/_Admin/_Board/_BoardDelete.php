<?php

namespace App\Http\Controllers\_Admin\_Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _BoardDelete extends Controller
{
	public function __invoke(Request $request)
	{
		$db_params = [$request->board_id, $request->cookie("admin_id")];

		try {
			DB::statement("CALL koreaitedu.board_delete(?,?);", $db_params);
			return redirect()
				->route("_BoardList")
				->with("alert", "게시물 삭제 완료");
		} catch (\Throwable $th) {
			Log::error($th);
			return redirect()
				->back()
				->with("alert", "시스템 오류가 발생했습니다.");
		}
	}
}
