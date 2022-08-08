const showEventDetailAjax = function(e) {

    
  const eventIdAttr = e.target.id;
  const regexEventId = /^event([\d]+)$/;
  const username = window.sessionStorage.getItem('username');
  match = regexEventId.exec(eventIdAttr);
  if(!match || !username) {
		alert("Can not show detail!");
    return;
	}

  const eventId = match[1];
  const data = {"username": username, "eventId": eventId};
  $.ajax({
    url: "showEventDetail_ajax.php", 
    method: "POST", 
    contentType: "application/json", 
    data: JSON.stringify(data),
    success: function(result){
      if (result.success) {
        const {title, eventDate, eventTime, eventTag, eventId} = result.message;
        $("#eventTitleDetail").val(title);
        $("#eventDateDetail").val(eventDate);
        $("#eventTimeDetail").val(eventTime);
        $("#eventTagDetail").val(eventTag);
        $("#eventId").val(eventId);
        $("#shareTitle").text(title);
        $("#shareDate").text(eventDate);
        $("#shareTime").text(eventTime);
        $("#emailTitle").text(title);
        $("#emailDate").text(eventDate);
        $("#emailTime").text(eventTime);
        showEventDetailModal.show();


      } else {
        alert(result.message);

      }
      
   
  }});
  
};