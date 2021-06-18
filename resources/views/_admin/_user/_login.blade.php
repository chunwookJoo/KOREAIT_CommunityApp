<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, minimum-scale=1.0,maximum-scale=1.0"
    />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css"
      integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" type="text/css" href="/admin/user/login.css" />
    <title>학사 앱 관리자 로그인</title>
    <script>
      var msg = '{{ Session::get('alert') }}';
      var exist = '{{ Session::has('alert') }}';
      if (exist) {
      	alert(msg);
      }
    </script>
  </head>

  <body>
	<div class="back-color"></div>
    <header class="header">
		<img src="/images/Logo.png" width="100px" height="100px" />
		<h1>관리자 로그인</h1>
	  </header>
    <section>
      <form action="{{route('_UserLogin')}}" method="POST">
        @csrf
        <div class="radioBtn">
			<label for="staff">
			  <input
				type="radio"
				name="position"
				id="staff"
				value="staff"
				checked
			  />
			  교/직원</label
			>
			<label for="student"
			  ><input type="radio" name="position" id="student" value="student" />
			  학생</label
			>
		  </div>
        <div>
          <input
            class="form-control"
            type="text"
            id="id"
            name="id"
            placeholder="학번/사번"
          />
        </div>
        <div>
          <input
            class="form-control"
            type="password"
            id="pw"
            name="pw"
            placeholder="비밀번호"
          />
        </div>
        <div>
          <input
            class="btn btn-primary"
            type="submit"
            id="submit"
            name="submit"
            value="로그인"
          />
        </div>
      </form>
    </section>
  </body>
</html>
