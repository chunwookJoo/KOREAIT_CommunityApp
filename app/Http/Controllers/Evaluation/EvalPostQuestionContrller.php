<?php

namespace App\Http\Controllers\Evaluation;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class EvalPostQuestionContrller extends Controller
{
	public function index(Request $request)
	{
		$curl = new CurlController();
		$url = env('URL_EVAL_QUESTION').Cookie::get('studentID').'/'.$request['haksuCode'];
		$suggestion_url = env('URL_EVAL_SUGGEST').Cookie::get('studentID').'/'.$request['haksuCode'];
		
		foreach ($request['q'] as $index => $value) {
			$data = array(
				'question' => $index+1,
				'answer' => $value
			);
			$response = $curl->curlPost($url, $data);
			if($response[0]['RESULT'] != '100'){
				return array('RESULT' => '501');
			}
		}
		$data = array(
			'suggestion' => $request['suggestion']
		);
		$response = $curl->curlPost($suggestion_url, $data);
		return $response;
		if($response['RESULT'] != '100'){
			return array('RESULT' => '502');
		}
		return $response[0];
	}
}