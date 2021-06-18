@extends('layouts.BottomNavigation')
@extends('layouts.MenuTitle')
@section('content')
<link href="{{ asset('css/Job/JobList.css') }}" rel="stylesheet" />
	<body>
		@section('menu-title')
		@endsection
		<section>
			<ul>
				@foreach($response as $index => $item)
				<li>
					<a href="{{route("JobDetail" , ['take_idx' => $item['take_idx']])}}"
						>
						<div class="company-name">{{$item['co_name']}}</div>
						<div class="notification-title">{{$item['title']}}</div>
						<div class="pay-writeday">
							<small>초봉 : {{$item['job_pay']}}</small>
							<small>{{$item['writeday']}}</small>
						</div>
					</a>
				</li>
			@endforeach
			</ul>
		</section>
	</body>
@endsection
