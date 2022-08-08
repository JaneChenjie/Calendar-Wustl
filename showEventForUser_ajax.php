<?php
header("Content-Type: application/json"); 

$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

$username = $json_obj['username'];

$curMonth = (int)$json_obj['curMonth'] + 1;
$curYear = (int)$json_obj['curYear'];

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

$stmt = $mysqli->prepare("SELECT DAY(eventDate) AS day, title, eventId, tag FROM events WHERE userId=? AND MONTH(eventDate)=? AND YEAR(eventDate)=?");
if(!$stmt){
    echo json_encode(array(
		"success" => false,
		"message" => "Error occur!!"
	));
    
    exit;
}
$stmt->bind_param('iss', $userId, $curMonth, $curYear);

$stmt->execute();

// Bind the results
$result = $stmt->get_result();

$resultArray = [];
// escape output
while($row = $result->fetch_assoc()){
	foreach($row as $key => $value) {
		// escape ouput
		$row[$key] = htmlentities($value);
	  }
    array_push($resultArray, $row);
}


$stmt->close();
echo json_encode(array(
	"success" => true,
	"message" => $resultArray
));


?>