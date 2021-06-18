@extends('layouts.BottomNavigation')
@extends('layouts.MenuTitle')
@section('content')
<link href="{{ asset('/css/Community.css') }}" rel="stylesheet">
<link href="{{ asset('/css/Haksa/Attend.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
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
