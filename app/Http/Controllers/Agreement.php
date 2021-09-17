<?php

// 동의서
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class Agreement extends Controller
{
	public function get(Request $request)
	{
		$studentID = $request->cookie("studentID");
		$today = date("Y.m.d");
		$form = $request["type"];

		$birthday = $request->session()->get("birthday");
		$studentName = $request->session()->get("studentName");
		$hakgi = $request->session()->get("hakgi");

		switch ($form) {
			case "scholarship":
				$title = "교육비 장학증서";
				$sosokStr = $request->session()->get("sosokName");
				$sosokArr = explode(" ", $sosokStr);
				$sosokName = str_replace($sosokArr[1], "계열", $sosokStr);

				return view(
					"Agreement.Scholarship",
					compact(
						"title",
						"sosokName",
						"birthday",
						"studentName",
						"studentID",
						"today",
						"hakgi"
					)
				);
				break;
			case "lecture":
				$title = "학점은행제 수강신청서";
				$hp = $request->session()->get("hp");
				$major = $request->session()->get("major");
				$address = $request->session()->get("address");

				return view(
					"Agreement.Lecture",
					compact(
						"title",
						"major",
						"studentName",
						"studentID",
						"birthday",
						"hp",
						"address",
						"today",
						"hakgi"
					)
				);
				break;
			case "personal":
				$title = "개인정보 수집·이용·제3자 제공 동의서";

				return view(
					"Agreement.Personal",
					compact(
						"title",
						"birthday",
						"studentName",
						"studentID",
						"today",
						"hakgi"
					)
				);
				break;
			case "software":
				$title = "소프트웨어 사용에 대한 서약서";
				$sosokStr = $request->session()->get("sosokName");
				$sosokArr = explode(" ", $sosokStr);
				$sosokName = str_replace($sosokArr[1], "계열", $sosokStr);

				return view(
					"Agreement.Software",
					compact(
						"title",
						"sosokName",
						"birthday",
						"studentName",
						"studentID",
						"today",
						"hakgi"
					)
				);
				break;
		}
	}
}
