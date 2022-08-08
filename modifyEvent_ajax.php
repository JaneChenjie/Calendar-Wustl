<?php
header("Content-Type: application/json"); 

$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

$username = $json_obj['username'];
$modifyTitle = $json_obj['modifyTitle'];
$modifyDate = $json_obj['modifyDate'];
$modifyTag = $json_obj['modifyTag'];
$modifyTime = $json_obj['modifyTime'];
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
// CSRF token
if (!hash_equals($_SESSION['token'], $token)) {
	echo json_encode(array(
		"success" => false,
		"message" => "Request forgery detected",
        
	));
    exit;
}
// filter input data
if(!preg_match('/^[\w_\-\s]+$/', $json_obj['modifyTitle']) || 
!preg_match('/^\d{4}-\d{2}-\d{2}$/', $json_obj['modifyDate'])||
!preg_match('/^\d{2}:\d{2}(:\d{2})*$/', $json_obj['modifyTime'])){

    echo json_encode(array(
		"success" => false,
		"message" => "Invalid input date",
        
        
	));
	exit;
    
} 
// update event in datebase
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


$stmt = $mysqli->prepare("UPDATE events SET title=?, eventDate=?, eventTime=?, tag=? WHERE eventId=? AND userId=?");
if(!$stmt){
    echo json_encode(array(
		"success" => false,
		"message" => "Error occur"
	));
    
    exit;
}
$stmt->bind_param('ssssii', $modifyTitle, $modifyDate, $modifyTime, $modifyTag, $eventId, $userId);
$stmt->execute();
$stmt->close();
echo json_encode(array(
    "success" => true
));
?>