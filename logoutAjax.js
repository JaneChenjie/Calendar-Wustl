

function logoutAjax(event) {
 

    // Make a URL-encoded string for passing POST data:
    
  

    fetch("logout_ajax.php", {
            method: 'GET',
        
            headers: { 'content-type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            data.success ? alert("You've been log out!"): alert(`You failed to log out!`);
           
            if (data.success) {
                
                window.sessionStorage.removeItem("username");
                window.sessionStorage.removeItem("token");
              
           
                $("#toggleLogOut").hide();
                $("#toggleLogIn").show();
                $("#toggleSignUp").show();
                $("#addNewEventLink").hide();
                $("#viewEventShareByOther").hide();
                $("#differentCategoryEvent").hide();
                updateCalendar();
                

            }
           
        })
        .catch(err => alert(err.message));
}

document.getElementById("toggleLogOut").addEventListener("click", logoutAjax, false); // Bind the AJAX call to button click