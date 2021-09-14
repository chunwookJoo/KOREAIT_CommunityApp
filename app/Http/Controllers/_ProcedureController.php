<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class _ProcedureController
{
	public function __construct(string $aProcedure, array $aParam)
	{
		$this->sql =
			"CALL " .
			env("DB_DATABASE") .
			".$aProcedure(" .
			trim(str_repeat("?,", count($aParam)), ",") .
			");";
		$this->params = $aParam;
	}

	public function query_one()
	{
		try {
			$result = DB::select($this->sql, $this->params);
			return $result[0];
		} catch (\Throwable $th) {
			Log::error($th);
			return null;
		}
	}

	public function query()
	{
		try {
			$result = DB::select($this->sql, $this->params);
			return $result;
		} catch (\Throwable $th) {
			Log::error($th);
			return [];
		}
	}

	public function get_sql()
	{
		return $this->sql;
	}
}
