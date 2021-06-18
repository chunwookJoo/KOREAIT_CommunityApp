<!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="/admin/board/edit.css">
	<link rel="stylesheet" type="text/css" href="/admin/css/element.css">
	<title>게시글 편집</title>
	<script>
		var msg = '{{ Session::get('alert') }}';
		var exist = '{{ Session::has('alert') }}';
		if (exist) {
			alert(msg);
		}
	</script>
</head>

<body>
	<section>
		<div>
			<form id="board" action="" method="post">
				<h2>
					<span>
						게시글 편집
					</span>
					<span>
						<input type="submit" id="submit" class="submit" value="등록">
					</span>
				</h2>
				@csrf
				<input id="board_id" name="board_id" @if ($result_board) value="{{ $board_id }}" @endif hidden>
				<div class="checkbox-select-menu">
					<p>
						<span>
							<label for="board_is_notice">공지등록</label>
							<input type="checkbox" name="board_is_notice" id="board_is_notice" @if ($result_board)
								{{ $result_board->is_notice?'checked':'' }} @else checked @endif>
						</span>
						<span style="width: 80%">
							<select name="board_group" id="board_group" @if ($result_board)
								value="{{ $result_board->board_group }}" disable @endif>
								@if ($result_group)
								@foreach ($result_group[0] as $board_group)
								<option class="board-group-notice" value="{{ $board_group->board_group }}">
									{{ $board_group->board_name }}</option>
								@endforeach
								@foreach ($result_group[1] as $board_group)
								<option class="board-group-all" value="{{ $board_group->board_group }}">
									{{ $board_group->board_name }}</option>
								@endforeach
								@elseif ($result_board)
								<option value="{{ $result_board->board_group }}">{{ $result_board->board_name }}</option>
								@endif
							</select>
						</span>
					</p>
					<p>
						<span style="width: 49%">
							<select name="college" id="college" @if ($result_board) value="{{ $result_board->college }}" disable
								@else hidden @endif>
								@if ($result_college)
								@foreach ($result_college as $college)
								<option id="depart-{{ $college['sosokCode'] }}" class="board-college"
									value="{{ rtrim($college['sosokName'], "스쿨") }}">
									{{ rtrim($college['sosokName'], "스쿨") }}</option>
								@endforeach
								@elseif ($result_board)
								<option id="depart-{{ $result_board->college }}" class="board-college"
									value="{{ $result_board->college }}">{{ $result_board->college }}
								</option>
								@endif
							</select>
						</span>
						<span style="width: 49%">
							<select name="depart" id="depart" @if ($result_board) value="{{ $result_board->depart }}" disable
								@else hidden @endif>
								@if ($result_depart)
								@foreach ($result_depart as $college)
								@foreach ($college['minor'] as $depart)
								<option class="board-depart depart-{{ $college['sosokCode'] }}"
									value="{{ array_slice(explode(' ', $depart['sosokName']), -1)[0] }}">
									{{ array_slice(explode(' ', $depart['sosokName']), -1)[0] }}</option>
								@endforeach
								@endforeach
								@elseif ($result_board)
								<option class="board-depart depart-{{ $result_board->college }}"
									value="{{ $result_board->depart }}">{{ $result_board->depart }}
								</option>
								@endif
							</select>
						</span>
					</p>
				</div>
				<div>
					<input type="text" id="board_title" name="board_title" placeholder="제목을 입력하세요." minlength="1" maxlength="50"
						@if ($result_board)value="{{ $result_board->title }}" @endif required />
				</div>
				<div>
					<textarea id="board_content" name="board_content" placeholder="내용을 입력하세요." minlength="1" maxlength="500"
						rows="20" required>@if ($result_board){{ $result_board->content }}@endif</textarea>
				</div>
			</form>
		</div>
	</section>
	<script>
		var group_notice = Array.from(document.getElementsByClassName('board-group-notice'));
		var group_all = Array.from(document.getElementsByClassName('board-group-all'));

		group_notice.forEach((v,i) => {
			v.hidden = true;
		});

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

		document.querySelector('#board_is_notice').onchange = () => {
			var notice_on = document.querySelector('#board_is_notice').checked;
			if (notice_on) {
				group_notice.forEach((v,i) => {
					v.hidden = false;
				});

				group_all.forEach((v,i) => {
					v.hidden = true;
				});

				if (group_notice[0]) {
					document.getElementById('board_group').value = group_notice[0].value;
				}
			} else {
				group_notice.forEach((v,i) => {
					v.hidden = true;
				});

				group_all.forEach((v,i) => {
					v.hidden = false;
				});

				if (group_all[0]) {
					document.getElementById('board_group').value = group_all[0].value;
				}
			}

			document.querySelector('#board_group').onchange();
		};

		document.querySelector('#board_is_notice').onchange();
	</script>
</body>

</html>
