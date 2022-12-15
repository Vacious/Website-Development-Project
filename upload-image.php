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

if(isset($_POST['upload'])){ 
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];    
    $folder = "profile-image/".$filename;
    
    $s = "SELECT * FROM image WHERE id='$id'";
    $result = mysqli_query($conn, $s);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $sql = "UPDATE image SET image_name='$filename' WHERE id='$id'";
            if ($conn->query($sql) === TRUE) {
                // echo "Login date time updated successfully. <br>";
                echo '<script>alert("Image updated successfully.")</script>';
            } else {
                echo '<script>alert("Error updating image")</script>';
                // echo "Error updating login date time: " . $conn->error . "<br>";
            }
        }
    }
    else {
        $sql = "INSERT INTO image(id, image_name) VALUES('$id', '$filename')";
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Image insert successfully.")</script>';
        } else {
            echo '<script>alert("Error inserting image")</script>';
        }
    }
    
    if(move_uploaded_file($tempname, $folder))  {
        // echo '<script>alert("Image uploaded successfully")</script>';
    }else{
        // echo '<script>alert("Failed to upload image")</script>';
    }
    echo '<script>window.location.href="profile.php"</script>';
}

ob_end_flush();

?>