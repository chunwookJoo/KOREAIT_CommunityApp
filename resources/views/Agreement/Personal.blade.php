@extends('layouts.AgreementLayout')
<link href="{{ asset('/css/Agreement/Style.css') }}" rel="stylesheet"/>
<body class="global-section" id="capture">
	<h1>{{$title}}</h1>
	<article id="personal_article">
		<p>학점은행 평생교육원에서는 학점인정 및 학위수여 등과 관련하여 귀하의 개인정보를 아래와 같이 수집․이용․제3자 제공을 하고자 합니다. 다음의 사항에 대해 충분히 읽어보신 후, 동의 여부를 체크, 서명하여 주시기 바랍니다.</p>
		<p>
			<img src="/images/personal1.jpg" alt="개인정보"/>
			<button>동의함</button>
			<button>동의하지 않음</button>
		</p>
		<p>
			<img src="/images/personal2.jpg" alt="개인정보"/>
			<button>동의함</button>
			<button>동의하지 않음</button>
		</p>
		<p>
			<img src="/images/personal3.jpg" alt="개인정보"/>
			<button>동의함</button>
			<button>동의하지 않음</button>
		</p>
		<p>본인은 본 “개인정보의 수집․이용․제3자 제공 동의서” 내용을 읽고 명확히 이해하였으며, 이에 동의합니다.</p>
		<span>생년월일 : {{$birthday}}</span>
		<span>성명 : {{$studentName}}</span>
	</article>
	@section('agreement-content')
</body>
@endsection
