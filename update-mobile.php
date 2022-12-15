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

$mobile = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["pnum"])){
        echo '<script>alert("Mobile is required.")</script>';
        $flag = false;
    } else{
        $mobile = test_input($_POST["pnum"]);

        if(!preg_match("/^(\+?6?01)[02-46-9][-][0-9]{7}$|^(\+?6?01)[1][-][0-9]{8}$/", $mobile)){
            echo '<script>alert("Mobile number is invalid, it must match the requested format.")</script>';
            $flag = false;
        }
    }

    if($flag){
        $s = "SELECT mobile FROM myuser WHERE no = '$id'";
        $result = mysqli_query($conn, $s);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $sql = "UPDATE myuser SET mobile = '$mobile' WHERE no = '$id'";
                if ($conn->query($sql) === TRUE) {
                    echo '<script>alert("Mobile updated successfully.")</script>';
                } else {
                    echo '<script>alert("Error updating mobile.")</script>';
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