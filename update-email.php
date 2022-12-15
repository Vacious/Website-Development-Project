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

$email = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["email"])){
        echo '<script>alert("Email is required.")</script>';
        $flag = false;
    } else{
        $email = test_input($_POST["email"]);

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo '<script>alert("Email is invalid.")</script>';
            $flag = false;
        }
    }

    if($flag){
        $s = "SELECT email FROM myuser WHERE no = '$id'";
        $result = mysqli_query($conn, $s);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $sql = "UPDATE myuser SET email = '$email' WHERE no = '$id'";
                if ($conn->query($sql) === TRUE) {
                    echo '<script>alert("Email updated successfully.")</script>';
                } else {
                    echo '<script>alert("Error updating email.")</script>';
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