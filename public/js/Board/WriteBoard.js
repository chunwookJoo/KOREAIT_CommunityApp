let selectOp = document.getElementById("board-select");
let submitBtn = document.getElementById("boardButton");
let titleInput = document.getElementById("board-title-text");
let contentInput = document.getElementById("board-content-text");

submitBtn.disabled = true;

selectOp.addEventListener("change", value => {
	let target = value.target.options.selectedIndex;
	if (target == 0) {
		submitBtn.disabled = true;
	}
});

titleInput.addEventListener("keydown", writingHandle);
contentInput.addEventListener("keydown", writingHandle);

function writingHandle() {
	if (titleInput.value !== "" || contentInput.value !== "") {
		submitBtn.disabled = false;
	} else {
		submitBtn.disabled = true;
	}
}
