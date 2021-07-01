@extends('layouts.BottomNavigation') @extends('layouts.MenuTitle')
@section('content')
<link href="{{ asset('/css/Community.css') }}" rel="stylesheet" />
<link href="{{ asset('css/Haksa/SemesterPoint.css') }}" rel="stylesheet" />
<link href="{{ asset('css/Haksa/EvalList.css') }}" rel="stylesheet" />
<body>
	@section('menu-title') @endsection
	<section class="semester-nav">
		<div class="community-nav-2">
			<a href="{{ route('SemesterPoint') }}">성적표</a>
			<a href="{{ route('Attend') }}">출결</a>
			<a class="nav2-on" href="{{ route('EvalList') }}">강의평가</a>
		</div>
	</section>
	<!--강의평가 기간일 경우-->
	<section>
		<div class="eval-list-container">
			@if($withinPeriod)
				@foreach ($evalList as $item)
				<div class="eval_list_item">
					<div>
						<h5>
							@if ($item['eval_status']=="Y")
								<i style="color:green" class="fas fa-check"></i>
							@endif{{ $item["subjectName"] }}
						</h5>
						<span
							@if ($item['eval_status']=="Y")
								style="margin-left: 22px"
							@endif
						>
						{{ $item["name"] }}
					</span>
					</div>
					<!--강의평가 했는지 유무-->
					<div class="do-eval-btn">
					@if ($item['eval_status']=="N")
						<a
							href="{{route('EvalQuestion', ['haksuCode'=> $item['haksuCode'], 'name' =>$item['name'], 'subjectName' => $item['subjectName']])}}"
							id="btn_eval"
						>
						<div>강의평가 하기</div></a>
					@else
						<a
							href="{{route('EvalQuestion', ['haksuCode'=> $item['haksuCode'], 'name' =>$item['name'], 'subjectName' => $item['subjectName']])}}"
							id="btn_eval"
						>
						<div>강의평가 수정</div></a>
					@endif
					</div>
				</div>
				@endforeach
			@else
			<h5 class="dont-eval">현재 강의평가 기간이 아닙니다.</h5>
			@endif
		</div>
	</section>
</body>

@endsection
