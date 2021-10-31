// 학번 검색 후 성공 or 실패 모달 창 띄우는 코드

var jumin3 = document.getElementById("jumin3");
var jumin4 = document.getElementById("jumin4");
var studentName = document.getElementById("studentNameInput");
var searchStudentNumBtn = document.getElementById("searchStudentIDButton");
const searchIDModalBody = document.querySelector(".searchIDResult");

searchStudentNumBtn.addEventListener("click", () => {
	var socialNum = jumin3.value + jumin4.value;
	fetch("https://app.koreait.kr/SearchStudentNumber/API", {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
		},
		body: JSON.stringify({
			studentName: studentName.value,
			socialNum: socialNum
		})
	})
		.then(response => response.json())
		.then(json => {
			if (json[0].RESULT == 100) {
				$("#searchStudentIDSuccess").modal("show");
				searchIDModalBody.innerText = `${json[0].HAKBUN}`;
			} else {
				$("#searchStudentIDFail").modal("show");
			}
		});
});
