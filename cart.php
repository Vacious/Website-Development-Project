<?php 

ob_start();

if(!isset($_SESSION)){
    session_start();
}

include_once ("dbconn.php");
include_once("header.php");
include "component.php"; 
include "dbConnection.php";	

if(!isset($_SESSION["id"]) && !isset($_SESSION["usertype"])){
    header("Location: login.php");
} else{
    $id = $_SESSION["id"];
}

if($_SESSION["usertype"] == "admin"){
    header("Location: course.php");
}

if(!isset($_SESSION["cart"])){
    echo '<script> alert("Please add course to cart.")</script>';
    echo '<script> window.location.href = "course.php"</script>';
}

if(isset($_POST['remove'])){
    if($_GET['action']== 'remove'){
        foreach($_SESSION['cart'] as $key=> $value){
            if($value["courseid"] ==$_GET['id']){
                unset($_SESSION['cart'][$key]);
                echo "<script> alert('Course is removed')</script>";
                echo "<script> window.location = 'cart.php'</script>";
            }
        }
    }
}

ob_end_flush();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/icon.png" type="image/x-icon">
    <link rel="stylesheet"  href="css\cart.css" <?php echo time(); ?>/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>My Cart</title>
    <script>
        function myDropbtn(){
            document.getElementById("myDropdown").classList.toggle("show");
        }
    </script>
</head>
<body>
    <ul class="breadcrumb">
    <li><a href="dashboard-user.php">Home</a></li>
    <li><a href="course.php">Courses</a></li>
    <li><a href="cart.php">Cart</a></li>
    </ul>
    <div class="cart-container">
        <div class="row">
            <!---Cart--->
            <div class="course-cart">
                <h5> My Cart </h5>
                <hr>
                <?php
                    $total=0;
                    $sql= "SELECT * FROM coursetb";
                    $rs = mysqli_query($conn,$sql);   
                    if (!$rs) {
                        echo "Cannot execute query: $sql<br />";
                        trigger_error(mysqli_error(), E_USER_ERROR); 
                    }
                    if(isset($_SESSION['cart'])){
                        $course_id = array_column($_SESSION['cart'],'courseid'); 
                        while($row = mysqli_fetch_assoc($rs)) {
                            foreach($course_id as $checkid){
                                if($row['courseID']== $checkid){
                                    element($row['courseImage'],$row['courseName'], $row['coursePrice'], $row['courseID']);
                                    $total = $total+ (int)$row['coursePrice'];
                                }
                            }
                        }
                    }  
                    else{
                        echo "<h4> Cart is empty </h4> ";
                    }
                ?>
            </div>
            <!---Cart--->
            <!---Details--->
            <div class="details">
                <div class="title">
                    <h5> Price Details </h5>
                    <p>
                        <?php
                        date_default_timezone_set("Asia/Kuala_Lumpur");
                        $date=date('h:i:sa d/m/y');
                        echo $date;
                        ?>
                    </p>
                    <hr>
                </div>
                <div class="details-row">
                    <div class="details-column">
                        <?php
                        if(isset($_SESSION['cart'])){
                            $count= count($_SESSION['cart']);
                            echo "<h4> Subtotal </h4> <br >";
                            echo "<h4> Total Quantity (items)</h4>";

                        }else
                        echo "<h4> Price (0)</h4>";
                        ?>
                    </div>
                    <div class="details-column">
                        <h5><?php echo "$ $total"; ?></h5>
                        <br>
                        <h5><?php echo $count; ?></h5>   
                    </div>
                </div>
                <hr>
                <div class="details-row2">
                    <div class="details-column2">    
                    <?php echo "<h4> Total Amount</h4>";?>

                    </div>
                    <div class="details-column2">    
                    <h5><?php echo "$ $total"; ?></h5>
                    </div>
                </div>
                <div id="paypal-button-container">
                   
                </div>

            </div>
            <!---Details--->
        </div>
    </div>

    <?php

    date_default_timezone_set("Asia/Kuala_Lumpur");
    $date=date("Y-m-d h:i:s");
    $_SESSION['date']=$date;
    $_SESSION['total']=$total;
    
    ?>
    
    <script src="https://www.paypal.com/sdk/js?client-id=ASJP8_9o_cB0hGOKiBZYpZQqBKQhvB7WoS29IRFtHa1AzJ_stV92GogIYqxiLMs_bCQslyGN4cqbOxqS&currency=USD&disable-funding=credit,card"></script>
    <script>
        paypal.Buttons({

        // Sets up the transaction when a payment button is clicked
        createOrder: function(data, actions) {
            return actions.order.create({
            purchase_units: [{
                amount: {
                value: '<?php echo ($total); ?>'
                }
            }]
            });
        },

        // Finalize the transaction after payer approval
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(orderData) {
            // Successful capture! For dev/demo purposes:
                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                var transaction = orderData.purchase_units[0].payments.captures[0];
                alert('Transaction '+ transaction.status + ': ' + transaction.id );
 
            // When ready to go live, remove the alert and show a success message within this page. For example:
            //  var element = document.getElementById('paypal-button-container');
            //  element.innerHTML = '';
            //  element.innerHTML = '<h3>Thank you for your payment!</h3>';
            
        // Creating a cookie after the document is ready
        
            createCookie("trans", transaction.id, "10");
        
            
        // Function to create the cookie
        function createCookie(name, value, days) {
            var expires;
                
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toGMTString();
            }
            else {
                expires = "";
            }
                
            document.cookie = escape(name) + "=" + 
                escape(value) + expires + "; path=/";
            }

            window.location.replace('success.php');
            
            });

        },

        onCancel: function(data) {
            alert("Payment is unsuccessful, please try again.");
            window.location.replace('cart.php');

        }
        }).render('#paypal-button-container');
    </script>
    
</body>
</html>