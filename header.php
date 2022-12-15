<?php 

if(!isset($_SESSION)){
    session_start();
}

include_once ("dbConnection.php"); 

if(isset($_SESSION["id"])){
    $id = $_SESSION["id"];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yale Art University</title>
    <link rel="stylesheet"  href="css\header.css" <?php echo time(); ?>/>
</head>
<body>
    <header id="product-header">
        <!---container--->
        <div id="header-container">
            <!---logo--->
            <div id="header-branding">
                <a href="index.html"><img style="display: block;margin-top:10px; margin-left:50px;width:250px;height: 60px;" alt="Yale University products" src="images\logo.png" /></a>
            </div>
            <!---logo--->
            <!---back to home--->
            <div class="header-menu" >
                <?php

                if(!isset($_SESSION["id"])){
                    echo "<a href='index.html'> Back to Yale University</a>";
                }
                else{
                    echo "<a href='dashboard-user.php'> Back to Yale University</a>";
                }

                ?>
            </div>
            <!---back to home--->
            <!---login--->
            <div class="user-wrapper">
                <div class="dropdown">
                    <button onclick="myDropbtn()" class="dropbtn">
                        <?php
                                    
                        $sql = "SELECT image_name FROM image WHERE id='$id'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                echo "<img src='profile-image/".$row['image_name']."' width='35px' height='35px' style='object-fit: cover; border: 1px solid #b3b3b3;'>";
                            }
                        } else{
                            echo "<img src='images/profile.png' width='35px' height='35px' style='object-fit: cover; border: 1px solid #b3b3b3;'>";
                        }

                        ?>
                    </button>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="logout.php">Log Out</a>
                    </div>
                </div>
            </div>
            <!---login--->
        </div>    
        <!---container--->
    </header>
    <!---header--->

</body>
</html>