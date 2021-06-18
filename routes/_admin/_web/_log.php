<?php

use App\Http\Controllers\_Admin\_Log\_LogApp;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Web Routes
|--------------------------------------------------------------------------
|
| 웹 주소: https://app.koreait.kr/admin/log/
| prefix 그룹: 'admin/log' ("/routes/_admin/_web.php" 파일의 Route::prefix('log') 참고)
| 미들웨어 그룹: 'admin' ("/app/Http/Kernel.php" 파일의 $middlewareGroups 참고)
| 컨트롤러: "/app/Http/Controllers/_Admin/_log" 경로 참고)
|
*/

Route::get('/app', _LogApp::class)->name('_LogApp');		// 앱 로그 보기
Route::get('/admin', _LogApp::class)->name('_LogAdmin');	// 관리자 로그 보기
