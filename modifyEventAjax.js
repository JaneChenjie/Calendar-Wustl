const modifyEvent = function (e) {
    e.preventDefault();
    if (window.sessionStorage.getItem('username') == null || window.sessionStorage.getItem('token') == null) {
        alert("You should log in first!");
        return;
    }
    const modifyTitle = $("#eventTitleDetail").val();
    const modifyTime = $("#eventTimeDetail").val();
    const modifyDate = $("#eventDateDetail").val();
    const eventId = $("#eventId").val();
    const modifyTag = $("#eventTagDetail option:selected" ).text();
    const username = window.sessionStorage.getItem('username');
    const token = window.sessionStorage.getItem('token');
    if (modifyTitle == "" || modifyTime == "" || modifyDate == "" || modifyTag == "") {
        alert("Input field can not be empty!");
        return;
    }
    // filter input
    const titleReg = /^[\w_\-\s]+$/;
    const dateReg = /^\d{4}-\d{2}-\d{2}$/;
    const timeReg = /^\d{2}:\d{2}(:\d{2})?$/;
    if (!titleReg.test(modifyTitle) || !dateReg.test(modifyDate) || !timeReg.test(modifyTime)) {
        alert("invalid input");
        return;
    }
    const data = {
        "username": username,
        "modifyTitle": modifyTitle,
        "modifyTime": modifyTime,
        "modifyDate": modifyDate,
        "modifyTag": modifyTag,
        "eventId": eventId,
        "token": token
    };
    $.ajax({
        url: "modifyEvent_ajax.php",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify(data),
        success: function (result) {
            updateCalendar();
            showEventsForTheUser();

            result.success ? alert("You modify a event successfully") : alert(result.message);



        }
    });

};
$("#saveChangeEvent-btn").click(modifyEvent);