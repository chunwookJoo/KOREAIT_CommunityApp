<!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="/admin/log/app.css" />
	<link rel="stylesheet" type="text/css" href="/admin/css/element.css" />
	<title>관리자 로그인 기록</title>
	<script>
		var msg = '{{ Session::get('alert') }}';
		var exist = '{{ Session::has('alert') }}';
		if (exist) {
			alert(msg);
		}
	</script>
</head>

<body>
	<h2>
		<span>
			관리자 로그인 기록
		</span>
	</h2>
	<div class="search-form">
		<form action="" method="get">
			<input type="text" name="user_id" id="user_id" value="{{$request->user_id}}" placeholder="학번/사번"
				minlength="1" maxlength="10" size="10" />
			<input type="text" name="ip_address" id="ip_address" value="{{$request->search_value}}"
				placeholder="IP 주소" minlength="1" maxlength="20" size="20" />
			<input type="submit" class="submit" value="검색">
		</form>
	</div>
	<section>
		<table>
			<thead>
				<tr>
					<th class="user-id">학번/사번</th>
					<th class="ip-address">IP 주소</th>
					<th class="login-time">접속 시각</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($result_log as $log)
				<tr>
					<td class="user-id">{{$log->user_id}}</td>
					<td class="ip-address">{{$log->ip_address}}</td>
					<td class="login-time">{{$log->login_time}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</section>
	<div class="page-number">
		<div>
			@foreach ($result_page as $page)
			@if ($page && $page != $request->page_num)
			<span class="on">
				<a href="{{route(
					'_LogAdmin',
					['page_num' => $page,
					'user_id' => $request->user_id,
					'ip_address' => $request->ip_address]
				)}}">{{$page}}</a>
			</span>
			@elseif ($page)
			<span>
				<a>
					{{$page}}
				</a>
			</span>
			@endif
			@endforeach
		</div>
	</div>
	<script>
		const pagenumber = document.querySelector(".on");
		pagenumber.addEventListener("click", () => {
			if(pagenumber.className === "on"){
				pagenumber.classList.remove("on");
			}
			else{
				pagenumber.classList.add("on");
			}
		});
	</script>
</body>

</html>
