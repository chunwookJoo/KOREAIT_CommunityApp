<?php

use App\Http\Controllers\_Api\_Reply\_ApiReplyCount;
use App\Http\Controllers\_Api\_Reply\_ApiReplyDelete;
use App\Http\Controllers\_Api\_Reply\_ApiReplyIsMine;
use App\Http\Controllers\_Api\_Reply\_ApiReplyLike;
use App\Http\Controllers\_Api\_Reply\_ApiReplyList;
use App\Http\Controllers\_Api\_Reply\_ApiReplyModify;
use App\Http\Controllers\_Api\_Reply\_ApiReplyWrite;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| API 주소: https://app.koreait.kr/article/reply/
| prefix 그룹: 'article/reply' ("/routes/_admin/_api.php" 파일의 Route::prefix('reply') 참고)
| 미들웨어 그룹: 'api' ("/app/Http/Kernel.php" 파일의 $middlewareGroups 참고)
| 컨트롤러: "/app/Http/Controllers/_Api/_Reply" 경로 참고)
|
*/

Route::post('/count', _ApiReplyCount::class);			// 댓글 게시물 수, 페이지 수
Route::post('/list', _ApiReplyList::class);				// 댓글 목록
Route::post('/like', _ApiReplyLike::class);				// 댓글 좋아요 누르기
Route::post('/write', _ApiReplyWrite::class);			// 댓글 생성
Route::post('/modify', _ApiReplyModify::class);			// 댓글 수정
Route::post('/delete', _ApiReplyDelete::class);			// 댓글 삭제
Route::post('/ismine', _ApiReplyIsMine::class);			// 댓글 작성자와 접속자 비교
