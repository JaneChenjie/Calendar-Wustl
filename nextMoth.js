document.getElementById("next_month_btn").addEventListener("click", function(event){
    currentMonth = currentMonth.nextMonth(); 
    updateCalendar(); 
    showEventsForTheUser();
    alert("The new month is "+(parseInt(currentMonth.month)+1)+" "+currentMonth.year);}, false);