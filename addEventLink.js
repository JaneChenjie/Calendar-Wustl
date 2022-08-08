$("#addNewEventLink").click(function() {
    if (window.sessionStorage.getItem('username') != null) {
        $("#newEventTitle").val("");
        $("#newEventDate").val("");
        $("#newEventTime").val("");
        addNewEventModal.show();


   } else {
       
        addNewEventModal.hide();
      
   }
});