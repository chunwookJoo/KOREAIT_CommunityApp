<?php

namespace App\Http\Controllers\Evaluation;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class EvalQuestionContrller extends Controller
{
	public function index(Request $request)
	{
		$curl = new CurlController();
		$haksuCode = $request['haksuCode'];
		$title = $request['subjectName'].'/'.$request['name'];

		$response = $curl->curlGet(env('URL_EVAL_QUESTION').Cookie::get('studentID').'/'.$request['haksuCode']);

		return view('Evaluation.EvalQuestion', compact('response', 'haksuCode', 'title'));
	}
}
