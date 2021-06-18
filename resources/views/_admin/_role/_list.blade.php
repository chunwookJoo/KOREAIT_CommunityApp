<!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="/admin/css/role.css">
	<link rel="stylesheet" type="text/css" href="/admin/css/element.css">
	<title>관리자 목록</title>
	<script>
		var msg = '{{ Session::get('alert') }}';
		var exist = '{{ Session::has('alert') }}';
		if (exist) {
			alert(msg);
		}
	</script>
</head>

<body>
	<section class="section-role">
		<div class="admin-role">
			<h2>
				<span>
					관리자 권한 설정
				</span>
			</h2>
			<div class="dropdown">
				<label for="role_search">관리자 조회</label>
				<select name="role_search" id="role_search">
					<option value="role-name">전체</option>
					@foreach ($result_role as $role)
					<option value="{{$role->role_id}}">{{$role->role_name}}</option>
					@endforeach
				</select>
			</div>
			<form id="role" action="{{route('_RoleList')}}" method="post">
				@csrf
				<select name="user_id" id="user_id" size="10">
					@foreach ($result_user as $user)
					<option class="role-name {{$user->role_id}}" value="{{$user->user_id}}">{{$user->user_name}}
						[{{$user->role_name}}]</option>
					@endforeach
				</select>
				<div class="dropdown">
					<div>
						<label for="role_option">권한 설정</label>
						<select name="role_option" id="role_option">
							@foreach ($result_role as $role)
							<option value="{{$role->role_id}}">{{$role->role_name}}</option>
							@endforeach
						</select>
					</div>
					<input type="submit" id="submit" class="submit" value="확인">
				</div>
			</form>
		</div>
		<div class="user-role">
			<h2>
				<span>
					일반 사용자 권한 설정
				</span>
			</h2>
			<form id="role" action="{{route('_RoleList')}}" method="post">
				@csrf
				<input type="tel" id="user_id" name="user_id" placeholder="학번/사번" />
				<div class="dropdown">
					<div>
						<label for="role_option">권한 설정</label>
						<select name="role_option" id="role_option">
							@foreach ($result_role as $role)
							<option value="{{$role->role_id}}">{{$role->role_name}}</option>
							@endforeach
						</select>
					</div>
					<input type="submit" id="submit" class="submit" value="확인">
				</div>
			</form>
		</div>
	</section>
	<script>
		document.querySelector('#role_search').onchange = () => {
			var options_all = document.getElementsByClassName('role-name');
			var options_selected = document.getElementsByClassName(document.querySelector('#role_search').value);

			for (let element of options_all) {
				element.hidden = true;
			}

			for (let element of options_selected) {
				element.hidden = false;
			}
		};
	</script>
</body>

</html>
