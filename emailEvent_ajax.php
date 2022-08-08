<?php

header("Content-Type: application/json"); 

$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

$username = $json_obj['username'];
$emailTo = $json_obj['emailTo'];
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


require 'database.php';
// check if this event belogs to the current logged in user
$stmt = $mysqli->prepare("SELECT COUNT(*), users.userId, title, eventTime, eventDate FROM users JOIN events ON users.userId = events.userId WHERE username=? AND eventId=?");
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
$stmt->bind_result($num, $userId, $title, $eventTime, $eventDate);
$stmt->fetch();
$stmt->close();
if ($num != 1) {
    echo json_encode(array(
		"success" => false,
		"message" => "This Event does not belong to the logged in user!!"
	));
    
    exit;
}


require_once('vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
$key = $_ENV['API_KEY'];

require 'vendor/autoload.php';
$email = new \SendGrid\Mail\Mail(); 
$email->setFrom("c.xiong@wustl.edu", "Calendar");
$email->setSubject("Event reminder");
$email->addTo($emailTo, "Calendar user");
$email->addContent("text/plain", "Event Detail");
$email->addContent(
    "text/html", "<br><strong>Event Title:</strong><br>".$title."<br><strong>Event Time:</strong><br>".$eventTime
    ."<br><strong>Event Date:</strong><br>".$eventDate
);
$sendgrid = new \SendGrid($key);

try {
    $response = $sendgrid->send($email);
    
   
    echo json_encode(array(
		"success" => true,
		"message" => htmlentities($response->statusCode())
	));
} catch (Exception $e) {
	echo json_encode(array(
		"success" => false,
		"message" => htmlentities($e->getMessage())
	));
   
}


?>