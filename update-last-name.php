<?php

ob_start();

global $conn;

include "dbConnection.php";	

if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION["id"])){
    header("Location: login.php");
}

$id = $_SESSION["id"];

$flag = true;

$lastName = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["lname"])){
        echo '<script>alert("Last name is required.")</script>';
        $flag = false;
    } else{
        $lastName = test_input($_POST["lname"]);

        if(!preg_match("/^([A-Z][a-z]+([ ]?[a-z]?['-]?[A-Z][a-z]+)*)$/", $lastName)){
            echo '<script>alert("First character uppercase and follow by lowercase.")</script>';
            $flag = false;
        }
    }

    if($flag){
        $s = "SELECT last_name FROM myuser WHERE no = '$id'";
        $result = mysqli_query($conn, $s);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $sql = "UPDATE myuser SET last_name = '$lastName' WHERE no = '$id'";
                if ($conn->query($sql) === TRUE) {
                    echo '<script>alert("Last name updated successfully.")</script>';
                } else {
                    echo '<script>alert("Error updating last name.")</script>';
                }
            }
        }
    }
    echo '<script>window.location.href="profile.php"</script>';
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

ob_end_flush();
?>