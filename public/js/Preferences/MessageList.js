var page = 2;
$(this).scroll(function() {
	if ($(this).scrollTop() > $(document).height() - $(window).height() - 100) {
		$.ajax({
			type: "POST",
			url: "https://app.koreait.kr/article/user/message/list/",
			dataType: "json",
			data: {
				page_num: page,
				page_size: "10"
			},
			success: function(result) {
				for (var i = 0; i < result.length; i++) {
					$("#message_list").append(
						`<div>
							<li>
								<a href='/Preferences/Message/detail/${result[i].message_id}'>
									<h5>
										${result[i].title}
									</h5>
									<div class="write-day">
										<span>${result[i].sender} </span>
										<span>${result[i].time_sent} </span>
									</div>
								</a>
							</li>
						</div>`
					);
				}
			}
		});
		page++;
	}
});
