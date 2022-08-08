const shareEventAjax = function () {
    if (window.sessionStorage.getItem('username') == null || window.sessionStorage.getItem('token') == null) {
        alert("You should log in first!");
        return;
    }
    const regexEventId = /^[\w_\-]+$/;
    const username = window.sessionStorage.getItem('username');
    const token = window.sessionStorage.getItem('token');
    const eventId = $("#eventId").val();
    if ($("#shareWith").val() == "") {
        alert("username to share can not be empty");
        return;
    }
    const shareWithUsernames = $("#shareWith").val().trim().split(",");
    const filterName = [];
  // filter input
    for (let name of shareWithUsernames) {
        name = name.trim();
        
        match = regexEventId.exec(name);
        
        if (match && name != username) {
            filterName.push(match[0]);
        }
    }
    if (filterName.length == 0) {
        alert("No username is valid");
        return;
    }
    
    const data = {
        "username": username,
        "eventId": eventId,
        "token": token,
        "shareWith": filterName
    };
    $.ajax({
        url: "shareEvent_ajax.php",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify(data),
        success: function (result) {
            

            result.success ? alert(`You share a event successfully with ${result.shareWith}`) : alert(result.message);



        }
    });

  

};
$("#shareEvent-btn").click(shareEventAjax);