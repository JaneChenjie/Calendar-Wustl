// ajax.js

function signupAjax(event) {
    const username = document.getElementById("username-signup").value; // Get the username from the form
    const password = document.getElementById("password-signup").value; // Get the password from the form
    document.getElementById("password-login").value = "";
    document.getElementById("username-login").value = "";

    // Make a URL-encoded string for passing POST data:
    const data = { 'username': username, 'password': password };
  

    fetch("signup_ajax.php", {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'content-type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            data.success ? alert("You've been signed up!"): alert(`You failed to sign up ${data.message}`);
            
        })
        .catch(err => alert(err.message));
}

document.getElementById("signup_btn").addEventListener("click", signupAjax, false); // Bind the AJAX call to button click