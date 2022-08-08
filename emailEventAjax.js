
const emailEventAjax = function () {
    if (window.sessionStorage.getItem('username') == null || window.sessionStorage.getItem('token') == null) {
        alert("You should log in first!");
        return;
    }
   
    const username = window.sessionStorage.getItem('username');
    const token = window.sessionStorage.getItem('token');
    const eventId = $("#eventId").val();
   
    if ($("#emailTo").val() == "") {
        alert("username to share can not be empty");
        return;
    }
    // filter input
    const regexEmail = /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
    const emailAddress = $("#emailTo").val();
    if (!regexEmail.test(emailAddress)) {
        alert("Invalid email address");
    } 
  
    
    
    const data = {
        "username": username,
        "eventId": eventId,
        "token": token,
        "emailTo": emailAddress
    };
    $.ajax({
        url: "emailEvent_ajax.php",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify(data),
        success: function (result) {
            if (result.success) {
                alert(`You email a event successfully`);

            } else {
                alert(result.message);

            }
            

        



        }
    });

  

};
$("#emailEvent-btn").click(emailEventAjax);