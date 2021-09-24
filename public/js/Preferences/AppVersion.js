var term = 0;
var first = true;
$(".appversion-logo-img").on("click", () => {
	term += 1;
	if (term > 3 && first) {
		$(".appversion-logo-img").append(
			"<button onclick=TextReplace()>안녕하세요!</button>"
		);
		first = false;
	}
});

function TextReplace() {
	var de = [
		"기획자 : 주천욱",
		"팀원 : 김형식, 박경용",
		"지원 : 전진억 부장님",
		"학과 : (전)융합 스마트",
		"문의는 직접 찾아와서 해주세요 :)"
	];

	for (var i = 0; i < 5; i++) {
		(function(x) {
			setTimeout(function() {
				$("#app_version_footer")
					.children()
					.eq(0)
					.remove();
			}, 500 * (i + 1));
		})(i);
	}

	for (var i = 0; i < 5; i++) {
		console.log(de[i]);
		(function(x) {
			setTimeout(function() {
				$("#app_version_footer").append("<div>" + de[x] + "</div>");
			}, 500 * (i + 1) + 2500);
		})(i);
	}
}
