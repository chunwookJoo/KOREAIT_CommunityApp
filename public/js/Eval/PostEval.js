const formtag = document.getElementById("submit-btn");

$('#submit-btn').click(() =>{
	var list = [];
    for(var i = 1; i <questitonSize + 1; i++){
        list.push($(`:radio[name=q${i}]:checked`).val())
    }
    fetch(route, {
		method: "POST",
		headers:{
			'Content-Type': 'application/json',
		},
		body: JSON.stringify({
			questitionSize: questitonSize,
			haksuCode: haksuCode,
            q: list,
			suggestion: $('#form-control').val()
		})
	}).then(response => response.json())
	.then(json =>{
		console.log(json);
		if(json.RESULT == 100){
			window.history.back();
		}
	});
    }
);


// 데이터 전송, 페이지 전환 방지
function handleSubmit(event) {
    event.preventDefault()
}

// 등록
function init() {
    formtag.addEventListener('submit', handleSubmit)
}
init();