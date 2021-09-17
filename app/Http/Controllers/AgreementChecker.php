<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class AgreementChecker extends Controller
{
	public function check(Request $request)
	{
		$student_id = $request->cookie("studentID");
		$password = $request->session()->get("password");
		$url_id = env("URL_LOGIN", false) . $student_id . "/" . $password;

		$curl = CurlController::getInstance();
		$response = $curl->curlGet($url_id);

		$request->session()->put("studentName", $response[0]["studentName"]);
		$request->session()->put("birthday", $response[0]["birthday"]);
		$request->session()->put("hakgi", $response[0]["hakgi"]);

		if (!$response[0]["software"]) {
			$request->session()->put("sosokName", $response[0]["sosokName"]);
			return redirect()->route("Agreement", [
				"type" => "software",
			]);
		}
		if (!$response[0]["lecture"]) {
			$request
				->session()
				->put(
					"major",
					"{$response[0]["major"]} {$response[0]["degree"]}"
				);
			$request->session()->put("hp", $response[0]["hp"]);
			$request->session()->put("address", $response[0]["address1"]);
			return redirect()->route("Agreement", [
				"type" => "lecture",
			]);
		}
		if (!$response[0]["personal"]) {
			return redirect()->route("Agreement", [
				"type" => "personal",
			]);
		}
		if ($response[0]["scholarship"]) {
			$request->session()->put("sosokName", $response[0]["sosokName"]);
			return redirect()->route("Agreement", [
				"type" => "scholarship",
			]);
		}

		$request->session()->flush();

		return redirect()->route("MainPage");
	}
}
