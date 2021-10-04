{{-- 메인 메뉴 하단 네비바 --}}
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0,maximum-scale=1.0"/>
		<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"/>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"/>
		<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&display=swap" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	</head>
	<link href="{{ asset('/css/Layouts/BottomNavigation.css') }}" rel="stylesheet"/>
	<script src="{{ asset('js/Community.js') }}"></script>

	<body>
		@yield('content')
		<footer>
			<nav class="footer-nav">
				<div>
					<a href="{{ route('Calendar') }}"
						><i
							class="fas fa-calendar-alt"
							style="font-size: 1.4rem; margin-top: 14px"
							><label>시간표</label></i
						></a
					>
					<a href="{{ route('SemesterPoint') }}"
						><i
							class="fas fa-chart-line"
							style="font-size: 1.4rem; margin-top: 14px"
							><label>성적조회</label></i
						></a
					>
					<a href="{{ route('MainPage') }}"
						><i
							class="fas fa-comment-alt"
							style="font-size: 1.4rem; margin-top: 14px"
							><label>커뮤니티</label></i
						></a
					>
					<a href="{{ route('Job', ['page'=>1])}}"
						><i
							class="fas fa-building"
							style="font-size: 1.4rem; margin-top: 14px"
							><label>구인의뢰</label></i
						></a
					>
					<a href="{{ route('Preferences') }}"
						><i
							class="fas fa-ellipsis-h"
							style="font-size: 1.4rem; margin-top: 14px"
							><label>더보기</label></i
						></a
					>
					<small></small>
				</div>
			</nav>
		</footer>
		<script type="text/javascript">
			$(".footer-nav a").each(function () {
				if (
					$(this).attr("href").split("/")[3] ==
					$(document).attr("location").href.split("/")[3]
				)
					$(this).addClass("on");
				else $(this).removeClass("on");
			});
			if ($(document).attr("location").href.split("/")[3] == "Board") {
				$($(".footer-nav a")[2]).addClass("on");
			}
			$(document).ready(function () {
				$(".footer-nav a").on("click", function () {
					$(this).addClass("on");
					$(this).siblings().removeClass("on");
				});
			});
		</script>
	</body>
</html>
