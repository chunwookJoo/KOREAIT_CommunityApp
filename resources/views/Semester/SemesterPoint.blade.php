@extends('layouts.BottomNavigation') @extends('layouts.MenuTitle')
@section('content')
<link href="{{ asset('css/Haksa/SemesterPoint.css') }}" rel="stylesheet" />
<link href="{{ asset('/css/Community.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
		<h2 class="total-point">
			총 취득 학점 : {{ $total_point_Hakjum }}
		</h2>
		<table>
			<tr class="table-title">
				@foreach ($titles as $item)
				<th>
					{{ $item }}
				</th>
				@endforeach
			</tr>
			@foreach ($contents as $Hakgi_index =>$Hakgis)

			<tr class="Hakgi">
				<td colspan="5" id="hakgi-num">학기</td>
			</tr>
			@foreach ($Hakgis as $subject_index => $subject)
				<tr class="Hakgi{{ $Hakgi_index + 1 }} Hakgi">
					@foreach ($subject as $item_index => $item)
					<td>{{ $item }}</td>
					@endforeach
				</tr>
			@endforeach
			<tr id="avg" class="Hakgi{{ $Hakgi_index + 1 }} Hakgi">
				<td colspan="5">평점계 : {{ $total_point[$Hakgi_index][1] }} &emsp; 평균 : {{ $total_point[$Hakgi_index][0] }}</td>
				{{-- <td>
					{{ $total_point[$Hakgi_index][1] }}
				</td>
				<td></td>
				<td>평균</td>
				<td>
					{{ $total_point[$Hakgi_index][0] }}
				</td> --}}
			</tr>
			@endforeach
		</table>
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
