{{-- <!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="/admin/css/role.css">
	<title>권한 설정</title>
	<script>
		var msg = '{{ Session::get('alert') }}';
		var exist = '{{ Session::has('alert') }}';
		if (exist) {
			alert(msg);
		}
	</script>
</head>

<body>
	<h3>권한 설정</h3>
	<div>
		<form id="role" action="{{route('_RoleSet')}}" method="post">
			@csrf
			<input type="tel" id="user_id" name="user_id" placeholder="학번/사번"
				oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
			<div class="dropdown">
				<div>
					<label for="role_option">권한</label>
					<select name="role_option" id="role_option">
						@foreach ($result as $role)
						<option value="{{$role->role_id}}">{{$role->role_name}}</option>
						@endforeach
					</select>
				</div>
				<input type="submit" id="submit" value="확인">
			</div>
		</form>
	</div>
</body>

</html> --}}
