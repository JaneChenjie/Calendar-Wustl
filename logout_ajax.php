<?php
header("Content-Type: application/json"); 
// session cookie to be HTTP-Only
ini_set("session.cookie_httponly", 1);
session_start();
session_destroy();
echo json_encode(array(
    "success" => true,
    "message" => "You have secessfully log out!"
));
exit;

?>