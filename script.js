const form = document.getElementById("form");
const data_table = document.getElementById("data");

form.onsubmit = function (e) {
	e.preventDefault();

	const xhr = new XMLHttpRequest();
	xhr.open(form.method, form.action + "?user=" + form.elements["user"].value);

	xhr.onload = function () {
		if (xhr.status === 200) {
			data_table.style.display = "block";
		}
	};
	xhr.send();
};
