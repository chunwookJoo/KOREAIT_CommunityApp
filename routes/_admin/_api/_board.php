<?php

use App\Http\Controllers\_Api\_Board\_ApiBoardCollege;
use App\Http\Controllers\_Api\_Board\_ApiBoardCollegeCount;
use App\Http\Controllers\_Api\_Board\_ApiBoardCount;
use App\Http\Controllers\_Api\_Board\_ApiBoardDelete;
use App\Http\Controllers\_Api\_Board\_ApiBoardDepart;
use App\Http\Controllers\_Api\_Board\_ApiBoardDepartCount;
use App\Http\Controllers\_Api\_Board\_ApiBoardGroup;
use App\Http\Controllers\_Api\_Board\_ApiBoardIsMine;
use App\Http\Controllers\_Api\_Board\_ApiBoardLike;
use App\Http\Controllers\_Api\_Board\_ApiBoardList;
use App\Http\Controllers\_Api\_Board\_ApiBoardModify;
use App\Http\Controllers\_Api\_Board\_ApiBoardMyCount;
use App\Http\Controllers\_Api\_Board\_ApiBoardMyLike;
use App\Http\Controllers\_Api\_Board\_ApiBoardMyList;
use App\Http\Controllers\_Api\_Board\_ApiBoardReadnum;
use App\Http\Controllers\_Api\_Board\_ApiBoardView;
use App\Http\Controllers\_Api\_Board\_ApiBoardWrite;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| API 주소: https://app.koreait.kr/article/board/
| prefix 그룹: 'article/board' ("/routes/_admin/_api.php" 파일의 Route::prefix('board') 참고)
| 미들웨어 그룹: 'api' ("/app/Http/Kernel.php" 파일의 $middlewareGroups 참고)
| 컨트롤러: "/app/Http/Controllers/_Api/_Board" 경로 참고)
|
*/

Route::get('/group', _ApiBoardGroup::class);			// 게시판 목록
Route::post('/count', _ApiBoardCount::class);			// 게시판 게시물 수, 페이지 수
Route::post('/list', _ApiBoardList::class);				// 게시물 목록
Route::post('/colcnt', _ApiBoardCollegeCount::class);	// 학부 게시판 게시물 수, 페이지 수
Route::post('/college', _ApiBoardCollege::class);		// 학부 게시물 목록
Route::post('/depcnt', _ApiBoardDepartCount::class);	// 학과 게시판 게시물 수, 페이지 수
Route::post('/depart', _ApiBoardDepart::class);			// 학과 게시물 목록
Route::post('/view', _ApiBoardView::class);				// 게시물 내용
Route::post('/readnum', _ApiBoardReadnum::class);		// 게시물 조회 수 올리기
Route::post('/like', _ApiBoardLike::class);				// 게시물 좋아요 누르기
Route::post('/mylike', _ApiBoardMyLike::class);			// 게시물 좋아요 확인
Route::post('/write', _ApiBoardWrite::class);			// 게시물 생성
Route::post('/modify', _ApiBoardModify::class);			// 게시물 수정
Route::post('/delete', _ApiBoardDelete::class);			// 게시물 삭제
Route::post('/ismine', _ApiBoardIsMine::class);			// 게시물 작성자와 접속자 비교
Route::post('/mycount', _ApiBoardMyCount::class);		// 내 게시물 페이징
Route::post('/mylist', _ApiBoardMyList::class);			// 내 게시물 목록
