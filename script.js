const form = document.getElementById("form");
const data_section = document.getElementById("data_section");
const table_data = document.getElementById("data");
const submit_btn = document.getElementById("submit");

form.onsubmit = function (e) {
	e.preventDefault();

	const xhr = new XMLHttpRequest();
	xhr.open(form.method, form.action + "?user=" + form.elements["user"].value);

	xhr.onload = function () {
		if (xhr.status === 200) {
			data_section.style.display = "block";

			table_data.innerHTML = "";
			const data = JSON.parse(xhr.response);
			for (let key in data) {
				const row = table_data.insertRow();

				const cell1 = row.insertCell(0);
				cell1.innerHTML = key;

				const cell2 = row.insertCell(1);
				cell2.innerHTML = data[key];
			}

			submit_btn.style.display = "none";
		}
	};
	xhr.send();
};

const user_select = document.getElementById("user");
const user_name_span = document.getElementById("user_name");
user_select.onchange = function () {
	user_name_span.innerHTML =
		user_select.options[user_select.selectedIndex].text;

	data_section.style.display = "none";
	submit_btn.style.display = "block";
};

user_select.onchange();
