<?php
header("Content-Type: application/json"); 

$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

$username = $json_obj['username'];
$shareWith = $json_obj['shareWith'];
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
// filter input
$filterShareWith = [];
foreach ($shareWith as $name) {
    if (preg_match('/^[\w_\-]+$/', $name)) {
        array_push($filterShareWith, $name);
    }
}

require 'database.php';
// check if this event belogs to the current logged in user
$stmt = $mysqli->prepare("SELECT COUNT(*), users.userId FROM users JOIN events ON users.userId = events.userId WHERE username=? AND eventId=?");
if(!$stmt){
    echo json_encode(array(
		"success" => false,
		"message" => "Error occur!"
	));
    
    exit;
}
$stmt->bind_param('si', $username, $eventId);

$stmt->execute();

// Bind the results
$stmt->bind_result($num, $userId);
$stmt->fetch();
$stmt->close();
if ($num != 1) {
    echo json_encode(array(
		"success" => false,
		"message" => "This Event does not belong to the logged in user!!"
	));
    
    exit;
}
// find the id of user you want to share the event with
$shareWithIds = [];
$stmt = $mysqli->prepare("SELECT userId FROM users WHERE username=?");
if(!$stmt){
    echo json_encode(array(
		"success" => false,
		"message" => "Error occur!"
	));
    
    exit;
}
foreach ($filterShareWith as $filterName) {
    $stmt->bind_param('s', $filterName);

    $stmt->execute();
    
    // Bind the results
    $stmt->bind_result($userIdToShareWith);
    $stmt->fetch();
    
    array_push($shareWithIds, $userIdToShareWith);

}
$stmt->close();

// insert data into "shares" table
$stmt = $mysqli->prepare("INSERT INTO shares (share_by_userId, share_eventId, share_with_userId) VALUES (?, ?, ?)");
if(!$stmt){
    echo json_encode(array(
		"success" => false,
		"message" => "Error occur!"
	));
    
    exit;
}
foreach ($shareWithIds as $shareWithId) {
    $stmt->bind_param('iii', $userId, $eventId, $shareWithId);

    $stmt->execute();
    
    // Bind the results
   
    
   
  

}

$stmt->close();
$resultArray = [];
// escapse ouput
foreach ($filterShareWith as $filteredName) {
    array_push($resultArray, htmlentities($filteredName));
}
echo json_encode(array(
    "success" => true, 
    "shareWith" => $resultArray
));



?>