<!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="/admin/css/board.css">
	<link rel="stylesheet" type="text/css" href="/admin/board/view.css">
	<title>{{$result->title}}</title>
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
			<h1>{{$result->title}}</h1>
			발신자: {{$result->college}} {{$result->name}}
		</div>
		<div class="board-mod-del-button">
			발송 시각: {{$result->time_sent}}
			<div id="board_buttons">
				<form action="{{route('_UserMessageDelete')}}" method="post">
					@csrf
					<input id="message_id" name="message_id" value="{{$message_id}}" hidden>
					<input type="submit" value="삭제">
				</form>
			</div>
		</div>
	</div>
	<div id="board_content">
		{{$result->content}}
	</div>
</body>

</html>
