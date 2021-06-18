<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class _Cookie
{
	/**
	 * 로그인 쿠키 확인 후 없으면 로그인 페이지로 리다이렉트
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next)
	{
		// 로그인 관련 페이지로 진입 시 통과
		if (
			$request->segment(1) == 'admin' &&
			$request->segment(2) == 'user'
		) {
			return $next($request);
		}

		// 로그인 쿠키 확인
		$id = Cookie::get('admin_id');

		// 쿠키가 없으면 로그인 페이지로 리다이렉트
		if ($id == null) {
			return redirect('admin/user/login');
		}
		// 쿠키가 있으면 통과
		else {
			return $next($request);
		}
	}
}
