<?php

namespace App\Http\Controllers\MiddleRestApi;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Exception;
use Illuminate\Http\Request;

class SearchStudentNumber extends Controller
{
	public function index(Request $request)
	{
		try {
			$studentName = $request->studentName;
			$socialNum = $request->socialNum;

			$curl = new CurlController();

			$data = array(
				'studentName' => $studentName,
				'socialNum' => $socialNum
			);

			$response = $curl->curlPost(env('URL_SEARCH_STUDENT_NUM'), $data);

			if ($response['RESULT'] == 100) {
				return array('RESULT' => 100, 'STUDENTNUM' => $response['STUDENTNUM']);
			}
			return array('RESULT' => 200);
		} catch (Exception $e) {
			return array('RESULT' => 400);
		}
	}
}
