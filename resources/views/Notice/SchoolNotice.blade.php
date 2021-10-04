	@extends('Layouts.MenuTitle-Back')
		<link href="{{ asset('/css/Notice/SchoolNotice.css') }}" rel="stylesheet" />
	<body>
		@section('menu-title-back')
		@endsection
		<section>
			<h1>{{ $data["title"] }}</h1>
			<div class="writeday">
				<span><small>{{ $data["name"] }}</small>
				<small>{{ $data["writeday"] }}</small></span>
				<small>조회 {{ $data["readnum"] }}</small>
			</div>

			<div class="content">
				{!! $content!!}
			</div>
		</section>
	</body>
</html>
