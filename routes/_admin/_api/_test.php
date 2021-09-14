<?php

use App\Http\Controllers\_Api\_ApiTest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| API 주소: https://app.koreait.kr/article/test/
| prefix 그룹: 'article/notice' ("/routes/_admin/_api.php" 파일의 Route::prefix('test') 참고)
| 미들웨어 그룹: 'api' ("/app/Http/Kernel.php" 파일의 $middlewareGroups 참고)
|
*/

Route::get('/{student_id}', [_ApiTest::class, 'get']);
Route::get('/{student_id}/{file_name}', [_ApiTest::class, 'get']);
Route::post('/', [_ApiTest::class, 'post']);
Route::delete('/{student_id}', [_ApiTest::class, 'delete']);
Route::delete('/{student_id/{file_name}}', [_ApiTest::class, 'delete']);
