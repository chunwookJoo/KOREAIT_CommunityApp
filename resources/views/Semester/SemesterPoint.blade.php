@extends('Layouts.BottomNavigation')
@extends('Layouts.MenuTitle')
<link href="{{ asset('css/Module/NavBar2.css') }}" rel="stylesheet" />
<link href="{{ asset('css/Haksa/SemesterPoint.css') }}" rel="stylesheet" />
@section('content')
<body>
	@section('menu-title') @endsection
	<section class="semester-nav">
		<div class="community-nav-2">
			<a class="nav2-on" href="{{route('SemesterPoint')}}">성적표</a>
			<a href="{{ route('Attend') }}">출결</a>
			<a href="{{route('EvalList')}}">강의평가</a>
		</div>
	</section>
	<section>
		<table>
			@foreach ($contents as $Hakgi_index =>$Hakgis)
			<tr class="Hakgi">
				<td colspan="6" id="hakgi-num">{{$Hakgi_year[$Hakgi_index]}}학년 &ensp; {{$Hakgi_index % 2 ? 2 : 1}}학기</td>
			</tr>
			<tr class="table-title">
				@foreach ($titles as $item)
				<th>
					{{ $item }}
				</th>
				@endforeach
			</tr>
			@foreach ($Hakgis as $subject_index => $subject)
				<tr class="Hakgi{{ $Hakgi_index + 1 }} Hakgi">
					@foreach ($subject as $item_index => $item)
					<td>{{ $item }}</td>
					@endforeach
				</tr>
			@endforeach
			<tr id="avg" class="Hakgi{{ $Hakgi_index + 1 }} Hakgi">
				<td colspan="6">취득학점 : {{$total_point[$Hakgi_index][0]}} &emsp; 평점계 : {{ $total_point[$Hakgi_index][1] }} &emsp; 평균 : {{ $total_point[$Hakgi_index][2] }}</td>
			</tr>
			@endforeach
		</table>
		<div class="total-point">
			총 취득 학점 : <span>{{ $total_point_Hakjum }}</span>&ensp;
			평점계 : <span>{{$total_avg_total_point}}</span>&ensp;
			평점평균 : <span>{{$total_avg_point}}</span>
		</div>
	</section>
	<script>
		function change_() {
			var year = document.getElementById("year").value;
			//var hakgi = (2 * year) - 1;
			var Hakgi = ".Hakgi" + year;
			console.log(Hakgi);
			$(".Hakgi").css("display", "none");
			$(Hakgi).css("display", "table-row");
		}
	</script>
	<script type="text/javascript">
		$("div a").each(function () {
			if ($(this).attr("href") == $(document).attr("location").href)
				$(this).addClass("nav2-on");
			// else $(this).removeClass('nav2-on');
		});
	</script>
</body>

@endsection
