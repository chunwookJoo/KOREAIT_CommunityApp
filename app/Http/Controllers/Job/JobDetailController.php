<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;

class JobDetailController extends Controller
{
    public function index(Request $requets)
	{
		$title = "구인의뢰";

		$curl = new CurlController();

		$response = $curl->curlGet(env("URL_JOB_DETAIL"). $requets['take_idx']);
        $response = $response[0];
		return view('Job.JobDetail', compact('title', 'response'));
	}
}
