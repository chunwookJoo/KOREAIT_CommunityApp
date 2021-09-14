@extends('layouts.MenuTitle-Back')
<body>
	@section('menu-title-back')
	<link href="{{ asset('/css/Preferences/MessageDetail.css') }}" rel="stylesheet" />
	<section>
		<h4>{{ $response["title"] }}</h4>
		<div class="writeday">
			<span>
				<small>{{ $response["college"] }}</small>
				<small>{{ $response["name"] }}</small>
				<small>{{ $response["time_sent"] }}</small>
			</span>
			<a
				type="button"
				id="board-trash"
				data-toggle="modal"
				data-target="#myMessage-delete-modal"
				><i class="fas fa-trash-alt"></i
			></a>

			{{-- 게시판 삭제 모달 창 띄우기 --}}
			<div
				class="modal fade"
				id="myMessage-delete-modal"
				tabindex="-1"
				role="dialog"
				aria-labelledby="exampleModalCenterTitle"
				aria-hidden="true"
			>
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">
								메세지 삭제
							</h5>
						</div>
						<div class="modal-body">
							이 메세지를 삭제하시겠습니까?
						</div>
						<div class="modal-footer">
							<button
								type="button"
								class="btn btn-secondary"
								data-dismiss="modal"
							>
								취소
							</button>
							<a
								href="javascript:void(0)"
								type="button"
								class="btn btn-primary"
								id="delete-confirm"
								onclick="deleteMessage({{ $message_id }},{{
									$student_id
								}})"
								value="삭제"
								>삭제</a
							>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="content">
			{{$response['content']}}
		</div>
	</section>
	<script src="{{ asset('./js/Preferences/MessageDelete.js') }}"></script>
</body>
@endsection
