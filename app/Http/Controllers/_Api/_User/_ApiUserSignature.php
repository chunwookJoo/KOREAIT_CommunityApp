<?php

namespace App\Http\Controllers\_Api\_User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * ======================================================================
 * 재학생용 학생 문서
 * ======================================================================
 *
 * API 라우트 정보 "routes/_admin/_api/_user.php" 파일 참고
 *
 * 호출 (GET), https://app.koreait.kr/article/user/signature/[student_id]
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		student_id			20073004				학번			필수
 *
 * 결과 (목록)
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		file_path			20073004/lecture.jpg	파일 경로		[student_id]/[file_name]
 * 		file_url			https://app.koreai...	파일 경로		GET, DELETE용
 *
 * 호출 (GET), https://app.koreait.kr/article/user/signature/[student_id]/[file_name]
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		student_id			20073004				학번			필수
 * 		file_name			lecture.jpg				파일명			필수, 확장자 포함
 *
 * 결과 (단일, 파일)
 * 		[file_name] (확장자 포함)
 *
 * 호출 (POST), https://app.koreait.kr/article/user/signature/
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		student_id			20073004				학번			필수
 * 		form_type			scholarship				장학증서		필수
 * 							lecture					수강신청서
 * 							personal				개인정보 수집 동의서
 * 							software				소프트웨어 사용 서약서
 * 		image				scholarship.jpg			이미지 파일		필수
 *
 * 결과 (단일)
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		RESULT				100						성공
 * 							400						실패
 * 		MESSAGE				업로드 성공				결과 메시지
 * 		file_url			https://app.koreai...	업로드 파일 URL
 *
 * 호출 (DELETE), https://app.koreait.kr/article/user/signature/[student_id]
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		student_id			20073004				학번			필수
 *
 * 결과 (단일)
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		directory			20073004				삭제된 디렉토리
 * 		RESULT				100						성공
 * 							400						실패
 * 		MESSAGE				삭제 성공				결과 메시지
 *
 * 호출 (DELETE), https://app.koreait.kr/article/user/signature/[student_id]/[file_name]
 * 		Key					Value					설명			비고
 * 		==========================================================================
 * 		student_id			20073004				학번			필수
 * 		file_name			lecture.jpg				파일명			필수, 확장자 포함
 *
 * 결과 (단일, 파일)
 * 		[file_name] (확장자 포함)
 */
/**
 * scholarship	장학증서
 * lecture		수강신청서
 * personal		개인정보 수집 동의서
 * software		소프트웨어 사용 서약서
 */
class _ApiUserSignature extends Controller
{
	function post(Request $request)
	{
		$validated = $request->validate([
			"image" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
		]);

		$file_ext = $validated["image"]->extension();

		switch ($request->form_type) {
			case "scholarship":
			case "lecture":
			case "personal":
			case "software":
				break;
			default:
				$result = [
					"RESULT" => "400",
					"MESSAGE" => "잘못된 form_type입니다.",
				];
				return response()->json($result);
				break;
		}

		if ($validated["image"]) {
			$path = $validated["image"]->storePubliclyAs(
				$request->student_id,
				$request->form_type . "." . $file_ext,
				"signature"
			);
		}

		$result = [
			"RESULT" => 100,
			"MESSAGE" => "업로드 성공",
			"file_url" => env("URL_SIGNATURE") . $path,
		];

		return response()->json($result);
	}

	function get($student_id, $file_name = null)
	{
		if ($file_name) {
			try {
				return Storage::disk("signature")->download(
					"$student_id/$file_name"
				);
			} catch (\Throwable $th) {
				// Log::error($th);
				return response(null, 404);
			}
		} else {
			$result = Storage::disk("signature")->files($student_id);
			foreach ($result as $key => $value) {
				$result[$key] = [
					"file_path" => $value,
					"file_url" => env("URL_SIGNATURE") . $value,
				];
			}
			return response()->json($result);
		}
	}

	function delete($student_id, $file_name = null)
	{
		if ($file_name) {
			$result = Storage::disk("signature")->delete(
				"$student_id/$file_name"
			);
			$message = $result ? "삭제 성공" : "삭제 실패";
			$result = $result ? "100" : "400";
			return response()->json([
				"file_path" => "$student_id/$file_name",
				"RESULT" => $result,
				"MESSAGE" => $message,
			]);
		} else {
			$result = Storage::disk("signature")->deleteDirectory(
				"$student_id"
			);
			$message = $result ? "삭제 성공" : "삭제 실패";
			$result = $result ? "100" : "400";
			return response()->json([
				"directory" => $student_id,
				"RESULT" => $result,
				"MESSAGE" => $message,
			]);
		}
	}
}
