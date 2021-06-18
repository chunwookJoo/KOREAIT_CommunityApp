@extends('layouts.MenuTitle-Back')
	@section('menu-title-back') @endsection
	<link href="{{ asset('/css/Preferences/MyProfile.css') }}" rel="stylesheet" />
	<link rel="stylesheet"
		href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"/>
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"/>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<body>
	<section>
		<div>이름<span>{{ $response["user_name"] }}</span></div>
		<div>
			@if ($response['nickname'])
				<input
				id="nickname"
				type="text"
				name="nickname"
				value="{{ $response['nickname'] }}"
			/>
			@else
			<input id="nickname" type="text" name="nickname" placeholder="별명을 입력하세요."/>
			@endif
			<input
				type="button"
				value="변경"
				class="btn nickname-change"
				onclick="post_nickname({{ $student_id }})"
				data-toggle="modal"
				data-target="#changeSuccess"
			/>
		</div>
		<div>계열<span>{{ $response["college"] }}</span></div>
		<div>학과<span>{{ $response["depart"] }}</span></div>
		<div>학년<span>{{ $response["year"] }}</span></div>
	</section>
	<div class="modal fade" id="changeSuccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" id="nicknameModalDialog" role="document">
		  <div class="modal-content">
			<div class="modal-body" id="nicknameModalBody">
				별명이 성공적으로 변경되었습니다.
			</div>
			<div class="modal-footer">
			  <button type="button" id="nickname-modal-success" class="btn" data-dismiss="modal">확인</button>
			</div>
		  </div>
		</div>
	  </div>
	<a href="{{ route('LogOut') }}">
		<div class="logout">
			<button
				href="{{ route('LogOut') }}"
				type="button"
				class="btn btn-secondary btn-lg"
			>
			로그아웃
			</button>
		</div>
	</a>
	<script>
		function post_nickname(studentID) {
			$.ajax({
				type: "POST",
				url: "https://app.koreait.kr/article/user/set/nickname/",
				dataType: "json",
				data: {
					user_id: studentID,
					nickname: $("#nickname").val(),
				},
				success: function (result) {
					if (result.RESULT == "100") {
						//location.href = location.href;

					}
				},
			});
		}
	</script>
</body>
