<?php

use App\Http\Controllers\_Admin\_Home;
use App\Http\Controllers\_Admin\_Main;
use App\Http\Controllers\_Admin\_Notify;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Web Routes
|--------------------------------------------------------------------------
|
| 웹 주소: https://app.koreait.kr/admin/
| prefix 그룹: 'admin' ("/app/Providers/RouteServiceProvider.php" 파일 내
|			boot() 함수 내 $this->routes() 함수 내 Route::prefix('admin') 참고)
| 미들웨어 그룹: 'admin' ("/app/Http/Kernel.php" 파일의 $middlewareGroups 참고)
|
*/

Route::prefix('user')->group(base_path('routes/_admin/_web/_user.php'));		// 사용자 관련 라우트
Route::prefix('board')->group(base_path('routes/_admin/_web/_board.php'));		// 게시판 관련 라우트
Route::prefix('role')->group(base_path('routes/_admin/_web/_role.php'));		// 역할 관련 라우트
Route::prefix('log')->group(base_path('routes/_admin/_web/_log.php'));			// 로그 관련 라우트

Route::match(['get', 'post'], '/notify', _Notify::class)->name('_Notify');
Route::get('/main', _Main::class)->name('_Main');
Route::get('/home', function () {
	return redirect('admin/board/list');
})->name('_Home');
Route::get('/login', function () {
	return redirect('admin/user/login');
});
