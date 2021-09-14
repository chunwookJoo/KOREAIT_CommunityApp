<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| API 주소: https://app.koreait.kr/article/
| prefix 그룹: 'article' ("/app/Providers/RouteServiceProvider.php" 파일 내
|			boot() 함수 내 $this->routes() 함수 내 Route::prefix('article') 참고)
| 미들웨어 그룹: 'api' ("/app/Http/Kernel.php" 파일의 $middlewareGroups 참고)
|
*/

Route::prefix("board")->group(base_path("routes/_admin/_api/_board.php")); // 게시판 관련 API
Route::prefix("notice")->group(base_path("routes/_admin/_api/_notice.php")); // 공지 관련 API
Route::prefix("reply")->group(base_path("routes/_admin/_api/_reply.php")); // 댓글 관련 API
Route::prefix("user")->group(base_path("routes/_admin/_api/_user.php")); // 사용자 관련 API
Route::prefix("test")->group(base_path("routes/_admin/_api/_test.php")); // 테스트용
