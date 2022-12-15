<?php

global $conn;

include "dbConnection.php";	

$firstName = $lastName = $email = $mobile = $password = $comfirmPassword = $gender = $state = "";
$firstName_error = $lastName_error = $email_error = $mobile_error = $password_error = $comfirmPassword_error = $gender_error = $state_error = "";

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

    $num = test_input($_POST["id"]);
    if($flag){
        $s = "SELECT * FROM myuser WHERE no='$num'";
        $result = mysqli_query($conn, $s);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $sql = "UPDATE myuser SET first_name='$firstName', last_name='$lastName', email='$email', mobile='$mobile', password='securePass', gender='$gender', state='$state', usertype='user' WHERE no='$num'";
                if(mysqli_query($conn, $sql)){
                    echo '<script>alert("Update member account data successfully")</script>';
                }else{
                    echo '<script>alert("Update member account data unsuccessfully")</script>';
                }
            }
        }
    }
    echo '<script>window.location.href="registered-member-account.php"</script>';
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <title>Update Member Account - Yale School of Art</title>
        <link rel="icon" href="images/icon.png" type="image/x-icon">
        <link rel="stylesheet" href="dashboard-admin.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
        <link rel="stylesheet" href="form.css">

        <style>
        .button{
            margin: 0px 0px 30px 0px;
        }
    </style>
    </head>
    <body>
        <input type="checkbox" id="nav-toggle">
        <div class="sidebar">
            <div class="sidebar-title">
                <a href="index.html"><img src="images/logo.png" alt="logo"></a>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="dashboard-admin.php"><span class="fas fa-house-user"></span>
                        <span>Dashboard</span></a>
                    </li>
                    <li>
                        <a href="registered-member-account.php" class="active"><span class="far fa-address-card"></span>
                        <span>Registered Member Accounts</span></a>
                    </li>
                    <li>
                        <a href="edit-courses.php"><span class="fas fa-school"></span>
                        <span>Courses</span></a>
                    </li>
                    <li>
                        <a href="summary-transaction-record.php"><span class="far fa-money-bill-alt"></span>
                        <span>Summary of Transaction Record</span></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content">
            <header>
                <h2>
                    <label for="nav-toggle">
                        <span class="fas fa-bars"></span>
                    </label>
                    Registered Member Accounts
                </h2>
                <div class="search-wrapper">
                    <span class="fas fa-search"></span>
                    <input type="search" placeholder="Search Here">
                </div>
                
                <div class="user-wrapper">
                    <div class="nav-links">
                        <a href="course.php"><button class="btn">Paid Courses</button></a>
                    </div>
                    <div class="dropdown">
                        <button onclick="myDropbtn()" class="dropbtn">
                            <img src="images/admin.jpg" width='35px' height='35px' style="object-fit: cover; border: 1px solid #b3b3b3;">
                        </button>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="logout.php">Log Out</a>
                        </div>
                    </div>
                    <div>
                        <h4>Yale</h4>
                        <small>Admin</small>
                    </div>
                </div>
            </header>
            <main>
            <div class="content">
                <div class="container">
                    <div class="title" style="text-align: center;">Update Member Account</div>
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
                        <input type="hidden" id="id" name="id" value="<?php echo $_GET['id']; ?>">
                        <div class="button" id="button">
                            <input type="reset" value="Clear" onclick="myReset()">
                            <input type="submit" value="Update">
                        </div>
                    </form>
                </div> <!--End class container-->
            </div>
            <script type="text/javascript" src="registrationValidation.js"></script>
            </main>

             <!--Footer Section-->
            <section class="Footer">
                <div class="F-Social">
                    <a href="https://www.facebook.com/YaleSchoolofArt/" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.instagram.com/yaleschoolofart/" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/channel/UCDwJT0mYodTSodcpH-hGmdA" target="_blank"><i class="fab fa-youtube"></i></a>
                </div>
                <ul class="F-List">
                    <li><a href="https://www.art.yale.edu/about/support-the-school" target="_blank">Support The School</a></li>
                    <li><a href="https://www.art.yale.edu/about/visiting" target="_blank">Visiting</a></li>
                    <li><a href="https://your.yale.edu/policies-procedures/policies/1605-web-accessibility-policy" target="_blank">Accessibility At Yale</a></li>
                    <li><a href="https://www.art.yale.edu/sitemap" target="_blank">Sitemap</a></li>
                    <li><a href="https://www.art.yale.edu/about/contact" target="_blank">Contact</a></li>
                </ul>
                <p class="F-Text">
                    This website exists as an ongoing collaborative experiment in digital publishing and information sharing. 
                    Because this website functions as a wiki, all members of the School of Art community—graduate students, faculty, 
                    staff, and alums—have the ability to add new content and pages, and to edit most of the site’s existing content.
                    Content is the property of its various authors. When you contribute to this site, you agree to abide by Yale University academic and network use policy, 
                    and to act as a responsible member of our community.
                </p>
                <p class="F-Copyright">&copy 2021</p>
            </section>
            <!--End Footer Section-->
        </div>

        <script>
            function myDropbtn(){
              document.getElementById("myDropdown").classList.toggle("show");
            }
        </script>
    </body>
</html>