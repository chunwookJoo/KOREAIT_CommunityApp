<?php

use App\Http\Controllers\_Api\_User\_ApiUserSignature;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| API 주소: https://app.koreait.kr/article/user/signature/
| prefix 그룹: 'article/notice' ("/routes/_admin/_api.php" 파일의 Route::prefix('signature') 참고)
| 미들웨어 그룹: 'api' ("/app/Http/Kernel.php" 파일의 $middlewareGroups 참고)
|
*/

Route::get("/{student_id}", [_ApiUserSignature::class, "get"]);
Route::get("/{student_id}/{file_name}", [_ApiUserSignature::class, "get"]);
Route::post("/", [_ApiUserSignature::class, "post"]);
Route::delete("/{student_id}", [_ApiUserSignature::class, "delete"]);
Route::delete("/{student_id}/{file_name}", [
	_ApiUserSignature::class,
	"delete",
]);
