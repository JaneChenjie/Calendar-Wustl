document.getElementById("last_month_btn").addEventListener("click", function(event){
    currentMonth = currentMonth.prevMonth(); 
    updateCalendar(); 
   
    showEventsForTheUser();
    alert("The new month is "+(parseInt(currentMonth.month)+1)+" "+currentMonth.year);}, false);