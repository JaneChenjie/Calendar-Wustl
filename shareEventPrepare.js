const shareEventPrepare = function () {
    if (window.sessionStorage.getItem('username') != null) {
        $("#shareWith").val("");

        shareEventModal.show();


    } else {
        alert("Before sharing events, you should login first!");
        shareEventModal.hide();

    }

};
const backToShowEvent = function () {
    if (window.sessionStorage.getItem('username') != null) {

        showEventDetailModal.show();


    } else {
        alert("Before sharing events, you should login first!");
        showEventDetailModal.hide();

    }

};
$("#toShareEvent-btn").click(shareEventPrepare);
$("#backToShowEvent-btn").click(backToShowEvent);