function deleteMessage(message_id, user_id) {
	$.ajax({
		type: "POST",
		url: "https://app.koreait.kr/article/user/message/delete/",
		dataType: "json",
		data: {
			message_id: message_id,
			user_id: user_id
		},
		success: function(result) {
			if (result.RESULT == "100") {
				location.href = document.referrer;
			}
		}
	});
}
