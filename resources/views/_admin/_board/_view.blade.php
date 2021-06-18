<!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="/admin/css/board.css">
	<link rel="stylesheet" type="text/css" href="/admin/board/view.css">
	<title>{{$result_board->title}}</title>
	<script>
		var msg = '{{ Session::get('alert') }}';
		var exist = '{{ Session::has('alert') }}';
		if (exist) {
			alert(msg);
		}
	</script>
</head>

<body>
	<div class="board-title">
		<div class="board-view">
			<label>{{$result_board->board_name}}</label><br>
			<h1>{{$result_board->title}}</h1>
			조회수: {{$result_board->readnum}}&emsp;
			작성자: {{$result_board->author}}
		</div>
		<div class="board-mod-del-button">
			게시 시각: {{$result_board->time_write}} | 수정 시각: {{$result_board->time_modify}}
			<div id="board_buttons">
				<form action="{{route('_BoardDelete')}}" method="post">
					@csrf
					<input id="board_id" name="board_id" value="{{$board_id}}" hidden>
					<input type="submit" value="삭제">
				</form>
				@if ($manage==2)
				<form action="{{route('_BoardModify')}}" method="get">
					<input id="board_id" name="board_id" value="{{$board_id}}" hidden>
					<input type="submit" value="수정">
				</form>
				@endif
			</div>
		</div>
	</div>
		<div id="board_content">
			{{$result_board->content}}
		</div>
		@if ($manage>=1)
		@endif
		<span>댓글 ></span>
		<div class="comment-container">
			@foreach ($result_reply as $reply)
			<div class="reply">
				<div class="reply_content">{{ $reply->content }}</div>
				<div class="reply_author">{{ $reply->author }} @if ($reply->talk_to) -> {{ $reply->talk_to }} @endif
				</div>
				<div>
					<span>좋아요:</span>
					<span class="reply_like">{{ $reply->like_count }}</span>
					<span>&nbsp;|&nbsp;</span>
					<span class="reply_time">{{ $reply->time_write }}</span>
				</div>
			</div>
			@endforeach
		</div>
</body>

</html>
