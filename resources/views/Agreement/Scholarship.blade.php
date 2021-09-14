@extends('layouts.AgreementLayout')
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
		<div>
			<span>
				장학금액&nbsp;:&nbsp;600,000원
			</span>
		</div>
	</section>
	<article id="scholarship_article">
	<span>*해당 장학규정*</span>
	⑰ 교육비지원 장학금
		<p>
			1. <br/>
		전공과목 외에 교양수업을 듣기 원하는 학생 대상으로 학점이 인정되는 타기관의 오프라인 출석제 강좌(온라인 사이버 강의는 제외)를 수강할 경우,수강료의 전액을 장학금으로 지급한다.
		단 개강 후 1주일 이내에 신청하여야 하며 신청이 없을 경우 본교에서 지정한 교육기관으로 수강한다. <br/>
		</p>
		<p>
			2. <br/>
			교양수업 수강을 원하지 않을 경우 사유에 관계없이 해당 장학금은 포기하는 것으로 한다. <br/>
		</p>
		<p>
			3. <br/>
			교육비지원 장학금은 해당기관의 수강료를 근거로 본교에서 수업기관으로 직접 입금하는 것을 원칙으로 한다. <br/>
		</p>
		<p>
			4. <br/>
			교육비지원 장학금은 매학기 지급하는 것을 원칙으로 하며 타 장학금과 무관하게 지급한다. <br/>
		</p>
		<p>
			5. <br/>
			교육비 지원 장학금으로 수강한 수업은 학점 취득내용을 본교에 알려야 하며 학점을 취득하지 못 하였을 경우(F학점) 다음 학기 교육비 지원 장학금 대상에서 제외 될 수 있다.
			위 내용과 같이 본교 장학금 규정 제8조 17항에 의거하여 교육비지원 장학금 대상자임을 증명하며 이에 장학증서를 드립니다. <br/>
		</p>
		<span>{{$today}}</span>
		<span>학생확인 : {{$studentName}}</span>
	</article>
	@section('agreement-content')
</body>
@endsection
