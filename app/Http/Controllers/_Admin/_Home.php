<?php

namespace App\Http\Controllers\_Admin;

use App\Http\Controllers\_ProcedureController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _Home extends Controller
{
	public function __invoke(Request $request)
	{
		return redirect("admin/board/list");
	}
}
