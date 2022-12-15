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

$gender = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["gender"])){
        echo '<script>alert("Gender is required.")</script>';
        $flag = false;
    } else{
        $gender = test_input($_POST["gender"]);
    }

    if($flag){
        $s = "SELECT gender FROM myuser WHERE no = '$id'";
        $result = mysqli_query($conn, $s);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $sql = "UPDATE myuser SET gender = '$gender' WHERE no = '$id'";
                if ($conn->query($sql) === TRUE) {
                    echo '<script>alert("Gender update successfully.")</script>';
                } else {
                    echo '<script>alert("Error updating gender.")</script>';
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