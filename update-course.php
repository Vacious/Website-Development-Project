<?php

global $conn;

include "dbconn.php";	

$CourseName = $CourseDesc = $CoursePrice = "";
$CourseName_error = $CourseDesc_error = $CoursePrice_error = "";

$flag = true;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["CourseName"])){
        $CourseName_error = "Course name is required";
        $flag = false;
    } else{
        $CourseName = test_input($_POST["CourseName"]);

        if(!preg_match("/^([A-Z][a-z]+([ ]?[a-z]?['-]?[A-Z][a-z]+)*)$/", $CourseName)){
            $CourseName_error = "First character uppercase and follow by lowercase";
            $flag = false;
        }
    }

    if(empty($_POST["CourseDesc"])){
        $CourseDesc_error = "Course description is required";
        $flag = false;
    } else{
        $CourseDesc = test_input($_POST["CourseDesc"]);
    }

    if(empty($_POST["CoursePrice"])){
        $CoursePrice_error = "Price is required";
        $flag = false;
    } else{
        $CoursePrice = test_input($_POST["CoursePrice"]);

        if(!preg_match("/^[1-9][0-9]{0,3}$/", $CoursePrice)){
            $CoursePrice_error = "Price is invalid, it must only numbers and below 10000";
            $flag = false;
        }
    }
    $courseid = test_input($_POST["id"]);
    if($flag){
        $s = "SELECT * FROM coursetb WHERE courseID='$courseid'";
        $result = mysqli_query($conn, $s);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $sql = "UPDATE coursetb SET courseImage = 'images/logo.png', courseName = '$CourseName', courseDesc='$CourseDesc', coursePrice='$CoursePrice' WHERE courseID='$courseid'";
                if(mysqli_query($conn, $sql)){
                    echo '<script>alert("Update course data successfully")</script>';
                }else{
                    echo '<script>alert("Update course data unsuccessfully")</script>';
                }
            }
        }
    }
    echo '<script>window.location.href="edit-courses.php"</script>';
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
        <title>Update Course - Yale School of Art</title>
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
                        <a href="registered-member-account.php"><span class="far fa-address-card"></span>
                        <span>Registered Member Accounts</span></a>
                    </li>
                    <li>
                        <a href="edit-courses.php" class="active"><span class="fas fa-school"></span>
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
                    Courses
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
                            <img src="images/profile.png" width='35px' height='35px' style="object-fit: cover; border: 1px solid #b3b3b3;">
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
                    <div class="title" style="text-align: center;">Update Course Data</div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="form" id="form">
                        <div><?php if(isset($message)) { echo $message; } ?></div>
                        <div class="form-control">                   
                            <label>Course Name</label>
                            <input type="text" id="course-name" name="CourseName" placeholder="Enter course name"
                                title="First character uppercase and follow by lowercase">
                            <small>Error Message</small>
                            <span style="color:#e74c3c;font-size: smaller;"><?php echo $CourseName_error; ?></span>
                        </div>
                        <div class="form-control">
                            <label>Course Description</label>
                            <input type="text" id="course-desc" name="CourseDesc" placeholder="Enter course description"
                                title="First character uppercase and follow by lowercase">
                            <small>Error Message</small>
                            <span style="color:#e74c3c;font-size: smaller;"><?php echo $CourseDesc_error; ?></span>
                        </div>
                        <div class="form-control">
                            <label>Price</label>                  
                            <input type="text" id="price" name="CoursePrice" placeholder="Enter price of course">
                            <small>Error Message</small>
                            <span style="color:#e74c3c;font-size: smaller;"><?php echo $CoursePrice_error; ?></span>
                        </div>
                        <input type="hidden" id="id" name="id" value="<?php echo $_GET['id']; ?>">
                        <div class="button" id="button">
                            <input type="reset" value="Clear" onclick="myReset()">
                            <input type="submit" value="Update">
                        </div>
                    </form>
                </div>
                    <script type="text/javascript" src="courseValidation.js"></script>
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