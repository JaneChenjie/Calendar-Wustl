<?php
header("Content-Type: application/json"); 

$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

$username = $json_obj['username'];

$eventId = (int)$json_obj['eventId'];
ini_set("session.cookie_httponly", 1);
session_start();
if ($username != $_SESSION['username']) {
    echo json_encode(array(
		"success" => false,
		"message" => "Can not show event",
        
	));
    exit;
}

require 'database.php';

$stmt = $mysqli->prepare("SELECT title, eventDate, eventTime, tag 
                            FROM events JOIN users 
                            ON users.userId = events.userId 
                            WHERE eventId=? AND username=?");
if(!$stmt){
    echo json_encode(array(
		"success" => false,
		"message" => "Error occur!"
	));
    
    exit;
}
$stmt->bind_param('is', $eventId, $username);

$stmt->execute();

// Bind the results
$stmt->bind_result($title, $eventDate, $eventTime, $eventTag);
$stmt->fetch(); 
$stmt->close();
// escape output
echo json_encode(array(
    "success" => true,
    "message" => array("title" => htmlentities($title), 
                    "eventDate" => htmlentities($eventDate), 
                    "eventTime" => htmlentities($eventTime),
                    "eventTag" => htmlentities($eventTag),
                    "eventId" => htmlentities($eventId)
    
)));


?>