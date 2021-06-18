<?php

namespace App\Http\Controllers\_Admin\_User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _UserMessageDelete extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			DB::statement(
				'CALL koreaitedu.firebase_delete_sender_entry(?,?);',
				[
					$request->message_id,
					$request->cookie('admin_id'),
				]
			);
			return redirect()->route('_UserMessageList')->with('alert', '메시지 삭제 완료');
		} catch (\Throwable $th) {
			Log::error($th);
			return redirect()->back()
				->with('alert', '시스템 오류가 발생했습니다.');
		}
	}
}
