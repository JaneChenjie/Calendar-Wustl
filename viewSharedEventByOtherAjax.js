const viewSharedEventByOther = function() {
    if (window.sessionStorage.getItem('username') == null || window.sessionStorage.getItem('token') == null) {
        alert("You should log in first!");
        return;
    }
    const username = window.sessionStorage.getItem('username');
    const token = window.sessionStorage.getItem('token');
    const data = {"username" : username, "token": token};
    $.ajax({
        url: "viewSharedEvent_ajax.php", 
        method: "POST", 
        contentType: "application/json", 
        data: JSON.stringify(data),
        success: function(result){
            if (result.success) {
                $("#shareEventContent").empty();
                for (let sharedEvent of result.message) {
                    let {eventDate, eventTime, title, username} = sharedEvent;
                    newSharedEvent = $(`<div class=list-group-item>
                                            <h5 class="mb-1">Event Title</h5>
                                            <p>${title}</p>
                                            <h5 class="mb-1">Event Date</h5>
                                            <p>${eventDate}</p>
                                            <h5 class="mb-1">Event Time</h5>
                                            <p>${eventTime}</p>
                                            <small>Shared by ${username}</small>
                                        </div>`);
                    $("#shareEventContent").append(newSharedEvent);

                }
                viewShareEventOffCanvas.show();

            } else {
                alert(result.message);
            }
            
            
        
      }});

};
$("#viewEventShareByOther").click(viewSharedEventByOther);