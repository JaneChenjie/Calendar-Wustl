const addEventPrepare = function (e) {
    let day = e.target.textContent;
    let month = currentMonth.month + 1;
    let year = currentMonth.year;

    if (month < 10)
        month = "0" + month;
    if (day < 10)
        day = "0" + day;
    $("#newEventTitle").val("");
    $("#newEventTime").val("");
    if (window.sessionStorage.getItem('username') != null) {
        $("#newEventDate").val(`${year}-${month}-${day}`);
        addNewEventModal.show();


    } else {
        alert("Before adding events, you should login first!");
        addNewEventModal.hide();

    }

}