<?php

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

$password = $comfirmPassword = $securePass = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["password"])){
        echo '<script>alert("Password is required.")</script>';
        $flag = false;
    } else{
        $password = test_input($_POST["password"]);
        $securePass = password_hash($password, PASSWORD_BCRYPT);

        if(!preg_match("/^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{6,}$/", $password)){
            echo '<script>alert("Password is invalid, must contain one uppercase, one lower case, one special character ( ! @ # $ % ^ & * ), numbers and no space, and at least 6 digits length.")</script>';
            $flag = false;
        }
    }

    if(empty($_POST["password2"])){
        echo '<script>alert("Re-type password is required.")</script>';
        $flag = false;
    } else{
        $comfirmPassword = test_input($_POST["password2"]);

        if($password != $comfirmPassword){
            echo '<script>alert("Passwords do not match.")</script>';
            $flag = false;
        }
    }

    if($flag){
        $s = "SELECT password FROM myuser WHERE no = '$id'";
        $result = mysqli_query($conn, $s);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                if(password_verify($password, $row["password"])){
                    echo '<script>alert("New password cannot be the same as your previous password.")</script>';
                    break;
                }
                $sql = "UPDATE myuser SET password = '$securePass' WHERE no = '$id'";
                if ($conn->query($sql) === TRUE) {
                    echo '<script>alert("Password updated successfully.")</script>';
                } else {
                    echo '<script>alert("Error updating password.")</script>';
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

?>