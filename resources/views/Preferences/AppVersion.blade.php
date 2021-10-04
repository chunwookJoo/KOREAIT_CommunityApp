@extends('Layouts.MenuTitle-Back')
	@section('menu-title-back') @endsection
	<link href="{{ asset('/css/Preferences/AppVersion.css') }}" rel="stylesheet" />
	<link rel="stylesheet"
		href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"/>
	<link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"
	/>
	<script
		src="https://code.jquery.com/jquery-3.5.1.min.js"
	></script>
<body>
	<section>
		<div class="appversion-logo-img">
			<img
				src="{{ asset('images/Logo.png') }}"
				width="100px"
				height="100px"
			/><div>현재버전 : 2.0.0</div>
		</div>
	</section>
	<footer id="app_version_footer">
		<div>재학생 문의 : 02-578-2200</div>
		<div>Fax : 02-578-9866</div>
		<div>🥕</div>
		<div>팀원 : 주천욱, 김형식, 박경용</div>
		<div>학부/학과 : 인공지능 컴퓨터공학</div>
	</footer>
	<script type="text/javascript" src="{{asset("js/Preferences/AppVersion.js")}}"></script>
</body>
