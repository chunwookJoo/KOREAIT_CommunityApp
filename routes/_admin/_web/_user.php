<?php

use App\Http\Controllers\_Admin\_User\_UserLogin;
use App\Http\Controllers\_Admin\_User\_UserLogout;
use App\Http\Controllers\_Admin\_User\_UserMessageDelete;
use App\Http\Controllers\_Admin\_User\_UserMessageList;
use App\Http\Controllers\_Admin\_User\_UserMessageView;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Web Routes
|--------------------------------------------------------------------------
|
| 웹 주소: https://app.koreait.kr/admin/user/
| prefix 그룹: 'admin/user' ("/routes/_admin/_web.php" 파일의 Route::prefix('user') 참고)
| 미들웨어 그룹: 'admin' ("/app/Http/Kernel.php" 파일의 $middlewareGroups 참고)
| 컨트롤러: "/app/Http/Controllers/_Admin/_User" 경로 참고)
|
*/

Route::match(['get', 'post'], '/login', _UserLogin::class)->name('_UserLogin');	// 사용자 로그인
Route::get('/logout', _UserLogout::class)->name('_UserLogout');					// 사용자 로그아웃
Route::get('/message/list', _UserMessageList::class)->name('_UserMessageList');					// 사용자 로그아웃
Route::get('/message/view', _UserMessageView::class)->name('_UserMessageView');					// 사용자 로그아웃
Route::post('/message/delete', _UserMessageDelete::class)->name('_UserMessageDelete');					// 사용자 로그아웃
