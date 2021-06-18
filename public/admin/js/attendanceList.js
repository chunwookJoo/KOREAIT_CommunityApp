const URL_ATTEND_LIST = '/article/user/attend/list?sosok_code=';
const URL_FBKEY_LIST = '/article/user/get/firebase/group';

var jsonRequestAttend = new XMLHttpRequest();
var jsonRequestFBKey = new XMLHttpRequest();

jsonRequestAttend.responseType = 'json';
jsonRequestFBKey.responseType = 'json';

var node_college = document.getElementById('college');
var node_depart = document.getElementById('depart');
var node_year = document.getElementById('year');

jsonRequestFBKey.onload = () => {
	var table = document.getElementById('user_table');
	var user_rows = table.getElementsByClassName('user-row');

	jsonRequestFBKey.response.forEach(element => {
		for (let user_row of user_rows) {
			if (user_row.getElementsByClassName('user-id').item(0).innerHTML == element.user_id)
			{
				user_row.getElementsByClassName('app-installed').item(0).innerHTML = 'Y';
				user_row.getElementsByClassName('keys').item(0).checked = true;
				user_row.getElementsByClassName('keys').item(0).disabled = false;
				user_row.getElementsByClassName('keys').item(0).value = element.firebase_key;
				user_row.getElementsByClassName('keys').item(0).onclick = 'onCheckedClicked();';
			}
		}
		element.firebase_key;
	});

	document.querySelector('#select_all').onclick();
	$('.tablesorter').trigger("update");
};

jsonRequestAttend.onload = () => {
	var table = document.getElementById('user_table');

	table.innerHTML = "";

	jsonRequestAttend.response.forEach(element => {
		if (node_year.value == "" || element.curGradeYear == node_year.value)
		{
			var user_row = document.createElement('tr');
			user_row.classList.add('user-row');
			user_row.id = `user_${element.hakbun}`;

			var user_class = document.createElement('td');
			user_class.classList.add('user-class');
			user_class.innerHTML = element.className;
			user_row.appendChild(user_class);

			var user_id = document.createElement('td');
			user_id.classList.add('user-id');
			user_id.innerHTML = element.hakbun;
			user_row.appendChild(user_id);

			var user_name = document.createElement('td');
			user_name.classList.add('user-name');
			user_name.innerHTML = element.studentName;
			user_row.appendChild(user_name);

			var user_status = document.createElement('td');
			user_status.classList.add('user-status');
			user_status.innerHTML = element.status;
			user_row.appendChild(user_status);

			var app_installed = document.createElement('td');
			app_installed.classList.add('app-installed');
			app_installed.innerHTML = 'N';
			user_row.appendChild(app_installed);

			var send_to = document.createElement('td');
			send_to.classList.add('send-to');
			var checkbox = document.createElement('input');
			checkbox.classList.add('keys');
			checkbox.name = `notification[${element.hakbun}]`
			checkbox.id = `notification[${element.hakbun}]`
			checkbox.type = 'checkbox';
			checkbox.checked = false;
			checkbox.disabled = true;
			send_to.appendChild(checkbox);
			user_row.appendChild(send_to);
			table.appendChild(user_row);
		}
	});

	var fbData = {
		college: node_college.value,
		depart: node_depart.value,
		year: node_year.value,
	};
	jsonRequestFBKey.open('POST', URL_FBKEY_LIST);
	jsonRequestFBKey.setRequestHeader('Content-Type', 'application/json');
	jsonRequestFBKey.send(JSON.stringify(fbData));
};

var setJsonReqAttend = () => {
	if (node_college.value == "")
	{
		jsonRequestAttend.open('GET', URL_ATTEND_LIST + 'ALL');
		jsonRequestAttend.send();
	}
	else if (node_depart.value == "")
	{
		var key = Object.keys(college_map).find(key => college_map[key] === node_college.value);
		jsonRequestAttend.open('GET', URL_ATTEND_LIST + key);
		jsonRequestAttend.send();
	}
	else
	{
		var key = Object.keys(depart_map).find(key => depart_map[key] === node_depart.value);
		jsonRequestAttend.open('GET', URL_ATTEND_LIST + key);
		jsonRequestAttend.send();
	}
};

document.querySelector('#college').onchange = () => {
	var colleges = document.getElementsByClassName('board-college');
	var departs = document.getElementsByClassName('board-depart');
	var depart = document.getElementById('depart');
	var college = null;

	for (let element of colleges)
		if (element.value == document.getElementById('college').value)
			college = element;

	for (let element of departs)
		element.hidden = true;

	if (college != null)
	{
		var departs_selected = document.getElementsByClassName(college.id);

		for (let element of departs_selected)
			element.hidden = false;
	}
};

document.querySelector('#search_button').onclick = () => {
	setJsonReqAttend();
};

document.querySelector('#remove_selected').onclick = () => {
	var keys = document.getElementsByClassName('keys');

	for (let element of keys)
	{
		if (element.checked == true)
		{
			element.checked = false;
		}
	}

	document.querySelector("#counts").innerHTML = "";
};

document.querySelector('#select_all').onclick = () => {
	var keys = document.getElementsByClassName('keys');
	var counts = 0;

	for (let element of keys)
	{
		if (!element.disabled)
		{
			element.checked = true;
			counts++;
		}
	}

	document.querySelector("#counts").innerHTML = "총 " + counts + "명 선택됨";
};

document.querySelector('#college').onchange();
document.querySelector('#search_button').onclick();
document.querySelector('#select_all').onclick();
