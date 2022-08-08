const showEventsForTheUser = function() {
	const username = window.sessionStorage.getItem('username');
	if (username == null) return; //user must log in first!
	const data = {"username" : username, "curMonth" : currentMonth.month, "curYear": currentMonth.year};
	
    $.ajax({
        url: "showEventForUser_ajax.php", 
        method: "POST", 
        contentType: "application/json", 
        data: JSON.stringify(data),
        success: function(result){
          if (result.success) {
            for (let event of result.message) {
              const {day, title, eventId, tag} = event;
              newEventP = $(`<p id="event${eventId}" class="category ${tag}">${title}</p>`);
              $(`#day${day}`).append(newEventP);
              newEventP.click(showEventDetailAjax);
            }

          } else {
            alert(result.message);
          }
          
        
      }});
}