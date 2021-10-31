<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0,maximum-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="{{ asset("/css/Login/LoginPage.css") }}" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"/>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&display=swap">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    </head>
    <body class="login-body">
        <!-- 로그인 화면 학교로고 -->
            <header>
                <h1 class="login-logo">
                    <img src="images/Login_Logo.png" />
                </h1>
            </header>
        <main>
			<div class="d-flex justify-content-center align-items-center container">
				<!-- 로그인 입력 부분 -->
				<form id="loginForm" name="loginForm" action="{{route('LoginControll')}}" method="POST">
					@csrf
					<div id="loginStudentidForm">
						<i class="fas fa-user"></i>
						<div class="form-group">
							<input
								type="tel"
								class="form-control"
								id="exampleInputText"
								name="studentID"
								placeholder="Student ID"
								maxlength="8"
							/>
						</div>
					</div>
					<div id="loginPasswordForm">
						<i class="fas fa-lock"></i>
						<div class="form-group">
							<input
								type="password"
								class="form-control"
								name="studentPassword"
								id="exampleInputPassword1"
								placeholder="Password"
							/>
						</div>
					</div>
					<div class="login-auto">
						<input
							type="checkbox"
							class="form-check-input"
							id="exampleCheck1"
							name="auto_Login"
						/>
						<label
							class="form-check-label"
							for="exampleCheck1"
							style="font-weight: bold"
						>자동 로그인</label>
					</div>
					<div>
						<button
							type="submit"
							class="btn btn-primary"
							id="loginButton"
						>로그인</button>
					</div>
				</form>
			</div>
            <div class="login-option">
                <div>
                    <button
                        type="button"
                        id="resetPassword"
                        data-toggle="modal"
                        data-target="#staticBackdrop_PW_Reset"
						data-backdrop="false"
                    >PW 초기화</button>
                    <span>|</span>
                    <button
                        type="button"
                        id="searchID"
                        data-toggle="modal"
                        data-target="#staticBackdrop"
						data-backdrop="false"
                    ><i class="fas fa-search"></i> 학번 검색</button>
                </div>
            </div>
            <!--비밀번호 초기화 모달 창 띄우기-->
            <div
                class="modal fade"
                id="staticBackdrop_PW_Reset"
                data-backdrop="static"
                tabindex="-1"
                role="dialog"
                aria-labelledby="staticBackdropLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog" id="modalDialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="staticBackdropLabel">
                                비밀번호 초기화
                            </h4>
						</div>
						<div id="modalBody">
							<label>학번을 입력하세요.</label>
							<div class="student-id">
								<input
									type="tel"
									class="form-control"
									placeholder="Student ID"
									id="studentIDInput"
									name="resetStudentID"
									maxlength="8"
								/>
							</div>
							<label>주민번호를 입력하세요.</label>
							<div class="row">
								<div class=col>
									<input
									id="jumin1"
									class="form-control"
									type="tel"
									placeholder="First"
									name="inputSocialNumFirst"
									maxlength="6"
									/>
								</div>
								<div class="col">
									<input
									id="jumin2"
									class="form-control"
									type="tel"
									placeholder="Last"
									name="inputSocialNumSecond"
									maxlength="7"
									/>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button
								type="button"
								class="btn btn-secondary"
								data-dismiss="modal"
							>닫기</button>
							<button
								type="submit"
								class="btn btn-primary modal-button"
								id="resetStudentPasswordButton"
							>초기화</button>
						</div>

						<!-- 비밀번호 초기화 결과 (Success / Fail) -->
						{{-- 초기화 성공 --}}
						<div
						class="modal fade"
						id="resetSuccess"
						data-backdrop="static"
						tabindex="-1"
						role="dialog"
						aria-labelledby="staticBackdropLabel"
						aria-hidden="true"
                        >
                            <div class="modal-dialog" id="resultModalDialog" role="document">
                                <div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="staticBackdropLabel">
											비밀번호 초기화 성공 ✅
										</h4>
									</div>
                                    <div class="resultModalDialogBody">
                                        비밀번호가 주민번호 뒷자리로 <br> 초기화 되었습니다.
                                    </div>
                                    <div class="modal-footer">
										<button
											type="button"
											class="btn modal-button"
											data-dismiss="modal"
										>확인</button>
                                    </div>
                                </div>
                            </div>
                        </div>
						{{-- 초기화 실패 --}}
						<div
						class="modal fade"
						id="resetFail"
						data-backdrop="static"
						tabindex="-1"
						role="dialog"
						aria-labelledby="staticBackdropLabel"
						aria-hidden="true"
						>
							<div class="modal-dialog" id="resultModalDialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="staticBackdropLabel">
											비밀번호 초기화 실패 🚫
										</h4>
									</div>
									<div class="resultModalDialogBody">
										학번 또는 주민번호가 틀립니다. <br> 다시 확인해주세요.
									</div>
									<div class="modal-footer">
										<button
											type="button"
											class="btn modal-button"
											data-dismiss="modal"
										>확인</button>
									</div>
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>
            <!--학번 검색 모달 창 띄우기 -->
            <div
                class="modal fade"
                id="staticBackdrop"
                data-backdrop="static"
                tabindex="-1"
                role="dialog"
                aria-labelledby="staticBackdropLabel"
                aria-hidden="true"
            >
			<div class="modal-dialog" id="modalDialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="staticBackdropLabel">
							학번 검색
						</h4>
					</div>
					<div id="modalBody">
						<label>이름을 입력해주세요.</label>
						<div class="student-id">
							<input
								type="text"
								class="form-control"
								placeholder="Name"
								name="studentName"
								id="studentNameInput"
							/>
						</div>
						<label>주민번호를 입력해주세요.</label>
						<div class="row">
							<div class="col">
								<input
								class="form-control"
								placeholder="First"
								type="tel"
								id="jumin3"
								maxlength="6"
								/>
							</div>
							<div class="col">
								<input
								type="tel"
								class="form-control"
								placeholder="Last"
								id="jumin4"
								maxlength="7"
								/>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button
							type="button"
							class="btn btn-secondary"
							data-dismiss="modal"
						>닫기</button>

						<button
							id="searchStudentIDButton"
							type="button"
							class="btn btn-primary modal-button"
						>검색</button>
					</div>

					<!-- 학번 검색 결과 (Success / Fail) -->
					{{-- 검색 성공 --}}
					<div
					class="modal fade"
					id="searchStudentIDSuccess"
					data-backdrop="static"
					tabindex="-1"
					role="dialog"
					aria-labelledby="staticBackdropLabel"
					aria-hidden="true"
					>
						<div class="modal-dialog" id="resultModalDialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="staticBackdropLabel">
										학번 검색 성공 ✅
									</h4>
								</div>
								<div class="resultModalDialogBody">
									<label>학번은 </label>
									<span class="searchIDResult">
										{{-- 학번 검색 결과 --}}
									</span>
									<label>입니다.</label>
								</div>
								<div class="modal-footer">
									<button
										type="button"
										class="btn modal-button"
										data-dismiss="modal"
									>확인</button>
								</div>
							</div>
						</div>
					</div>
					{{-- 학번 검색 실패 --}}
					<div
					class="modal fade"
					id="searchStudentIDFail"
					data-backdrop="static"
					tabindex="-1"
					role="dialog"
					aria-labelledby="staticBackdropLabel"
					aria-hidden="true"
					>
						<div class="modal-dialog" id="resultModalDialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="staticBackdropLabel">
										학번 검색 실패 🚫
									</h4>
								</div>
								<div class="resultModalDialogBody">
									이름 또는 주민번호가 틀립니다. <br> 다시 확인해주세요.
								</div>
								<div class="modal-footer">
									<button
										type="button"
										class="btn modal-button"
										data-dismiss="modal"
									>확인</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
		<script type="text/javascript" src="js/LoginError.js"></script>
		@if($error == true)
		<script>
			errorMessage( "{{$errorTitle}}", "{{$errorBody}}" );
		</script>
		@endif
        <script src="{{asset('js/LoginPage/RestPassword.js')}}"></script>
        <script src="{{asset('js/LoginPage/SearchStudentNumber.js')}}"></script>
    </body>
</html>
