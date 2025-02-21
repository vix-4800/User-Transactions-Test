const form = document.getElementById("form");
const data_section = document.getElementById("data_section");
const table_data = document.getElementById("data");

form.onsubmit = function (e) {
	e.preventDefault();

	const xhr = new XMLHttpRequest();
	xhr.open(form.method, form.action + "?user=" + form.elements["user"].value);

	xhr.onload = function () {
		if (xhr.status === 200) {
			data_section.style.display = "block";

			table_data.innerHTML = "";
			const data = JSON.parse(xhr.response);
			for (let i = 0; i < data.length; i++) {
				const row = table_data.insertRow();
				const cell1 = row.insertCell(0);
				const cell2 = row.insertCell(1);
				cell1.innerHTML = data[i].month;
				cell2.innerHTML = data[i].amount;
			}
		}
	};
	xhr.send();
};
