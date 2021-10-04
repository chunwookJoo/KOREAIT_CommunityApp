@extends('Layouts.AgreementLayout')
<link href="{{ asset('/css/Agreement/Style.css') }}" rel="stylesheet"/>
<body class="global-section" id="capture">
	<h1>{{$title}}</h1>
	<section class="student-info-section-lecture">
		<div>
			<span>
				신청학위명&nbsp;:&nbsp;{{$major}}
			</span>
		</div>
		<div>
			<span>
				이&emsp;&emsp;름&nbsp;:&nbsp;{{$studentName}}
			</span>
		</div>
		<div>
			<span>
				생년월일&nbsp;:&nbsp;{{$birthday}}
			</span>
		</div>
		<div>
			<span>
				연&nbsp;&nbsp;락&nbsp;&nbsp;처&nbsp;:&nbsp;{{$hp}}
			</span>
		</div>
		<div>
			<span>
				주&emsp;&emsp;소&nbsp;:&nbsp;{{$address}}
			</span>
		</div>
	</section>
	<article id="lecture_article">
		<table>
			수강신청과목
			<tr>
				<td>교과목명</td>
				<td>교과목명</td>
			</tr>
			<tr>
				<td>이수기간</td>
				<td>이수기간</td>
			</tr>
			<tr>
				<td>이수구분</td>
				<td>이수구분</td>
			</tr>
			<tr>
				<td>신청학점</td>
				<td>신청학점</td>
			</tr>
		</table>
		<p>
			본인은 학사운영 규정을 성실히 수행 할 것을 약속하며 학점은행제를 통한 수업을 수강하고자 수강신청서를 작성하여 제출합니다.
		</p>
		<span>{{$today}}</span>
		<span>신청자 : {{$studentName}}</span>
	</article>
	@section('agreement-content')
</body>
@endsection
