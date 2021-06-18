<?php

namespace App\Http\Controllers\Preferences;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class Alarm extends Controller
{
	public function index(Request $requets)
	{
		$title = "알림설정";
		return view('Preferences.Alarm', compact('title'));
	}
}
