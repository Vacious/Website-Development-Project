<?php

global $conn;

include "dbConnection.php";	

$firstName = $lastName = $email = $mobile = $password = $comfirmPassword = $gender = $state = $tnc = "";
$firstName_error = $lastName_error = $email_error = $mobile_error = $password_error = $comfirmPassword_error = $gender_error = $state_error = $tnc_error = "";

$flag = true;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["firstName"])){
        $firstName_error = "First name is required";
        $flag = false;
    } else{
        $firstName = test_input($_POST["firstName"]);

        if(!preg_match("/^([A-Z][a-z]+([ ]?[a-z]?['-]?[A-Z][a-z]+)*)$/", $firstName)){
            $firstName_error = "First character uppercase and follow by lowercase";
            $flag = false;
        }
    }

    if(empty($_POST["lastName"])){
        $lastName_error = "Last name is required";
        $flag = false;
    } else{
        $lastName = test_input($_POST["lastName"]);

        if(!preg_match("/^([A-Z][a-z]+([ ]?[a-z]?['-]?[A-Z][a-z]+)*)$/", $lastName)){
            $lastName_error = "First character uppercase and follow by lowercase";
            $flag = false;
        }
    }

    if(empty($_POST["email"])){
        $email_error = "Email is required";
        $flag = false;
    } else{
        $email = test_input($_POST["email"]);

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email_error = "Email is invalid";
            $flag = false;
        }
    }

    if(empty($_POST["mobile"])){
        $mobile_error = "Mobile is required";
        $flag = false;
    } else{
        $mobile = test_input($_POST["mobile"]);

        if(!preg_match("/^(\+?6?01)[02-46-9][-][0-9]{7}$|^(\+?6?01)[1][-][0-9]{8}$/", $mobile)){
            $mobile_error = "Mobile number is invalid, it must match the requested format";
            $flag = false;
        }
    }

    if(empty($_POST["password"])){
        $password_error = "Password is required";
        $flag = false;
    } else{
        $password = test_input($_POST["password"]);
        $securePass = password_hash($password, PASSWORD_BCRYPT);

        if(!preg_match("/^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{6,}$/", $password)){
            $password_error = "Password is invalid, must contain one uppercase, one lower case, one special character ( ! @ # $ % ^ & * ), numbers and no space, and at least 6 digits length";
            $flag = false;
        }
    }

    if(empty($_POST["password2"])){
        $comfirmPassword_error = "Comfirm Password is required";
        $flag = false;
    } else{
        $comfirmPassword = test_input($_POST["password2"]);

        if($password != $comfirmPassword){
            $comfirmPassword_error = "Passwords do not match";
            $flag = false;
        }
    }

    if(empty($_POST["gender"])){
        $gender_error = "Gender is required";
        $flag = false;
    } else{
        $gender = test_input($_POST["gender"]);
    } 

    if(empty($_POST["state"])){
        $state_error = "State is required";
        $flag = false;
    } else{
        $state = test_input($_POST["state"]);
    }

    if(empty($_POST["tnc"])){
        $tnc_error = "Accept Terms and Conditions is required";
        $flag = false;
    } else{
        $tnc = test_input($_POST["tnc"]);
    }

    if($flag){
        $s = "SELECT * FROM myuser WHERE email = '$email'";
        $result = mysqli_query($conn, $s);
        $num = mysqli_num_rows($result);
        if($num){
            $email_error = "Email is already registered.";
        } else{
            $sql = "INSERT INTO myuser(first_name, last_name, email, mobile, password, gender, state, usertype) VALUES('$firstName', '$lastName', '$email', '$mobile', '$securePass', '$gender', '$state', 'user')";
            if(mysqli_query($conn, $sql)){
                echo '<script>alert("Registration successful")</script>';
            }else{
                echo '<script>alert("Registration unsuccessful")</script>';
            }
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
    <title>Registration - Yale School of Art</title>
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
            <div class="title">User Account Registeration</div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="form" id="form">
                <div class="form-control">                   
                    <label>First Name</label>
                    <input type="text" id="first-name" name="firstName" placeholder="Enter your first name"
                        title="First character uppercase and follow by lowercase">
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error Message</small>
                    <span style="color:#e74c3c;font-size: smaller;"><?php echo $firstName_error; ?></span>
                </div>
                <div class="form-control">
                    <label>Last Name</label>
                    <input type="text" id="last-name" name="lastName" placeholder="Enter your last name"
                        title="First character uppercase and follow by lowercase">
                    <div class="icon">
                        <i class="fas fa-user"></i>      
                    </div>
                    <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error Message</small>
                        <span style="color:#e74c3c;font-size: smaller;"><?php echo $lastName_error; ?></span>
                </div>
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
                    <label for="mobile">Mobile <span class="format">(Format: +60xx-xxxxxxxx)</span></label>                   
                    <input type="tel" id="mobile" name="mobile" placeholder="+60xx-xxxx-xxxx" value="+60">
                    <div class="icon">
                        <i class="fas fa-mobile-alt"></i>      
                    </div> 
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error Message</small>
                    <span style="color:#e74c3c;font-size: smaller;"><?php echo $mobile_error; ?></span>
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
                <div class="form-control">
                    <label>Comfirm Password</label>
                    <input type="password" id="comfirm-password" name="password2" placeholder="Comfirm your password">
                    <div class="icon">
                        <i class="fas fa-lock"></i>      
                    </div>
                    <i class="fas fa-eye" id="togglePassword2" onclick="togglePassword2()"></i>
                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error Message</small>
                    <span style="color:#e74c3c;font-size: smaller;"><?php echo $comfirmPassword_error; ?></span>
                </div>
                <div class="form-control">
                    <input type="radio" id="male" name="gender" value="Male" onclick="genderMale()">
                    <input type="radio" id="female"  name="gender" value="Female" onclick="genderFemale()">
                    <label id="gender">Gender</label>
                    <div class="gender-details">
                        <label for="male">
                            <span class="dot male"></span>
                            <span class="gender">Male</span>
                        </label> 
                        <label for="female">
                            <span class="dot female"></span>
                            <span class="gender">Female</span>
                        </label> 
                    </div>
                    <i class="fas fa-male"></i>
                    <i class="fas fa-female"></i>
                    <small>Error Message</small>
                    <span style="color:#e74c3c;font-size: smaller;"><?php echo $gender_error; ?></span>
                </div>
                <div class="form-control">
                    <label for="state">State</label>
                    <select name="state" id="state">
                        <option value="" selected disabled>Select State</option>
                        <option value="Johor">Johor</option>
                        <option value="Kedah">Kedah</option>
                        <option value="Kelantan">Kelantan</option>
                        <option value="Malacca">Malacca</option>
                        <option value="Negeri Sembilan">Negeri Sembilan</option>
                        <option value="Pahang">Pahang</option>
                        <option value="Penang">Penang</option>
                        <option value="Perak">Perak</option>
                        <option value="Perlis">Perlis</option>
                        <option value="Selangor">Selangor</option>
                        <option value="Terengganu">Terengganu</option>
                        <option value="Sabah">Sabah</option>
                        <option value="Sarawak">Sarawak</option>
                        <option value="Federal Territory of Kuala Lumpur">Federal Territory of Kuala Lumpur</option>
                        <option value="Federal Territory of Labuan">Federal Territory of Labuan</option>
                        <option value="Federal Territory of Putrajaya">Federal Territory of Putrajaya</option>
                    </select>
                    <small>Error Message</small>
                    <span style="color:#e74c3c;font-size: smaller;"><?php echo $state_error; ?></span> 
                </div>
                <div class="form-control">
                    <input type="checkbox" id="checkbox" name="tnc" value="Accept">
                    <span class="tnc">I accept the above Terms and Conditions</span>
                    <small>Error Message</small>
                    <span style="color:#e74c3c;font-size: smaller;"><?php echo $tnc_error; ?></span> 
                </div> 
                <div class="button" id="button">
                    <input type="reset" value="Clear" onclick="myReset()">
                    <input type="submit" value="Register">
                </div>
                <div class="form-control">
                    <p>Already have an account? <a href="login.php">Log in here</a>.</p>
                </div>      
            </form>
        </div> <!--End class container-->
    </div>
    <script type="text/javascript" src="registrationValidation.js"></script>
</body>
    
</html>