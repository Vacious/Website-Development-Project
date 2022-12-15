<?php
global $conn;

include "dbconn.php";
include "component.php";

if(!isset($_SESSION)){
    session_start();
}
// to pass UserID data
$userid=$_SESSION["id"];
$date = $_SESSION["date"];
unset($_SESSION["date"]);
$total = $_SESSION["total"];
unset($_SESSION["total"]);
$transid=$_COOKIE["trans"];

$sql = "INSERT INTO carttb (userID, transID) VALUES ('$userid', '$transid')";
if ($conn->query($sql) === TRUE) {
    //echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$sql2 = "INSERT INTO transtb(userID, transID, date, totalAmount) VALUES('$userid', '$transid', '$date', '$total')"; 
if ($conn->query($sql2) === TRUE) {
    //echo "New record created successfully";
  } else {
    echo "Error: " . $sql2 . "<br>" . $conn->error;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link rel="icon" href="images/icon.png" type="image/x-icon">
    <link rel="stylesheet"  href="css\success.css" <?php echo time(); ?>/>
    <link rel="stylesheet"  href="css\header.css" <?php echo time(); ?>/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            <a href="index.html" > Back to Yale University </a>
            </div>
            <!---back to home--->
            <!---login--->
            <div class="header-login" >
            <a  href="dashboard-user.php" > Dashboard </a>
            </div>
            <!---login--->
        </div>    
        <!---container--->
    </header>
    <!---header--->
    <!---set cart item into database--->
    <?php 
    $total=0;
    $sql= "SELECT * FROM coursetb";
    $rs = mysqli_query($conn,$sql);   
    if (!$rs) {
        echo "Cannot execute query: $sql<br />";
        trigger_error(mysqli_error(), E_USER_ERROR); 
    }
    if(isset($_SESSION['cart'])){
        $num = 0;
        $course_id = array_column($_SESSION['cart'],'courseid'); 
        while($row = mysqli_fetch_assoc($rs)) {
            foreach($course_id as $checkid){
                
                if($row['courseID']== $checkid){
                    $tempName=$row['courseName'];
                    $tempPrice=(int)$row['coursePrice'];
                    $tempID=$row['courseID'];
                    $total=$total + (int)$row['coursePrice'];

                    if($num > 0){
                        $sql3= "INSERT INTO carttb (userID, transID, courseName, coursePrice) VALUES ('$userid', '$transid', '$tempName', '$tempPrice')";
                        $rs3 = mysqli_query($conn,$sql3);   
                        if (!$rs3) {
                            echo "Cannot execute query: $sql<br />";
                            trigger_error(mysqli_error(), E_USER_ERROR); 
                        }
                    } else{
                        $sql2= "UPDATE carttb SET courseName = '$tempName', coursePrice = '$tempPrice' WHERE transID='$transid'";
                        $rs2 = mysqli_query($conn,$sql2);   
                        if (!$rs2) {
                            echo "Cannot execute query: $sql2<br />";
                            trigger_error(mysqli_error(), E_USER_ERROR);
                        }
                    }
                    $num++;
                }
            }
        }
        
        unset($_SESSION['cart']);
    }  
    
    ?>
    <div class="user">
        <h2>User details</h2>
        <br>
        <?php
        $sql = "SELECT * FROM myuser WHERE no='$userid'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<h4>Name: " . $row["first_name"] . "</h4>";
                    echo "<h4>Mobile: " . $row["mobile"] . "</h4>";
                    echo "<h4>Email: " . $row["email"] . "</h4>";
                    $username=$row["first_name"];
                    $usermobile=$row["mobile"];
                    $useremail=$row["email"];
                }
            } else {
                echo "<h4>Error</h4>";
            }
        ?>
        <h4>Invoice number #
        <?php
            $sql= "SELECT * FROM transtb WHERE date='$date'";
            $rs = mysqli_query($conn,$sql);
            if (!$rs) {
                echo "Cannot execute query: $sql<br />";
                trigger_error(mysqli_error(), E_USER_ERROR);
            }
            while($row = mysqli_fetch_assoc($rs)) {
                echo $row['orderID'];
                $invoicenum=$row['orderID'];
            };
            ?>
        </h4>
        <button class="print" onclick=window.print()><i class="fa fa-print" aria-hidden="true"></i>  Print </button>
    </div>
    
    <div class="invoice">
        <?php
        $sql= "SELECT * FROM carttb WHERE transID='$transid'";
        $rs = mysqli_query($conn,$sql);
        if (!$rs) {
            echo "Cannot execute query: $sql<br />";
            trigger_error(mysqli_error(), E_USER_ERROR);
        }
        
        while($row = mysqli_fetch_assoc($rs)) {
            invoice($row['courseName'], $row['coursePrice']);
        }

        ?>
        
        <div class="total-amount">
            <div class="amount">
                <h4>Total amount <?php echo "$ ".$total?></h4>
            </div>
        </div>
    </div>

<!--sent email-->
<?php

require ("includes/PHPMailer.php");
require ("includes/SMTP.php");
require ("includes/Exception.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail= new PHPMailer();
$mail->isSMTP();
$mail->Host= "SMTP.gmail.com";
$mail->SMTPAuth= "true";
$mail->SMTPSecure="tls";
$mail->Port= "587";
$mail->Username= "dummy422project@gmail.com";
$mail->Password= "dummy123!@#";
$mail->Subject= "Yale Art University Invoice";
$mail->setFrom("dummy422project@gmail.com");
$mail->isHTML(true);

$mail->Body= "
<p>Dear Customer,</p>
<p>We are pleased to inform you that the following online payment is successful:<p>
<table>
    <tr style='text-align: left;'>
        <th>Name</th>
        <td>:</td>
        <td>$username</td>
    </tr>
    <tr style='text-align: left;'>
        <th>Mobile</th>
        <td>:</td>
        <td>$usermobile</td>
    </tr>
    <tr style='text-align: left;'>
        <th>Date</th>
        <td>:</td>
        <td>$date</td>
    </tr>
    <tr style='text-align: left;'>
        <th>Invoice</th>
        <td>:</td>
        <td>$invoicenum</td>
    </tr>
    <tr style='text-align: left;'>
        <th>Total Amount</th>
        <td>:</td>
        <td>$total</td>
    </tr>
</table>
<h4>Thank you for purchasing our courses.</h4>
";
//recipient
$mail->addAddress ("$useremail");
if (!$mail->Send()){
    echo "error";
} 
$mail->smtpClose();

?>
  
</body>
</html>