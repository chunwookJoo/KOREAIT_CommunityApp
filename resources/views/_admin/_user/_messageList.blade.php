<!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="/admin/css/board.css">
	<link rel="stylesheet" type="text/css" href="/admin/css/element.css">
	<title>보낸 메시지</title>
	<script>
		var msg = '{{ Session::get('alert') }}';
		var exist = '{{ Session::has('alert') }}';
		if (exist) {
			alert(msg);
		}
	</script>
</head>

<body>
	<h2>
		<span>
			보낸 메시지
		</span>
	</h2>
	<div>
		<table>
			<thead>
				<tr>
					<th class="board-id">ID</th>
					<th class="board-title">제목</th>
					<th class="board-time">발송 시각</th>
				</tr>
			</thead>
			<tbody class="tbody">
				@foreach ($result_list as $message)
				<tr onClick="location.href='{{route('_UserMessageView', ['message_id' => $message->message_id])}}'">
					<td class="board-id">{{$message->message_id}}</td>
					<td class="board-title"><a>{{$message->title}}&nbsp;</a></td>
					<td class="board-time">
						{{ (strtotime($message->time_sent) >= strtotime(date("Y-m-d")) )?date("H:i:s", strtotime($message->time_sent)):date("Y-m-d", strtotime($message->time_sent)) }}
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div class="page-number">
		<div>
			@foreach ($result_page as $page)
			@if ($page && $page != $request->page_num)
			<span class="on">
				<a href="{{route(
					'_BoardList',
					['page_num' => $page]
				)}}">{{$page}}</a>
			</span>
			@elseif ($page)
			<span>
				<a>
					{{$page}}
				</a>
			</span>
			@endif
			@endforeach
		</div>
	</div>
	<script>
		const pagenumber = document.querySelector(".on");
		pagenumber.addEventListener("click", () => {
			if(pagenumber.className === "on"){
				pagenumber.classList.remove("on");
			}
			else{
				pagenumber.classList.add("on");
			}
		});
	</script>
</body>

</html>
