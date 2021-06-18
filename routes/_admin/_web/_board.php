<?php

use App\Http\Controllers\_Admin\_Board\_BoardDelete;
use App\Http\Controllers\_Admin\_Board\_BoardList;
use App\Http\Controllers\_Admin\_Board\_BoardModify;
use App\Http\Controllers\_Admin\_Board\_BoardMyList;
use App\Http\Controllers\_Admin\_Board\_BoardNotice;
use App\Http\Controllers\_Admin\_Board\_BoardView;
use App\Http\Controllers\_Admin\_Board\_BoardWrite;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Web Routes
|--------------------------------------------------------------------------
|
| 웹 주소: https://app.koreait.kr/admin/board/
| prefix 그룹: 'admin/board' ("/routes/_admin/_web.php" 파일의 Route::prefix('board') 참고)
| 미들웨어 그룹: 'admin' ("/app/Http/Kernel.php" 파일의 $middlewareGroups 참고)
| 컨트롤러: "/app/Http/Controllers/_Admin/_Board" 경로 참고
| 뷰: "/resources/views/_admin/_board" 경로 참고
|
*/

Route::get('/list', _BoardList::class)->name('_BoardList');								// 게시판 보기
Route::get('/mylist', _BoardMyList::class)->name('_BoardMyList');						// 나의 게시물
Route::get('/view/{board_id}', _BoardView::class)->name('_BoardView');					// 게시물 보기
Route::match(['get', 'post'], '/write', _BoardWrite::class)->name('_BoardWrite');		// 게시물 작성
Route::match(['get', 'post'], '/modify', _BoardModify::class)->name('_BoardModify');	// 게시물 수정
Route::match(['get', 'post'], '/notice', _BoardNotice::class)->name('_BoardNotice');	// 공지 관리
Route::post('/delete', _BoardDelete::class)->name('_BoardDelete');						// 게시물 삭제
