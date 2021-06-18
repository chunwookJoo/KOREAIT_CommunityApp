<?php

use App\Http\Controllers\_Api\_Notice\_ApiNoticeCount;
use App\Http\Controllers\_Api\_Notice\_ApiNoticeGroup;
use App\Http\Controllers\_Api\_Notice\_ApiNoticeList;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| API 주소: https://app.koreait.kr/article/notice/
| prefix 그룹: 'article/notice' ("/routes/_admin/_api.php" 파일의 Route::prefix('notice') 참고)
| 미들웨어 그룹: 'api' ("/app/Http/Kernel.php" 파일의 $middlewareGroups 참고)
| 컨트롤러: "/app/Http/Controllers/_Api/_Notice" 경로 참고)
|
*/

Route::post('/group', _ApiNoticeGroup::class);	// 공지 게시 가능 게시판 목록
Route::post('/count', _ApiNoticeCount::class);	// 공지 게시물 페이징
Route::post('/list', _ApiNoticeList::class);	// 공지 게시물 목록
