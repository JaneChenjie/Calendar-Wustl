<?php
header("Content-Type: application/json"); 

$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

$username = $json_obj['username'];
$newTitle = $json_obj['newTitle'];
$newDate = $json_obj['newDate'];
$newTime = $json_obj['newTime'];
$newTag = $json_obj['newTag'];
$token = $json_obj['token'];
// session cookie to be HTTP-Only
ini_set("session.cookie_httponly", 1);
session_start();
// CSRF token
if (!hash_equals($_SESSION['token'], $token)) {
	echo json_encode(array(
		"success" => false,
		"message" => "Request forgery detected",
        
	));
    exit;
}

// check whether user log in or not, and check the identity of current log in user
if (!isset($_SESSION['username']) || $username != $_SESSION['username']) {
    echo json_encode(array(
		"success" => false,
		"message" => "Invalid user",
        
	));
    exit;
}
// filter input data
if(!preg_match('/^[\w_\-\s]+$/', $json_obj['newTitle']) || 
!preg_match('/^\d{4}-\d{2}-\d{2}$/', $json_obj['newDate'])||
!preg_match('/^\d{2}:\d{2}$/', $json_obj['newTime'])){
    echo json_encode(array(
		"success" => false,
		"message" => "Invalid input date",
        
        
	));
	exit;
    
} 
$newTime .=":00";

require 'database.php';
$stmt = $mysqli->prepare("SELECT userId FROM users WHERE username=?");
if(!$stmt){
    echo json_encode(array(
		"success" => false,
		"message" => "Error occur!"
	));
    
    exit;
}
$stmt->bind_param('s', $username);

$stmt->execute();

// Bind the results
$stmt->bind_result($userId);
$stmt->fetch();
$stmt->close();

$stmt = $mysqli->prepare("insert into events (title, eventDate, eventTime, userId, tag) values (?, ?, ?, ?, ?)");
if(!$stmt){
    echo json_encode(array(
		"success" => false,
		"message" => "Error occur"
	));
    
    exit;
}
$stmt->bind_param('sssis', $newTitle, $newDate, $newTime, $userId, $newTag);
$stmt->execute();
$stmt->close();
echo json_encode(array(
    "success" => true
));




?>