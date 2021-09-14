<?php

namespace App\Http\Controllers\Evaluation;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class EvalViewController extends Controller
{

	public function index(Request $request)
	{
		$url_id = env("URL_EVAL_LIST") . Cookie::Get('studentID') . '/1';
		$url_id_sim = env("URL_EVAL_LIST") . Cookie::Get('studentID') . '/3';
		$url_id_period = env("URL_EVAL_PERIOD") . Cookie::Get('studentID') . '/1';
		$url_id_period_sim = env("URL_EVAL_PERIOD") . Cookie::Get('studentID') . '/3';
		

		$curl = new CurlController();
		// 강의 평가 리스트
		$evalList = array();

		// 강의 평가 기간 확인
		$evalPeriod =  $curl->curlget($url_id_period);
		$evalPeriod_Sim = $curl->curlget($url_id_period_sim);

		$title = "강의평가";
		$withinPeriod = false;
		
		$nowDate = strtotime(date("Y-m-d"));	// 현재 날짜
		$startDate = NUll;						// 강의평가 시작 날짜
		$endDate = NULL;						// 강의평가 종료 날짜
		
		if ($evalPeriod[0]['RESULT'] != 100 &&  $evalPeriod_Sim[0]['RESULT'] != 100) {
			return view('Evaluation.EvalList', compact('evalList', 'title', 'withinPeriod'));
		}
		// 학점인정 과목 강의평가 기간
		if ($evalPeriod[0]['RESULT'] == 100) {
			$startDate = strtotime($evalPeriod[0]['start_date']);
			$endDate = strtotime($evalPeriod[0]['end_date']);
			$withinPeriod = true;
			$evalList = $curl->curlget($url_id);
			return view('Evaluation.EvalList', compact('evalList', 'title', 'withinPeriod'));
		}
		// 심화과목 강의평가 기간
		else if ($evalPeriod_Sim[0]['RESULT'] == 100) {
			$startDate = strtotime($evalPeriod_Sim[0]['start_date']);
			$endDate = strtotime($evalPeriod_Sim[0]['end_date']);
			$withinPeriod = true;
			$evalList = $curl->curlget($url_id_sim);
			return view('Evaluation.EvalList', compact('evalList', 'title', 'withinPeriod'));
		}

		return view('Evaluation.EvalList', compact('evalList', 'title', 'withinPeriod'));
	}
}
