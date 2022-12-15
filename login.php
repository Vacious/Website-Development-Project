<?php

global $conn;

include "dbConnection.php";	

session_start();

if(isset($_SESSION["id"]) && isset($_SESSION["usertype"])){
    if($_SESSION["usertype"] == "user"){
        header("Location: dashboard-user.php");
    }
    else{
        header("Location: dashboard-admin.php");
    }
    
}

$email = $password = "";
$email_error = $password_error = "";

$flag = true;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["email"])){
        $email_error = "Email is required<br>";
        $flag = false;
    } else{
        $email = test_input($_POST["email"]);

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email_error = "Email is invalid<br>";
            $flag = false;
        }
    }

    if(empty($_POST["password"])){
        $password_error = "Password is required<br>";
        $flag = false;
    } else{
        $password = test_input($_POST["password"]);
    }

    if($flag){
        $s = "SELECT * FROM myuser WHERE email = '$email'";
        $result = mysqli_query($conn, $s);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                if(password_verify($password, $row["password"])){
                    if($row["usertype"] == "user"){
                        $num = $row["no"];
                        $_SESSION["id"] = $num;
                        $_SESSION["usertype"] = "user";

                        header("Location: dashboard-user.php");
                    }
                    else{
                        $num = $row["no"];
                        $_SESSION["id"] = $num;
                        $_SESSION["usertype"] = "admin";

                        header("Location: dashboard-admin.php");
                    }
                } else{
                    $password_error = "The password that you've entered is incorrect.";
                }
            }
        }
        else{
            $email_error = "The email address you entered isn't connected to an account. Creare a new account.";
        } 
    } 
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - Yale School of Art</title>
    <link rel="icon" href="images/icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="form.css">
</head>

<body>
    <div class="header">
        <a href="index.html"><img src="images/logo.png" alt="logo"></a>
        <a href="index.html"><button class="btn" title="Go back to home page"><i class="fas fa-times"></i></button></a>
    </div>

    <div class="content">
        <div class="container">
            <div class="title">Log In</div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="form" id="form">
                <div class="form-control">
                    <label>Email</label>                  
                    <input type="text" id="email" name="email" placeholder="Enter your email">
                    <div class="icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error Message</small>
                    <span style="color:#e74c3c;font-size: smaller;"><?php echo $email_error; ?></span>
                </div>
                <div class="form-control">
                    <label>Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" 
                        title="Must contain one uppercase, one lower case, one special character ( ! @ # $ % ^ & * ), numbers and no space, and at least 6 digits length">
                    <div class="icon">
                        <i class="fas fa-key"></i>      
                    </div>
                    <i class="fas fa-eye" id="togglePassword" onclick="togglePassword()"></i>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error Message</small>
                    <span style="color:#e74c3c;font-size: smaller;"><?php echo $password_error; ?></span>
                </div>
                <div class="button" id="button">
                    <input type="reset" value="Clear" onclick="myReset()">
                    <input type="submit" value="Log In">
                </div>
                <div class="form-control">
                    <p>Don't have an account? <a href="registration.php">Sign up now</a>.</p>
                </div>        
            </form>
        </div> <!--End class container-->
    </div>

    <script type="text/javascript" src="loginValidation.js"></script>

</body>
    
</html>