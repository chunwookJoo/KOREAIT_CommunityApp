@extends('Layouts.AgreementLayout')
<link href="{{ asset('/css/Agreement/Style.css') }}" rel="stylesheet"/>
<body class="global-section" id="capture">
	<h1>{{$title}}</h1>
	<section class="student-info-section">
		<div>
			<span>
				학&emsp;&emsp;과&nbsp;:&nbsp;{{$sosokName}}
			</span>
		</div>
		<div>
			<span>
				학&emsp;&emsp;번&nbsp;:&nbsp;{{$studentID}}
			</span>
		</div>
		<div>
			<span>
				생년월일&nbsp;:&nbsp;{{$birthday}}
			</span>
		</div>
		<div>
			<span>
				이&emsp;&emsp;름&nbsp;:&nbsp;{{$studentName}}
			</span>
		</div>
	</section>
	<article id="software_article">
		본인은 정품 소프트웨어 사용에 대한 내용을 준수하여 수업 중 사용하는
		정품 소프트웨어를 제외하고 개인적으로 불법 소프트웨어를 복제하여 사용하지 않겠습니다. 교내에서 불법 소프트웨어를 복제 설치한 경우 소프트웨어에 대한 책임은 본인에게 있음을 서약합니다.
		<br/>
		<br/>
		<span>{{$today}}</span>
		<span>서약자 : {{$studentName}}</span>
	</article>
	@section('agreement-content')
</body>
@endsection

