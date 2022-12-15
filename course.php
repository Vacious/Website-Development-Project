<?php 
session_start();
include_once ("dbconn.php"); 
include ("component.php"); 

if(isset($_POST['add'])){
    //cart has item
    if(isset($_SESSION['cart'])){
        $item_array_id = array_column($_SESSION['cart'],'courseid');
        if(in_array($_POST['course-id'],$item_array_id)){
            echo "<script> alert('Course is already added in the cart.')</script>";
            echo "<script> window.location = 'course.php'</script>";
        }
        else{
            $count= count($_SESSION['cart']);
            $item_array=array('courseid' => $_POST['course-id']);
            $_SESSION['cart'][$count]=$item_array;
            echo "<script> window.location = 'course.php'</script>";
        }
    }
    //cart is empty
    else{
        //store id into array
        $item_array=array('courseid' => $_POST['course-id']);
        //set array to cart's first index
        $_SESSION['cart'][0]=$item_array;
        echo "<script> window.location = 'course.php'</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yale Courses</title>
    <link rel="icon" href="images/icon.png" type="image/x-icon">
    <link rel="stylesheet"  href="css\course.css" <?php echo time(); ?>/>
    <link rel="stylesheet"  href="css\header.css" <?php echo time(); ?>/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <script>
    /* When the user clicks on the button,
    toggle between hiding and showing the dropdown content */
    function dropdown() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown menu if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
    </script>
</head>

<body>
    <!---header--->
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
                if(!isset($_SESSION["id"]) && !isset($_SESSION["usertype"])){
                    echo "<a href='index.html'>Back to Yale University</a>";
                }
                else{
                    if($_SESSION["usertype"] == "user"){
                        echo "<a href='dashboard-user.php'>Back to Yale University</a>";
                    }
                    else{
                        echo "<a href='dashboard-admin.php'>Back to Yale University</a>";
                    }
                }
                ?>
            </div>
            <!---back to home--->
            <!---cart--->
            <div class="header-cart">
             <button onclick="dropdown()" class="dropbtn">
                 <i class="fas fa-shopping-cart"></i> Cart  
                    <?php
                    if(isset($_SESSION['cart'])){
                        $count= count($_SESSION['cart']);
                        echo "<span id=\"cart-count\">$count</span>";
                    } else
                        echo "<span id=\"cart-count\"> 0 </span>";
                    ?>
                <div id="myDropdown" class="dropdown-content">
                    <a href="cart.php">Checkout</a>
                </div>
             </button>
            </div>
            <!---cart--->
            <!---login---
            <div class="header-login" >
            <a  href="/" > Login </a>
            </div>
            -login--->
        </div>    
        <!---container--->
    </header>
    <!---header--->

    <div class="container">
        <div class="row">
            <?php
            $sql= "SELECT * FROM coursetb";
            $rs = mysqli_query($conn,$sql);   
            if (!$rs) {
                echo "Cannot execute query: $sql<br />";
                trigger_error(mysqli_error(), E_USER_ERROR); 
            }
            
            while($row = mysqli_fetch_assoc($rs)) {
                component($row['courseImage'],$row['courseName'],$row['courseDesc'], $row['coursePrice'], $row['courseID']);
            }            
            ?> 
        </div>
    </div>

</body>
</html>