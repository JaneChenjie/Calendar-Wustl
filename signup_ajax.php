<?php
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//Variables can be accessed as such:

require 'database.php';

// Use a prepared statement
if(!preg_match('/^[\w_\-]+$/', $json_obj['username']) || !preg_match('/^[\w_\-]+$/', $json_obj['password'])){
    echo json_encode(array(
		"success" => false,
		"message" => "Invalid Username or Password"
        
	));
	exit;
    
} 
$username = $json_obj['username'];
$pwd = password_hash($json_obj['password'],PASSWORD_DEFAULT);

$stmt2 = $mysqli->prepare("SELECT COUNT(*) FROM users WHERE username=?");
if(!$stmt2){
    echo json_encode(array(
		"success" => false,
		"message" => "Can not create new user!"
	));
    
    exit;
}
$stmt2->bind_param('s', $username);
$stmt2->execute();
$stmt2->bind_result($cnt);
$stmt2->fetch();
$stmt2->close();

if($cnt == 1){
    echo json_encode(array(
		"success" => false,
		"message" => "User already exists"
	));
    exit;
} 
$stmt = $mysqli->prepare("insert into users (username, hashedPassword) values (?, ?)");
if(!$stmt){
    echo json_encode(array(
		"success" => false,
		"message" => "Can not create new user!"
	));
    
    exit;
}
   
$stmt->bind_param('ss', $username, $pwd);
$stmt->execute();
$stmt->close();
echo json_encode(array(
    "success" => true
));
      
    



?>