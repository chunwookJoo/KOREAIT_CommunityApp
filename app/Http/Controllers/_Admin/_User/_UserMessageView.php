<?php

namespace App\Http\Controllers\_Admin\_User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class _UserMessageView extends Controller
{
	public function __invoke(Request $request)
	{
		$user_id = $request->cookie('admin_id');

		try {
			// 자기 자신의 게시물인지 확인
			$db_result = DB::select(
				'CALL koreaitedu.firebase_get_message(?);',
				[
					$request->message_id,
				]
			);

			return view(
				'_admin._user._messageView',
				[
					'message_id' => $request->message_id,
					'request' => $request,
					'result' => $db_result[0],
				]
			);
		} catch (\Throwable $th) {
			Log::error($th);
			return redirect()->back()
				->with('alert', '시스템 오류가 발생했습니다.');
		}
	}
}
