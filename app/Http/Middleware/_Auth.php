<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _Auth
{
	/**
	 * DB에서 권한 조회, 접근 권한이 없으면
	 * 로그인 페이지로 리다이렉트
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	// DB에서 권한 검사
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

		try {
			// DB에서 권한 조회
			$db_result = DB::select(
				'CALL koreaitedu.user_get_role(?);',
				array($id)
			);
			// 관리자 페이지 접근 권한 확인 시 통과
			if ($db_result[0]->role_id < 900) {
				return $next($request)
					->cookie('admin_id', $id, 30);
			}
			// 권한이 없으면 로그인 페이지로 리다이렉트
			else {
				return redirect('admin/user/login');
			}
		} catch (\Throwable $th) {
			// 에러 발생 시 로그인 페이지로 리다이렉트
			Log::error($th);
			return redirect('admin/user/login');
		}
	}
}
