<?php
header("Content-Type: application/json"); 

$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

$username = $json_obj['username'];
// filter input data
$eventId = (int) $json_obj['eventId'];
$token = $json_obj['token'];

// session cookie to be HTTP-Only
ini_set("session.cookie_httponly", 1);
session_start();
// check whether user log in or not, and check the identity of current log in user
if (!isset($_SESSION['username']) || $username != $_SESSION['username']) {
    echo json_encode(array(
		"success" => false,
		"message" => "Invalid user",
        
	));
    exit;
}
//CSRF token
if (!hash_equals($_SESSION['token'], $token)) {
	echo json_encode(array(
		"success" => false,
		"message" => "Request forgery detected",
        
	));
    exit;
}
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


$stmt = $mysqli->prepare("DELETE FROM events WHERE eventId=? AND userId=?");
if(!$stmt){
    echo json_encode(array(
		"success" => false,
		"message" => "Error occur"
	));
    
    exit;
}
$stmt->bind_param('ii', $eventId, $userId);
$stmt->execute();
$stmt->close();
echo json_encode(array(
    "success" => true
));



?>