{{-- 커뮤니티 공지사항 네비게이션 --}}
@extends('Layouts.BottomNavigation')
@section('content')
<link rel="stylesheet" href="{{ asset('css/Main/MainPage.css') }}" />

<body class="community-body">
	@include("Layouts.CommunityLogoLayout")
	<header>
		<div class="title" role="banner">
			<h1 class="menu-title">
				<span>KOREAIT 커뮤니티</span>
				<a class="write-button" href="{{ route('Writing') }}">
					<i class="fas fa-edit" style="font-size: 17px"></i>
				</a>
			</h1>
			<nav>
				<div class="community-nav-1">
					<a href="{{route('HakbuBoardList', ['major'=>'E'])}}">학부게시판</a>
					<a class="nav1-on" href="{{ route('MainPage') }}">HOME</a>
					<a href="{{route('BoardList', ['page'=>1, 'group'=>901])}}">학생 마당</a>
				</div>
			</nav>
		</div>
	</header>
	<ul class="list-group">
		@foreach($notice_datas as $notice_data)
		<div class="list">
			<li>
				<a href="Notice/{{ $notice_data['take_idx'] }}">
					<h5 class="notice-list-title">
						<div>
							<i
								class="fas fa-bullhorn"
								style="color: rgb(255, 81, 81);	font-size: small;"
							>공지</i>
						</div>
						<div>{{ $notice_data["title"] }}</div>
					</h5>
					<div class="write-day">
						<span>{{ $notice_data["writeday"] }}</span>
							&ensp;
						<span>조회 : {{ $notice_data["readnum"] }}</span>
					</div>
				</a>
			</li>
		</div>
		@endforeach
	</ul>
	<script src="{{ asset('js/boardlist.js') }}"></script>
</body>
@endsection
