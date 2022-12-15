<?php
//increase security
$host="localhost";
$user="adminproj";
$pass="dummy123";
$db="dbyale";

global $conn;

//connect server
$conn= mysqli_connect($host,$user,$pass);
if(!$conn){
    echo "Could not connect to server";
    trigger_error(mysqli_error(), E_USER_ERROR);
}

//select database
$conn2= mysqli_select_db($conn, $db);
if (!$conn2){
    echo "Could not select database<br />";
    trigger_error(mysqli_error(), E_USER_ERROR);
}

?>