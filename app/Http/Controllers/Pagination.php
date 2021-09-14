<?php

namespace App\Http\Controllers;

class Pagination
{
	//num, size 받아서 공지사항 json 반환
	public static function get_pages($page_num, $page_count)
	{
		$result_pages = [
			$page_num - 10 >= $page_count - 10
				? ($page_num - 10 > 0
					? $page_num - 10
					: null)
				: null,
			$page_num - 9 >= $page_count - 10
				? ($page_num - 9 > 0
					? $page_num - 9
					: null)
				: null,
			$page_num - 8 >= $page_count - 10
				? ($page_num - 8 > 0
					? $page_num - 8
					: null)
				: null,
			$page_num - 7 >= $page_count - 10
				? ($page_num - 7 > 0
					? $page_num - 7
					: null)
				: null,
			$page_num - 6 >= $page_count - 10
				? ($page_num - 6 > 0
					? $page_num - 6
					: null)
				: null,
			$page_num - 5 > 0 ? $page_num - 5 : null,
			$page_num - 4 > 0 ? $page_num - 4 : null,
			$page_num - 3 > 0 ? $page_num - 3 : null,
			$page_num - 2 > 0 ? $page_num - 2 : null,
			$page_num - 1 > 0 ? $page_num - 1 : null,
			$page_num,
			$page_num + 1 <= $page_count ? $page_num + 1 : null,
			$page_num + 2 <= $page_count ? $page_num + 2 : null,
			$page_num + 3 <= $page_count ? $page_num + 3 : null,
			$page_num + 4 <= $page_count ? $page_num + 4 : null,
			$page_num + 5 <= $page_count ? $page_num + 5 : null,
			$page_num + 6 <= 11
				? ($page_num + 6 <= $page_count
					? $page_num + 6
					: null)
				: null,
			$page_num + 7 <= 11
				? ($page_num + 7 <= $page_count
					? $page_num + 7
					: null)
				: null,
			$page_num + 8 <= 11
				? ($page_num + 8 <= $page_count
					? $page_num + 8
					: null)
				: null,
			$page_num + 9 <= 11
				? ($page_num + 9 <= $page_count
					? $page_num + 9
					: null)
				: null,
			$page_num + 10 <= 11
				? ($page_num + 10 <= $page_count
					? $page_num + 10
					: null)
				: null,
		];
		return $result_pages;
	}
}
