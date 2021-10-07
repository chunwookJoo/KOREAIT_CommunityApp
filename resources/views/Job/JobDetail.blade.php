@extends('Layouts.BottomNavigation')
@extends('Layouts.MenuTitle-Back')
<link href="{{ asset('css/Job/JobArticle.css') }}" rel="stylesheet" />
@section('content')
<body>
	@section('menu-title-back') @endsection
	<section>
		<article>
			<label>회사정보</label>
			<h3 class="announce-title">{{ $response["title"] }}</h3>
			<h6>{{ $response["co_name"] }}</h6>
			<div class="company-info-1">
				<div>
					<small style="color: #a3a3a3">담당자 &nbsp</small
					><small>{{ $response["name"] }}</small>
				</div>
				<div>
					<small style="color: #a3a3a3">직원수 &nbsp</small
					><small>{{ $response["co_persons"] }}</small>
				</div>
			</div>
			<div class="company-info-2">
				<small>{{ $response["email"] }}</small>
				<small>{{ $response["tel"] }}</small>
			</div>
			<small>{{ $response["address1"] }}</small>
		</article>
		<article class="announce-article">
			<label>모집정보</label>
			<!--공고내용-->
			<div class="announce-content">{{ $response["co_intro"] }}</div>
			<div class="article-grid">
				<span>모집직종 &nbsp</span
				><span>{{ $response["incrute_kind"] }}</span>
				<span>고용형태 &nbsp</span
				><span>{{ $response["job_kind"] }}</span>
				<span>급여 &nbsp</span
				><span>{{ $response["job_pay"] }}</span>
				<span>근무시간 &nbsp</span
				><span>{{ $response["work_time"] }}</span>
				<span>복리후생 &nbsp</span
				><span>{{ $response["etc"] }}</span>
			</div>
		</article>
		<article>
			<label>지원자격</label>
			<div class="article-grid">
				<span>최종학력 &nbsp</span
				><span>{{ $response["gradu_rate"] }}</span>
				<span>경력 &nbsp</span
				><span>{{ $response["career_year"] }}</span>
				<span>성별 &nbsp</span
				><span>{{ $response["sex_kind"] }}</span>
				<span>연령 &nbsp</span
				><span>{{ $response["age_year"] }}</span>
			</div>
		</article>
		<article>
			<label>지원방법 및 제출서류</label>
			<div class="article-grid">
				<span>제출서류 &nbsp</span
				><span>{{ $response["with_paper"] }}</span>
				<span>전형방법 &nbsp</span
				><span>{{ $response["howtoapply"] }}</span>
				<span>마감일자 &nbsp</span
				><span style="color: #e65a5a">{{ $response["day_limited"] }}</span>
				<span>제출방법 &nbsp</span
				><span>{{ $response["howtosend_kind"] }}</span>
			</div>
		</article>
	</section>
</body>
@endsection
