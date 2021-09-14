<?php

namespace App\Http\Controllers\LoginPage;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CurlController;
use Illuminate\Http\Request;

class SearchStudentNumber extends Controller
{
    public function api(Request $request){
        $url_id = env('URL_SEARCH_STUDENT_NUM');
        $data = array(
            'studentName' => $request['studentName'],
            'socialNum' => $request['socialNum']
        );
        $curl = CurlController::getInstance();
		$response = $curl->curlPost($url_id, $data);
        return $response;
		if ($response[0]['RESULT'] == 100) {
			$result = array(
				'RESULT' => '100',
                'STUDENTNUM' => $response[0]['STUDENTNUM']
			);
			return response()->json($result);
		}else{
			$result = array(
				'RESULT' => '300'
			);
			return response()->json($result);
		}
    }
}
