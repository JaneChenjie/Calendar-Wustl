<?php
header("Content-Type: application/json"); 

$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

$username = $json_obj['username'];

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

require 'database.php';
// check if this event belogs to the current logged in user
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
$stmt = $mysqli->prepare("SELECT username, title, eventDate, eventTime 
                            FROM users 
                            JOIN shares ON share_by_userId=userId 
                            JOIN events ON share_eventId=eventId 
                            WHERE share_with_userId=?");


$stmt->bind_param('i', $userId);
$stmt->execute();
// Bind the results
$result = $stmt->get_result();

$resultArray = [];
// escapse ouput
while($row = $result->fetch_assoc()){
	foreach($row as $key => $value) {
		$row[$key] = htmlentities($value);
	  }
    array_push($resultArray, $row);
}
echo json_encode(array(
	"success" => true,
	"message" => $resultArray
));

?>