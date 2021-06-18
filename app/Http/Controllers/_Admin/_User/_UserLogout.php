<?php

namespace App\Http\Controllers\_Admin\_User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class _UserLogout extends Controller
{
	public function __invoke()
	{
		// 쿠키 지우기
		Cookie::queue(Cookie::forget('admin_id'));
		return redirect()->route('_UserLogin');
	}
}
