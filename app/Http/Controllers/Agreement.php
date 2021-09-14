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
		$curl = new CurlController();
		switch ($form) {
			case "scholarship":
				$title = "교육비 장학증서";
				$sosokStr = $request->session()->get("sosokName");
				$sosokArr = explode(" ", $sosokStr);
				$sosokName = str_replace($sosokArr[1], "계열", $sosokStr);

				$birthday = $request->session()->get("birthday");
				$studentName = $request->session()->get("studentName");
				//$request->session()->flush();
				return view(
					"Agreement.Scholarship",
					compact(
						"title",
						"sosokName",
						"birthday",
						"studentName",
						"studentID",
						"today"
					)
				);
				break;
			case "lecture":
				$title = "학점은행제 수강신청서";
				$major = $request->session()->get("major");
				$studentName = $request->session()->get("studentName");
				$birthday = $request->session()->get("birthday");
				$hp = $request->session()->get("hp");
				$address = $request->session()->get("address");
				//$request->session()->flush();
				return view(
					"Agreement.Lecture",
					compact(
						"title",
						"major",
						"studentName",
						"birthday",
						"hp",
						"address",
						"today"
					)
				);
				break;
			case "personal":
				$title = "개인정보 수집·이용·제3자 제공 동의서";
				$birthday = $request->session()->get("birthday");
				$studentName = $request->session()->get("studentName");

				//$request->session()->flush();
				return view(
					"Agreement.Personal",
					compact("title", "birthday", "studentName", "today")
				);
				break;
			case "software":
				$title = "소프트웨어 사용에 대한 서약서";
				$sosokStr = $request->session()->get("sosokName");
				$sosokArr = explode(" ", $sosokStr);
				$sosokName = str_replace($sosokArr[1], "계열", $sosokStr);

				$birthday = $request->session()->get("birthday");
				$studentName = $request->session()->get("studentName");

				//$request->session()->flush();
				return view(
					"Agreement.Software",
					compact(
						"title",
						"sosokName",
						"birthday",
						"studentName",
						"studentID",
						"today"
					)
				);
				break;
		}
	}
}
