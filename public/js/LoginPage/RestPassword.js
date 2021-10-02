var resetBtn = document.getElementById("resetStudentPasswordButton");
var resetStudentId = document.getElementById("studentIDInput");
var resetSocialNumFrist = document.getElementById("jumin1");
var resetSocialNumSecond = document.getElementById("jumin2");

resetBtn.addEventListener("click", () => {
	var fullSocialNum = resetSocialNumFrist.value + resetSocialNumSecond.value;
	var resetPasswordUrl = "https://app.koreait.kr/ResetPassword/API";

	resetBtn.disabled = "disabled";

	fetch(resetPasswordUrl, {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
		},
		body: JSON.stringify({
			ResetStudentID: resetStudentId.value,
			FullSocialNum: fullSocialNum
		})
	})
		.then(response => response.json())
		.then(json => {
			if (json.RESULT == 100) {
				$("#resetSuccess").modal("show");
				$("#resetSuccess").removeClass("fade");
				resetBtn.disabled = "";
			} else {
				$("#resetFail").modal("show");
				$("#resetFail").removeClass("fade");
				resetBtn.disabled = "";
			}
		});
});
