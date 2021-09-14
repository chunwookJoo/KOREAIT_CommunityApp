<?php

use App\Http\Controllers\Agreement;
use App\Http\Controllers\board\BoardList;
use App\Http\Controllers\board\WritingPage;
use App\Http\Controllers\board\DetailBoardPage;
use App\Http\Controllers\board\ModifiedBoard;
use App\Http\Controllers\board\MyBoardList;
use App\Http\Controllers\board\LikeBoard;
use App\Http\Controllers\Calendar\MainCalendar;
use App\Http\Controllers\SemesterPointController;
use App\Http\Controllers\Job\JobController;
use App\Http\Controllers\Job\JobDetailController;
use App\Http\Controllers\MainPageContorller;
use App\Http\Controllers\Attendance\MainAttendanceController;
use App\Http\Controllers\Hakbu\HakbuBoardList;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Logout_;
use App\Http\Controllers\Preferences\MyProfile;
use App\Http\Controllers\Preferences\AppVersion;
use App\Http\Controllers\Preferences\Alarm;
use App\Http\Controllers\SchoolNoticePage;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginPage\ResetPW;
use App\Http\Controllers\LoginPage\SearchStudentNumber;
use App\Http\Controllers\Evaluation\EvalViewController;
use App\Http\Controllers\Evaluation\EvalQuestionContrller;
use App\Http\Controllers\Evaluation\EvalPostQuestionContrller;
use App\Http\Controllers\MiddleRestApi\RestPassword;
use App\Http\Controllers\Preferences\MessageDetail;
use App\Http\Controllers\Preferences\MessageList;

Route::get("/", function () {
	return view("LoginPage", ["error" => false]);
})
	->middleware("LoginCookie")
	->name("default");
Route::fallback(function () {
	return redirect("/");
})
	->middleware("LoginCookie")
	->name("default");

// 비밀번호 초기화
Route::post("/ResetPassword", [ResetPW::class, "index"])->name("ResetPW");
Route::post("/ResetPassword/API", [ResetPW::class, "api"])->name("ResetPWAPI");

// 동의서
Route::get("/Form/{type}", [Agreement::class, "get"])
	->middleware("CheckLoginCookie")
	->name("Agreement");

// 학번 검색
Route::post("/SearchStudentNumber/API", [
	SearchStudentNumber::class,
	"api",
])->name("SearchStudentNumberAPI");

//로그인 후 제일 처음 페이지
Route::get("/Main", [MainPageContorller::class, "index"])
	->middleware("CheckLoginCookie")
	->name("MainPage");

//일정
Route::get("/Calendar", [MainCalendar::class, "index"])
	->middleware("CheckLoginCookie")
	->name("Calendar");

//학기 점수 확인 class 호출
Route::get("/Haksa/SemesterPoint", [SemesterPointController::class, "index"])
	->middleware("CheckLoginCookie")
	->name("SemesterPoint");

// 출결확인
Route::get("/Haksa/Attend", [MainAttendanceController::class, "index"])
	->middleware("CheckLoginCookie")
	->name("Attend");

// 강의평가 리스트
Route::get("/Haksa/List", [EvalViewController::class, "index"])
	->middleware("CheckLoginCookie")
	->name("EvalList");
Route::get("/Haksa/Question/{haksuCode}/{name}/{subjectName}", [
	EvalQuestionContrller::class,
	"index",
])
	->middleware("CheckLoginCookie")
	->name("EvalQuestion");
Route::post("/Haksa/Eval/Submit", [
	EvalPostQuestionContrller::class,
	"index",
])->name("EvalListPost");

//일자리
Route::get("/Job/{page}", [JobController::class, "index"])
	->middleware("CheckLoginCookie")
	->name("Job");
Route::get("/Job/view/{take_idx}", [JobDetailController::class, "index"])
	->middleware("CheckLoginCookie")
	->name("JobDetail");

Route::get("/Preferences", function () {
	$title = "더보기";
	return view("Preferences.Preferences", compact(["title"]));
})
	->middleware("CheckLoginCookie")
	->name("Preferences");

//상세 공지사항
Route::get("/Notice/{id}", [SchoolNoticePage::class, "index"])
	->middleware("CheckLoginCookie")
	->name("Notice");

//게시판 관련
Route::prefix("Board")->group(function () {
	Route::get("/Writing", [WritingPage::class, "index"])
		->middleware("CheckLoginCookie")
		->name("Writing");
	Route::post("/Writing", [WritingPage::class, "post_board"])
		->middleware("CheckLoginCookie")
		->name("PostBoard");
	Route::get("/detail/{id}/{group}", [DetailBoardPage::class, "index"])
		->middleware("CheckLoginCookie")
		->name("BoardDetail");
	Route::get("/list/{page}/{group}", [BoardList::class, "index"])
		->middleware("CheckLoginCookie")
		->name("BoardList");
	Route::post("/list/{page}/{group}", [BoardList::class, "post_index"])
		->middleware("CheckLoginCookie")
		->name("PostBoardList");
	Route::get("/Modified/{id}", [ModifiedBoard::class, "index"])
		->middleware("CheckMyBoard")
		->name("ModifiedBoard");
	Route::get("/Delete/{id}", [ModifiedBoard::class, "delete_board"])
		->middleware("CheckMyBoard")
		->name("DeleteBoard");
	Route::post("/Modified/post/{id}", [
		DetailBoardPage::class,
		"post_modified",
	])
		->middleware("CheckMyBoard")
		->name("PostModifiedBoard");
	Route::get("/MyBoard", [MyBoardList::class, "get_index"])
		->middleware("CheckLoginCookie")
		->name("MyBoardListGET");
	Route::post("/MyBoard", [MyBoardList::class, "post_index"])
		->middleware("CheckLoginCookie")
		->name("MyBoardListPOST");
	Route::get("/likeBoard/{boardid}", [LikeBoard::class, "index"])
		->middleware("CheckLoginCookie")
		->name("LikePost");
});

//학부
Route::get("/Main/Hakbu/list/{major}", [HakbuBoardList::class, "index"])
	->middleware("CheckLoginCookie")
	->name("HakbuBoardList");
Route::post("/Main/Hakbu/list/{major}", [HakbuBoardList::class, "post_index"])
	->middleware("CheckLoginCookie")
	->name("HakbuBoardListPOST");

//더보기
Route::get("/Preferences/MyProfile", [MyProfile::class, "index"])
	->middleware("CheckLoginCookie")
	->name("MyProFile");
Route::get("/Preferences/AppVersion", [AppVersion::class, "index"])
	->middleware("CheckLoginCookie")
	->name("AppVerSion");
Route::get("/Preferences/Alarm", [Alarm::class, "index"])
	->middleware("CheckLoginCookie")
	->name("Alarm");
Route::get("/Preferences/Message/list/{page}", [MessageList::class, "index"])
	->middleware("CheckLoginCookie")
	->name("MessageList");
Route::get("/Preferences/Message/detail/{id}", [MessageDetail::class, "index"])
	->middleware("CheckLoginCookie")
	->name("MessageDetail");

//로그인
Route::post("/LoginCheck", [LoginController::class, "index"])->name(
	"LoginControll"
);
Route::get("/LoginCheck", [LoginController::class, "autoLogin"])->name(
	"_LoginControll"
);

//로그아웃
Route::get("/LogOut", Logout_::class)
	->middleware("CheckLoginCookie")
	->name("LogOut");

// REST API
Route::post("/rest/api/reset/password", [RestPassword::class, "index"])->name(
	"RestPasswordApi"
);
