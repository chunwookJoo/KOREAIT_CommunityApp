<!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="/admin/board/notice.css">
	<link rel="stylesheet" type="text/css" href="/admin/css/element.css">
	<title>공지 관리</title>
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
			@foreach ($result_group as $board_group)
            @if ($request->board_group == $board_group->board_group)
            {{ $board_group->board_name }}
            @endif
            @endforeach
			&nbsp;공지 관리
		</span>
	</h2>
	<div>
		<div class="kategorie-search-form">
			<div class="kategorie-form">
				<form action="" method="get" id="form_search" name="form_search">
					<div>
						<span>
							<select name="board_group" id="board_group">
								@foreach ($result_group as $board_group)
								<option class="board-group" value="{{ $board_group->board_group }}">
									{{ $board_group->board_name }}</option>
								@endforeach
							</select>
						</span>
						<span>
							<select name="college" id="college" hidden>
								@foreach ($result_college as $college)
								<option id="depart-{{ $college['sosokCode'] }}" class="board-college"
									value="{{ rtrim($college['sosokName'], "스쿨") }}" @if ($result_user->college ==
									rtrim($college['sosokName'], "스쿨")) @elseif ($result_user->role_id <= 500) @else hidden
										@endif>
										{{ rtrim($college['sosokName'], "스쿨") }}</option>
								@endforeach
							</select>
						</span>
						<span>
							<select name="depart" id="depart" hidden>
								@foreach ($result_depart as $college)
								@foreach ($college['minor'] as $depart)
								<option class="board-depart depart-{{ $college['sosokCode'] }}"
									value="{{ array_slice(explode(' ', $depart['sosokName']), -1)[0] }}">
									{{ array_slice(explode(' ', $depart['sosokName']), -1)[0] }}</option>
								@endforeach
								@endforeach
							</select>
						</span>
						<span>
							<input type="submit" id="submit" class="submit" value="보기">
						</span>
					</div>
				</form>
			</div>
			<div class="search-form">
				<div>
					<select name="search_key" id="search_key" value="{{$request->search_key}}" form="form_search">
						<option value="title">제목</option>
						<option value="content">내용</option>
						<option value="title+content">제목+내용</option>
					</select>
					<input type="text" name="search_value" id="search_value" value="{{$request->search_value}}"
						placeholder="검색어" maxlength="80" form="form_search" />
					<input type="submit" class="submit" value="검색" form="form_search" />
				</div>
			</div>
		</div>
		<hr>
		<div>
			<form action="" method="post">
				@csrf
				<table>
					<thead>
						<tr>
							<th class="board-id">ID</th>
							<th class="board-title">제목</th>
							<th class="board-author">작성자</th>
							<th class="board-readnum">조회 수</th>
							<th class="board-time">게시 일시</th>
							<th class="board-manage">공지</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($result_notice as $board)
						<tr>
							<td class="board-id">{{ $board->board_id }}</td>
							<td class="board-title"><a
									href="{{ route('_BoardView', ['board_id' => $board->board_id]) }}">{{ $board->title }}&nbsp;[{{ $board->reply_count }}]</a>
							</td>
							<td class="board-author">{{ $board->author }}</td>
							<td class="board-readnum">{{ $board->readnum }}</td>
							<td class="board-time">
								{{ (strtotime($board->time_write) >= strtotime(date("Y-m-d")) )?date("H:i:s", strtotime($board->time_write)):date("Y-m-d", strtotime($board->time_write)) }}
							</td>
							<td>
								<div>
									<input type="hidden" name="board_id[{{ $board->board_id }}]"
										id="board_id[{{ $board->board_id }}]" value="off">
									<input type="checkbox" name="board_id[{{ $board->board_id }}]"
										id="board_id[{{ $board->board_id }}]" checked>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th class="board-id"></th>
							<th class="board-title"></th>
							<th class="board-author"></th>
							<th class="board-readnum"></th>
							<th class="board-time"></th>
							<th class="board-manage"><input type="submit" value="일괄 적용"></th>
						</tr>
					</tfoot>
				</table>
			</form>
		</div>
		<hr>
		<div>
			<form action="" method="post">
				@csrf
				<table>
					<thead>
						<tr>
							<th class="board-id">ID</th>
							<th class="board-title">제목</th>
							<th class="board-author">작성자</th>
							<th class="board-readnum">조회 수</th>
							<th class="board-time">게시 일시</th>
							<th class="board-manage">공지</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($result_list as $board)
						<tr>
							<td class="board-id">{{ $board->board_id }}</td>
							<td class="board-title"><a
									href="{{ route('_BoardView', ['board_id' => $board->board_id]) }}">{{ $board->title }}&nbsp;[{{ $board->reply_count }}]</a>
							</td>
							<td class="board-author">{{ $board->author }}</td>
							<td class="board-readnum">{{ $board->readnum }}</td>
							<td class="board-time">
								{{ (strtotime($board->time_write) >= strtotime(date("Y-m-d")) )?date("H:i:s", strtotime($board->time_write)):date("Y-m-d", strtotime($board->time_write)) }}
							</td>
							<td>
								<div>
									<input type="hidden" name="board_id[{{ $board->board_id }}]"
										id="board_id[{{ $board->board_id }}]" value="off">
									<input type="checkbox" name="board_id[{{ $board->board_id }}]"
										id="board_id[{{ $board->board_id }}]" @if ($board->is_notice) checked @endif>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th class="board-id"></th>
							<th class="board-title"></th>
							<th class="board-author"></th>
							<th class="board-readnum"></th>
							<th class="board-time"></th>
							<th class="board-manage"><input type="submit" value="일괄 적용"></th>
						</tr>
					</tfoot>
				</table>
			</form>
		</div>
	</div>
	<div class="page-number">
		<div>
			@foreach ($result_page as $page)
			@if ($page && $page != $request->page_num)
			<span class="on">
				<a href="{{ route(
					'_BoardNotice',
					['page_num' => $page,
					'board_group' => $request->board_group,
					'college' => $request->college,
					'depart' => $request->depart,
					'board_is_notice' => $request->board_is_notice,
					'search_key' => $request->search_key,
					'search_value' => $request->search_value]
				) }}">{{$page}}</a>
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
		document.querySelector('#college').onchange = () => {
			var colleges = document.getElementsByClassName('board-college');
			var departs = document.getElementsByClassName('board-depart');
			var depart = document.getElementById('depart');
			var college = null;

			for (let element of colleges) {
				if (element.value == document.getElementById('college').value)
				college = element;
			}

			for (let element of departs) {
				element.hidden = true;
			}

			var departs_selected = document.getElementsByClassName(college.id);

			for (let element of departs_selected) {
				element.hidden = false;
			}

			depart.value = departs_selected.item(0).value;
		};

		document.querySelector('#board_group').onchange = () => {
			var board_group = document.querySelector('#board_group');
			if (board_group.value == 701) {
				document.getElementById('college').hidden = false;
				document.getElementById('depart').hidden = true;
			} else if (board_group.value == 702) {
				document.getElementById('college').hidden = false;
				document.getElementById('depart').hidden = false;
			} else {
				document.getElementById('college').hidden = true;
				document.getElementById('depart').hidden = true;
			}

			document.querySelector('#college').onchange();
		};

		document.getElementById('board_group').value="{{ $request->board_group ?? 701 }}";
		document.getElementById('college').value="{{ $request->college ?? $result_user->college }}";
		document.getElementById('depart').value="{{ $request->depart ?? $result_user->depart }}";

		document.querySelector('#board_group').onchange();

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
