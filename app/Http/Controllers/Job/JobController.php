<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $requets)
	{
		$title = "구인의뢰";

		$curl = new CurlController();
		$data = array(
			'page_num' => $requets['page'],
			'page_size' => 20
		);
		
		$response = $curl->curlPost(env("URL_JOB"), $data);

		return view('Job.Job', compact('title', 'response'));
	}
}
