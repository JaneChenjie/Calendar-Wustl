const curDate = new Date();

const addNewEventModal = new bootstrap.Modal(document.getElementById('addNewEvent'));
const showEventDetailModal = new bootstrap.Modal(document.getElementById('showEventDetail'));
const shareEventModal = new bootstrap.Modal(document.getElementById('shareThisEvent'));
const emailEventModal = new bootstrap.Modal(document.getElementById('emailThisEvent'));
const viewShareEventOffCanvas = new bootstrap.Offcanvas(document.getElementById("sharedEvent-widget"));

let currentMonth = new Month(curDate.getFullYear(), curDate.getMonth()); 


$(document).ready(function(){
    if (window.sessionStorage.getItem('username') != null) {
        // user is logged in
        $("#toggleLogIn").hide();
        $("#toggleSignUp").hide();
        $("#toggleLogOut").show();
        $("#addNewEventLink").show();
        $("#viewEventShareByOther").show();
        $("#differentCategoryEvent").show();

        updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
        showEventsForTheUser();
       
   
    } else {
        // user is not logged in
        $("#toggleLogOut").hide();
        $("#addNewEventLink").hide();
        $("#toggleLogIn").show();
        $("#toggleSignUp").show();
        $("#viewEventShareByOther").hide();
        $("#differentCategoryEvent").hide();

        updateCalendar();
       
        
        
    
    }
  
    
  });