function updateCalendar() {
	table = $("<table class='table table-striped'><thead><tr><th scope='col' id='Monthnow' colspan='7' class='text-center h3'>Current Month: </th></tr><tr><th scope='col'>Sun</th><th scope='col'>Mon</th><th scope='col'>Tue</th><th scope='col'>Wed</th><th scope='col'>Thu</th><th scope='col'>Fri</th><th scope='col'>Sat</th></tr></thead><tbody><tr id='line0'></tr><tr id='line1'></tr><tr id='line2'></tr><tr id='line3'></tr><tr id='line4'></tr></tbody></table>");
	$("#main").empty();
	$("#main").append(table);
	$("#Monthnow").text("Current Month: " + (parseInt(currentMonth.month) + 1) + "/" + currentMonth.year);

	let weeks = currentMonth.getWeeks();

	for (let w in weeks) {
		let days = weeks[w].getDates();
		let line = "#line" + w;
		$(line).empty();
		for (let d in days) {
			let dat = days[d].getDate();


			if (currentMonth.month == days[d].getMonth()) {
				new_h6 = $(`<h6 class="dateTag">${dat}</h6>`);
				new_td = $(`<td id="day${dat}"></td>`).append(new_h6);
				$(line).append(new_td);
				new_h6.on("click", addEventPrepare);
			} else {
				let new_td = `<td class="not_current_month"></td>`;
				$(line).append(new_td);
			}


		}
	}

}
