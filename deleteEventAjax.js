const deleteEventAjax = function (e) {
    e.preventDefault();
    if (window.sessionStorage.getItem('username') == null || window.sessionStorage.getItem('token') == null) {
        alert("You should log in first!");
        return;
    }
    const eventId = $("#eventId").val();
    const username = window.sessionStorage.getItem('username');
    const token = window.sessionStorage.getItem('token');
    const data = {
        "username": username,
        "eventId": eventId,
        "token": token
    };
    $.ajax({
        url: "deleteEvent_ajax.php",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify(data),
        success: function (result) {
            

            result.success ? alert("You modify a event successfully") : alert(result.message);
            updateCalendar();
            showEventsForTheUser();



        }
    });

};
$("#deleteEvent-btn").click(deleteEventAjax);