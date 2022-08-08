// ajax.js

function loginAjax(event) {
    const username = document.getElementById("username-login").value; // Get the username from the form
    const password = document.getElementById("password-login").value; // Get the password from the form
    document.getElementById("password-login").value = "";
    document.getElementById("username-login").value = "";

    // Make a URL-encoded string for passing POST data:
    const data = { 'username': username, 'password': password };

    fetch("login_ajax.php", {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'content-type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            data.success ? alert("You've been logged in!"): alert(`You were not logged in ${data.message}`);
            if (data.success) {
                
                window.sessionStorage.setItem("username", data.username);
                window.sessionStorage.setItem("token", data.token);
                
               
               
                $("#toggleLogIn").hide();
                $("#toggleSignUp").hide();
                $("#toggleLogOut").show(); 
                $("#addNewEventLink").show(); 
                $("#viewEventShareByOther").show();
                $("#differentCategoryEvent").show();
                showEventsForTheUser();
            }
            
       
             
            
    })
        .catch(err => alert(err.message));
}

document.getElementById("login_btn").addEventListener("click", loginAjax, false); // Bind the AJAX call to button click