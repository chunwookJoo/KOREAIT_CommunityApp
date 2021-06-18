{{-- <!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="/admin/css/home.css">
	<title>Home</title>
	<script>
		var msg = '{{ Session::get('alert') }}';
		var exist = '{{ Session::has('alert') }}';
		if (exist) {
			alert(msg);
		}
	</script>
</head>

<body>
	<div>
		@if ($result)
		<div>
			관리자 이름 : {{$result['user_name'] ?? ''}}
		</div>
		<div>
			학번 / 사번 : {{$result['id'] ?? ''}}
		</div>
		<div>
			역할 : {{$result['role_name'] ?? ''}}
		</div>
		@else
		내부 오류 발생
		@endif
	</div>
</body>

</html> --}}
