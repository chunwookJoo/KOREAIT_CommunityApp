<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1.0, minimum-scale=1.0,maximum-scale=1.0"
		/>
		{{-- <meta
			http-equiv="Content-Security-Policy"
			content="upgrade-insecure-requests"
		/> --}}
		<link
		href="{{ asset('/css/Layouts/AgreementLayout.css') }}"
		rel="stylesheet"
		/>
		<link
		href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
		rel="stylesheet"
		/>
		<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&display=swap" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script
      		src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"
      		integrity="sha512-OqcrADJLG261FZjar4Z6c4CfLqd861A3yPNMb+vRQ2JwzFT49WT4lozrh3bcKxHxtDTgNiqgYbEUStzvZQRfgQ=="
     		crossorigin="anonymous"
    		referrerpolicy="no-referrer"
    	></script>
	</head>
	@yield('agreement-content')
	<p id="studentID" style="display: none">{{$studentID}}</p>
	<p id="hakgi" style="display: none">{{$hakgi}}</p>
	<section class="sign-section">
		<div>
			<canvas id="jsCanvas" class="canvas" width="300" height="150"></canvas>
			<div class="signature-text">
			<span>마우스로 서명하세요.</span>
			</div>
		</div>
		<button class="agreement-btn" onclick="onClear()">서명 초기화</button>
		<button onclick="btnClick()" type="submit" id="submit_button" class="agreement-btn">
			제출
		</button>
		{{-- <div class="modal" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
			  <div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title">안내</h5>
				</div>
				<div class="modal-body">
				  <p>개인정보 수집 이용에 모두 동의를 눌러주세요.</p>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-primary">닫기</button>
				</div>
			  </div>
			</div>
		  </div> --}}
	</section>
	<footer>
		<span>한국IT직업전문학교장 귀하</span>
	</footer>
	<script type="text/javascript">
		if (window.addEventListener) {
		window.addEventListener('load', InitEvent, false);
		}

		let context, tool;
		const signatureText = document.querySelector(".signature-text");
		const canvas = document.getElementById('jsCanvas');

		function InitEvent() {

			if (!canvas) {
			console.log("캔버스 객체를 찾을 수 없음");
			return;
			}

			if (!canvas.getContext) {
			console.log("Drawing Contextf를 찾을 수 없음");
			return;
			}

			context = canvas.getContext('2d');
			context.lineWidth = "2";
			if (!context) {
			console.log("getContext() 함수를 호출 할 수 없음");
			return;
			}
			// Pencil tool 객체를 생성 한다.
			tool = new tool_pencil();
			canvas.addEventListener('mousedown', ev_canvas, false);
			canvas.addEventListener('mousemove', ev_canvas, false);
			canvas.addEventListener('mouseup', ev_canvas, false);
			canvas.addEventListener('touchstart', ev_canvas, false);
			canvas.addEventListener('touchmove', ev_canvas, false);
			canvas.addEventListener('touchend', ev_canvas, false);
		}

		function tool_pencil() {
			var tool = this;
			this.started = false;

			// 마우스를 누르는 순간 그리기 작업을 시작 한다.
			this.mousedown = function (ev) {
			context.beginPath();
			context.moveTo(ev._x, ev._y);
			tool.started = true;
			signatureText.classList.add("blind");
			canvas.style.marginBottom="24px";
			};
			// 마우스가 이동하는 동안 계속 호출하여 Canvas에 Line을 그려 나간다
			this.mousemove = function (ev) {
			if (tool.started) {
				context.lineTo(ev._x, ev._y);
				context.stroke();
			}
			};
			// 마우스 떼면 그리기 작업을 중단한다
			this.mouseup = function (ev) {
			if (tool.started) {
				tool.mousemove(ev);
				tool.started = false;
			}
			};

			// 터치를 누르는 순간 그리기 작업을 시작 한다.
			this.touchstart = function (ev) {
			context.beginPath();
			context.moveTo(ev._x, ev._y);
			tool.started = true;
			signatureText.classList.add("blind");
			canvas.style.marginBottom="24px";
			};

			// 터치가 이동하는 동안 계속 호출하여 Canvas에 Line을 그려 나간다
			this.touchmove = function (ev) {
			if (tool.started) {
				context.lineTo(ev._x, ev._y);
				context.stroke();
				}
			};
			// 터치 떼면 그리기 작업을 중단한다
			this.touchend = function (ev) {
			if (tool.started) {
				tool.touchmove(ev);
				tool.started = false;
				}
			};
		}

		// Canvas요소 내의 좌표를 결정 한다.
		function ev_canvas(ev) {
			if (ev.layerX || ev.layerX == 0) { // Firefox 브라우저
			ev._x = ev.layerX;
			ev._y = ev.layerY;
			}
			else if (ev.targetTouches[0]) {	//핸드폰
			var left = 0;
			var top = 0;
			var elem = document.getElementById('jsCanvas');

			while (elem) {
				left = left + parseInt(elem.offsetLeft);
				top = top + parseInt(elem.offsetTop);
				elem = elem.offsetParent;
			}

			ev._x = ev.targetTouches[0].pageX - left;
			ev._y = ev.targetTouches[0].pageY - top;
			}
			// tool의 이벤트 핸들러를 호출한다.
			var func = tool[ev.type];
			if (func) {
			func(ev);
			}
		}

		function onClear() {
			context.save();
			context.setTransform(1, 0, 0, 1, 0, 0);
			context.clearRect(0, 0, canvas.width, canvas.height);
			context.restore();
		}
	</script>

	<script>
		let submitButton = document.getElementById("submit_button");
		let jsCanvs = document.getElementById("jsCanvas");

		submitButton.classList.add("disabled");
		submitButton.disabled = true;

		jsCanvs.addEventListener("touchend", submitHandle);
		jsCanvs.addEventListener("mouseup", submitHandle);

		function submitHandle() {
			submitButton.classList.remove("disabled");
			submitButton.disabled = false;
		}

		function btnClick() {
				html2canvas(document.querySelector("#capture"), {}).then(canvas => {
				canvas.toBlob((blob) => {
					const URL_POST_SIGNATURE = "https://app.koreait.kr/article/user/signature/";

					var formData = new FormData();
					formData.append("image", blob);
					formData.append("student_id", document.getElementById("studentID").innerText);
					formData.append("hakgi", document.getElementById("hakgi").innerText);
					formData.append("form_type", location.pathname.split("\/")[2]);

					var xhr = new XMLHttpRequest();
					xhr.responseType = "json";
					xhr.onload = () => {
						var jsonResponse = xhr.response;
						if (jsonResponse.RESULT == 100) location.href = "/AgreementCheck"
					};

					xhr.open("POST", URL_POST_SIGNATURE, true);
					xhr.send(formData);
				})
			});
		}

		// function saveAs(uri, filename) {
		// 	let link = document.createElement("a");
		// 	if (typeof link.download === "string") {
		// 		link.href = uri;
		// 		link.download = filename;
		// 		document.body.appendChild(link);
		// 		link.click();
		// 		document.body.removeChild(link);
		// 	} else {
		// 		window.open(uri);
		// 	}
		// }
	</script>
</html>
