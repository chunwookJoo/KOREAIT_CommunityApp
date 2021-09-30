<?php

namespace App\Http\Controllers;
use App\Http\Controllers\CurlController;

class SchoolNotice extends Controller
{
	//num, size 받아서 공지사항 json 반환
	public function getNotice($num, $size)
	{
		try {
			$data = [
				"page_num" => $num,
				"page_size" => $size,
			];
			$curl = CurlController::getInstance();
			$response = $curl->curlPost(env("URL_NEWS_LIST"), $data);
			return $response;
		} catch (\Exception $e) {
			return $e;
		}
	}
}
