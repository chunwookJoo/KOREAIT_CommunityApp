<?php

namespace App\Http\Controllers\Preferences;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

//메세지 상세 내용
class MessageDetail extends Controller
{
	public function index(Request $request)
	{
		try {
			$title = "받은 메세지";
			//curl 생성
			$curl = new CurlController();

			$message_id =  $request['id'];			//게시판 번호
			$student_id = Cookie::get('studentID'); //학번

			//상세 게시판 호출
			$url_id = env('URL_MESSAGE_DETAIL');
			$data = array(
				'message_id' => $message_id,
			);
			$response = $curl->curlPost($url_id, $data);

			if ($response['RESULT'] == '400') {
				return redirect()->back();
			}

			return view('Preferences.MessageDetail', compact('response', 'student_id', 'message_id', 'title'));
		} catch (\Exception $e) {
			Log::error($e);
			return redirect()->back();
		}
	}
}
