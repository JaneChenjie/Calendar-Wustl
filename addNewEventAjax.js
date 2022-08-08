const addNewEventAjax = function (e) {
    e.preventDefault();
    if (window.sessionStorage.getItem('username') == null || window.sessionStorage.getItem('token') == null) {
        alert("You should log in first!");
        return;
    }
    const newTitle = $("#newEventTitle").val();
    const newTime = $("#newEventTime").val();
    const newDate = $("#newEventDate").val();
    const newTag = $("#eventTags option:selected" ).text();
    const username = window.sessionStorage.getItem('username');
    const token = window.sessionStorage.getItem('token');
    // filter input
    if (newTitle == "" || newTime == "" || newDate == "") {
        alert("Input field can not be empty!");
        return;
    }
    if (!(newTag == "home" || newTag == "work" || newTag == "study")) {
        alert("Tag invalid!");
        return;
    }
    
    const titleReg = /^[\w_\-\s]+$/;
    const dateReg = /^\d{4}-\d{2}-\d{2}$/;
    const timeReg = /^\d{2}:\d{2}$/;
    if (!titleReg.test(newTitle) || !dateReg.test(newDate) || !timeReg.test(newTime)) {
        alert("invalid input");
        return;
    }



    const data = {"username" : username, "newTitle" : newTitle, "newTime" : newTime, "newDate" : newDate, "newTag": newTag, "token": token};
    $.ajax({
        url: "addNewEvent_ajax.php", 
        method: "POST", 
        contentType: "application/json", 
        data: JSON.stringify(data),
        success: function(result){
            
            result.success ? alert("You add a event successfully") : alert(result.message);
            updateCalendar();
            showEventsForTheUser();
            
        
      }});

    


};
$("#addNewEvent-btn").click(addNewEventAjax);