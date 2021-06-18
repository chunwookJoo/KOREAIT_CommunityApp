<!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0,maximum-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="/admin/css/admin.css" />
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
		integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
	<title>학사 앱 관리자 페이지</title>
</head>

<body>
	<nav class="nav">
		<div class="nav-links">
			<div><button id="navCloseBtn" class="nav-close-btn"><i class="fas fa-times"></i></button></div>

			<a href="{{route('_Home')}}" target="frame">
				<div class="nav-link nav-link--active">전체 게시물</div>
			</a>
			@foreach ($result_menu as $page)
			<a href="/admin/{{$page->page_link}}" target="frame">
				<div class="nav-link">{{$page->page_name}}</div>
			</a>
			@endforeach
			<br>
			<a href="{{route('_UserLogout')}}">
				<div style="color: #000">로그아웃</div>
			</a>
		</div>
		<div class="nav-overlay"></div>
	</nav>
	<header class="header">
		<button id="navOpenBtn" class="nav-open-btn"><i class="far fa-bars"></i></button>
		<div>
			<h1>
				<span>
					<img src="/images/Logo.png" />
					관리자 페이지
				</span>
				<span class="admin-info">
					@if ($result_role)
					<span>
						관리자 이름 : {{$result_role['user_name'] ?? ''}}
					</span>
					&emsp;
					&emsp;
					<span>
						학번/사번 : {{$result_role['id'] ?? ''}}
					</span>
					@else
					내부 오류 발생
					@endif
				</span>
			</h1>
		</div>
	</header>

	<section class="section">
		<iframe src="{{route('_Home')}}" id="frame" name="frame" frameborder="0"></iframe>
	</section>
	<footer class="footer">

	</footer>
</body>
<script>
	var msg = '{{ Session::get('alert') }}';
	var exist = '{{ Session::has('alert') }}';
	if (exist) {
		alert(msg);
	}
	document.addEventListener("DOMContentLoaded", () => {
		const nav = document.querySelector(".nav");
		const nav_link = document.getElementsByClassName("nav-link");

		document.querySelector("#navOpenBtn").addEventListener("click", () => {
			nav.classList.add("nav-open");
		});

		document.querySelector(".nav-overlay").addEventListener("click", () => {
			nav.classList.remove("nav-open");
		});

		document.querySelector("#navCloseBtn").addEventListener("click", () => {
			nav.classList.remove("nav-open");
		});

		for (let target of nav_link) {
			target.onclick = () => {
				for (let element of nav_link){
					element.classList.remove("nav-link--active");
				}
				target.classList.add("nav-link--active");
			}
		}
	});
</script>

</html>
