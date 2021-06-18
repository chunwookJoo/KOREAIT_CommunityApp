<?php

namespace App\Http\Controllers\Preferences;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AppVersion extends Controller
{
	public function index(Request $requets)
	{
		$title = "앱 버전";
		return view('Preferences.AppVersion', compact('title'));
	}
}
