@extends('Layouts.BottomNavigation')
@extends('Layouts.MenuTitle')
<link href="{{ asset('/css/Module/NavBar2.css') }}" rel="stylesheet">
<link href="{{ asset('/css/Haksa/Attend.css') }}" rel="stylesheet">
@section('content')
<body>
	@section('menu-title')@endsection
	<section class="semester-nav">
		<div class="community-nav-2">
			<a href="{{route('SemesterPoint')}}">성적표</a>
			<a class="nav2-on" href="{{ route('Attend') }}">출결</a>
			<a href="{{route('EvalList')}}">강의평가</a>
		</div>
	</section>
	<div class="attend-grid">
		@foreach ($attend as $item)
			<div>
				<p id="attend-date">{{$item['day']}}</p>
				<p>{{$item['subjectName']}} ({{$item['teacher']}})</p>
				<p id="attend-reason">{{$item['reason']}} {{$item['count']}}</p>
			</div>
		@endforeach
	</div>
	<section>
		@if (sizeof($attend) == 0)
			<h5>지각, 결석, 조퇴 사유가 없습니다.</h5>
		@endif
	</section>
</body>

@endsection
