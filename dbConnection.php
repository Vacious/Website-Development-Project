<?php

global $conn;

$host = "localhost";
$user = "user";
$pass = "dummy123";
$db = "dbyale";

$conn = new mysqli($host, $user, $pass, $db);
if($conn->connect_error){
	die("connection failed: ". $conn->connect_error);
}	

?>