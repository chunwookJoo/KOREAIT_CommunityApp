<?php

namespace App\Http\Controllers\Preferences;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

//메세지 목록
class MessageList extends Controller
{
	public function index(Request $requets)
	{
		$title = "받은 메세지";
		//post 데이터 준비
		//사용자 정보 조회
		$curl = new CurlController();
		$url_id = env('URL_MESSAGE_LIST');
		$student_id = Cookie::get('studentID');
		$data = array(
			'user_id' => $student_id,
			'page_num' => 1,
			'page_size' => 10,
		);
		$response = $curl->curlPost($url_id, $data);
		return view('Preferences.MessageList', compact('response', 'student_id','title'));
	}
}
