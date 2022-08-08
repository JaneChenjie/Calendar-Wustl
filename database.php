<?php
// Content of database.php

$mysqli = new mysqli('localhost', 'module5', '123123', 'Calendar');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>