const emailEventPrepare = function () {
    if (window.sessionStorage.getItem('username') != null) {
        $("#emailTo").val("");

        emailEventModal.show();


    } else {
        alert("Before emailing events, you should login first!");
        emailEventModal.hide();

    }

};

$("#toEmailEvent-btn").click(emailEventPrepare);

$("#backToShowEventFromEmail-btn").click(backToShowEvent);