<!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="/admin/css/board.css">
	<link rel="stylesheet" type="text/css" href="/admin/css/element.css">
	<title>전체 게시물</title>
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
			전체 게시물
		</span>
	</h2>
	<div>
		<div class="search-form">
			<form action="" method="get">
				<select name="board_group" id="board_group" value="{{$request->board_group}}">
					<option value="0">전체</option>
					@foreach ($result_group as $board_group)
					<option value="{{$board_group->board_group}}">{{$board_group->board_name}}</option>
					@endforeach
				</select>
				<select name="search_key" id="search_key" value="{{$request->search_key}}">
					<option value="title">제목</option>
					<option value="content">내용</option>
					<option value="title+content">제목+내용</option>
				</select>
				<input type="text" name="search_value" id="search_value" value="{{$request->search_value}}"
					placeholder="검색어" minlength="1" maxlength="30" size="30" />
				<input type="submit" class="submit" value="확인">
			</form>
		</div>
		<table>
			<thead>
				<tr>
					<th class="board-id">ID</th>
					<th class="board-title">제목</th>
					<th class="board-author">작성자</th>
					<th class="board-readnum">조회 수</th>
					<th class="board-time">게시 일시</th>
				</tr>
			</thead>
			<tbody class="tbody">
				@foreach ($result_list as $board)
				<tr id="listItem" onClick="location.href='{{route('_BoardView', ['board_id' => $board->board_id])}}'">
					<td class="board-id">{{$board->board_id}}</td>
					<td class="board-title"><a>@if($board->board_group ==
							701)<label>[{{$board->college}}]</label> @elseif ($board->board_group ==
							702)<label>[{{$board->depart}}]</label> @endif{{$board->title}}&nbsp;<span>[{{ $board->reply_count }}]</span></a></td>
					<td class="board-author">{{$board->author}}</td>
					<td class="board-readnum">{{$board->readnum}}</td>
					<td class="board-time">
						{{ (strtotime($board->time_write) >= strtotime(date("Y-m-d")) )?date("H:i:s", strtotime($board->time_write)):date("Y-m-d", strtotime($board->time_write)) }}
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
					['page_num' => $page,
					'board_group'=> $request->board_group,
					'search_key'=> $request->search_key,
					'search_value'=> $request->search_value]
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
		document.getElementById('board_group').value="{{$request->board_group ?? 0}}";
		document.getElementById('search_key').value="{{$request->search_key ?? 'title'}}";

		const pagenumber = document.querySelector(".on");
		pagenumber.addEventListener("click", () => {
			if(pagenumber.className === "on"){
				pagenumber.classList.remove("on");
			}
			else{
				pagenumber.classList.add("on");
			}
		})
	</script>
</body>

</html>
