<?php

// 동의서
namespace App\Htpp\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;

class Agreement extends Controller
{
    public function index(Request $request)
	{
		$title = "동의서";
		$form = $request["type"];
		$curl = new CurlController();


		return view('Agreement', compact('title', 'response'));
	}
}
