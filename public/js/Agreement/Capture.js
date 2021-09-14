function btnClick() {
	html2canvas(document.querySelector("#capture"), {}).then(canvas => {
		console.log("찰칵");
		saveAs(canvas.toDataURL(), "캡쳐.png");
	});
}

function saveAs(uri, filename) {
	let link = document.createElement("a");
	console.log(typeof link.download);
	if (typeof link.download === "string") {
		link.href = uri;
		link.download = filename;
		document.body.appendChild(link);
		link.click();
		document.body.removeChild(link);
	} else {
		window.open(uri);
	}
}
