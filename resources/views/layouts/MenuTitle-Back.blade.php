{{-- 각 메뉴 제목 (뒤로가기 버튼 포함) --}}
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0,maximum-scale=1.0"/>
	<link href="{{ asset('/css/Layouts/MenuTitleBack.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"/>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"/>
	<script type="text/javascript" src="https://code.jquery.com/jquery-latest.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
@yield('menu-title-back')
	<header>
		<h3 class="notice-title">
		<a href="javascript:history.back();"><i class="fas fa-arrow-left" style="font-size: 1.2rem;"></i></a>
			<span>{{$title}}</span>
		</h3>
	</header>
</html>
