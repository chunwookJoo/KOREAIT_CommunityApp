let formtag = document.getElementById("submit-btn");
let textarea = document.getElementById("floatingTextarea2");

// 건의사항 빈 값 오류 경고창
function errorMessage() {
	Swal.fire({
		icon: "warning",
		title: "건의사항 에러",
		text: "건의사항을 작성해주세요."
	});
}

$("#submit-btn").click(() => {
	var list = [];

	if (textarea.value == "") {
		errorMessage();
		return;
	}
	for (var i = 1; i < questitonSize + 1; i++) {
		list.push($(`:radio[name=q${i}]:checked`).val());
	}
	fetch(route, {
		method: "POST",
		headers: {
			"Content-Type": "application/json"
		},
		body: JSON.stringify({
			questitionSize: questitonSize,
			haksuCode: haksuCode,
			q: list,
			suggestion: $("#floatingTextarea2").val()
		})
	})
		.then(response => response.json())
		.then(json => {
			if (json[0].RESULT == 100) {
				location.href = "/Haksa/List";
			}
		});
});

// 데이터 전송, 페이지 전환 방지
function handleSubmit(event) {
	event.preventDefault();
}

// 등록
function init() {
	formtag.addEventListener("submit", handleSubmit);
}
init();
