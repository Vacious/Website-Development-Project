<?php

include "dbConnection.php";	

session_start();

if(!isset($_SESSION["id"])){
    header("Location: login.php");
}

$id = $_SESSION["id"];

?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <title>User Profile - Yale School of Art</title>
        <link rel="icon" href="images/icon.png" type="image/x-icon">
        <link rel="stylesheet" href="css/dashboard-user.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
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
                        <a href="dashboard-user.php"><span class="fas fa-house-user"></span>
                        <span>Dashboard</span></a>
                    </li>
                    <li>
                        <a href="profile.php" class="active"><span class="far fa-address-card"></span>
                        <span>Profile</span></a>
                    </li>
                    <li>
                        <a href="transaction-user.php"><span class="far fa-money-bill-alt"></span>
                        <span>Transaction</span></a>
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
                    Profile
                </h2>
                <div class="search-wrapper">
                    <span class="fas fa-search"></span>
                    <input type="search" placeholder="Search Here">
                </div>

                <div class="user-wrapper">
                    <div class="nav-links">
                        <a href="course.php"><button class="btn">Paid Courses</button></a>
                        <a href="cart.php"><button class="btn"><i class="fas fa-shopping-cart"></i></button></a>
                    </div>
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
                    <div>
                        <?php
                                    
                        $sql = "SELECT first_name FROM myuser WHERE no='$id'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<h4>" . $row["first_name"] . "</h4>";
                            }
                        } else {
                            echo "<h4>Error</h4>";
                        }

                        ?>
                        <small>Registered User</small>
                    </div>
                </div>
            </header>
            <main>
                <div class="profile-details">
                    <h2>General Account Settings</h2>
                    <table>
                        <tr>
                            <th>Profile Image</th>
                            <td>
                                <div id="image">
                                    <?php
                                    
                                    $sql = "SELECT image_name FROM image WHERE id='$id'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0){
                                        while($row = $result->fetch_assoc()){
                                            echo "<img src='profile-image/".$row['image_name']."'>";
                                        }
                                    } else {
                                    echo "<img src='images/profile.png'>";
                                    }

                                    ?>
                                    <button onclick="editImage()">Edit</button>
                                </div>
                                <div id="myImage">
                                    <form method="POST" action="upload-image.php" enctype="multipart/form-data">
                                        <input type="file" name="uploadfile" required><br>
                                        <input type="submit" name="upload" value="Upload">
                                        <a href="profile.php"><input type="button" value="Cancel"></a>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>First Name</th>
                            <td>
                                <div id="firstName">
                                    <?php
                                    
                                    $sql = "SELECT first_name FROM myuser WHERE no='$id'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo $row["first_name"];
                                        }
                                    } else {
                                        echo "Error";
                                    }

                                    ?>
                                    <button onclick="editFirstName()">Edit</button>
                                </div>
                                <div id="myFirstName">
                                    <form method="post" action="update-first-name.php">
                                        <label for="fname">First name:</label>
                                        <input type="text" id="fname" name="fname" required><br>
                                        <input type="submit" value="Save">
                                        <a href="profile.php"><input type="button" value="Cancel"></a>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td>
                                <div id="lastName">
                                    <?php
                                    
                                    $sql = "SELECT last_name FROM myuser WHERE no='$id'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo $row["last_name"];
                                        }
                                    } else {
                                        echo "Error";
                                    }

                                    ?>
                                    <button onclick="editLastName()">Edit</button>
                                </div>
                                <div id="myLastName">
                                    <form method="post" action="update-last-name.php">
                                        <label for="lname">Last name:</label>
                                        <input type="text" id="lname" name="lname"><br>
                                        <input type="submit" value="Save">
                                        <a href="profile.php"><input type="button" value="Cancel"></a>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Mobile</th>
                            <td>
                                <div id="phoneNum">
                                    <?php
                                    
                                    $sql = "SELECT mobile FROM myuser WHERE no='$id'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo $row["mobile"];
                                        }
                                    } else {
                                        echo "Error";
                                    }

                                    ?>
                                    <button onclick="editPhoneNum()">Edit</button>
                                </div>
                                <div id="myPhoneNum">
                                    <form method="post" action="update-mobile.php">
                                        <label for="pnum">Mobile <span class="format">(Format: +60xx-xxxxxxxx)</span>:</label>
                                        <input type="text" id="pnum" name="pnum" placeholder="+60xx-xxxx-xxxx" value="+60"><br>
                                        <input type="submit" value="Save">
                                        <a href="profile.php"><input type="button" value="Cancel"></a>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>
                                <div id="email">
                                    <?php
                                    
                                    $sql = "SELECT email FROM myuser WHERE no='$id'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo $row["email"];
                                        }
                                    } else {
                                        echo "Error";
                                    }

                                    ?>
                                    <button onclick="editEmail()">Edit</button>
                                </div>
                                <div id="myEmail">
                                    <form method="post" action="update-email.php">
                                        <label for="email">Email:</label>
                                        <input type="text" id="email" name="email"><br>
                                        <input type="submit" value="Save">
                                        <a href="profile.php"><input type="button" value="Cancel"></a>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td>
                                <div id="password">******
                                    <button onclick="editPassword()">Edit</button>
                                </div>
                                <div id="myPassword">
                                    <form method="post" action="update-password.php">
                                        <label for="password">Password:</label>
                                        <input type="password" id="password" name="password"><br>
                                        <label for="password">Re-type:</label>
                                        <input type="password" id="password" name="password2"><br>
                                        <input type="submit" value="Save">
                                        <a href="profile.php"><input type="button" value="Cancel"></a>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>
                                <div id="gender">
                                    <?php
                                    
                                    $sql = "SELECT gender FROM myuser WHERE no='$id'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo $row["gender"];
                                        }
                                    } else {
                                        echo "Error";
                                    }

                                    ?>
                                    <button onclick="editGender()">Edit</button>
                                </div>
                                <div id="myGender">
                                    <form method="post" action="update-gender.php">
                                        <label for="gender">Gender:</label>
                                        <select name="gender" id="gender">
                                            <option value="" selected disabled>Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select><br>
                                        <input type="submit" value="Save">
                                        <a href="profile.php"><input type="button" value="Cancel"></a>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td>
                                <div id="state">
                                    <?php
                                    
                                    $sql = "SELECT state FROM myuser WHERE no='$id'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo $row["state"];
                                        }
                                    } else {
                                        echo "Error";
                                    }

                                    ?>
                                    <button onclick="editState()">Edit</button>
                                </div>
                                <div id="myState">
                                    <form method="post" action="update-state.php">
                                        <label for="state">State:</label>
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
                                        </select><br>
                                        <input type="submit" value="Save">
                                        <a href="profile.php"><input type="button" value="Cancel"></a>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
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

            function editImage(){
                var x = document.getElementById("myImage");
                x.style.display = "block";

                var y = document.getElementById("image");
                y.style.display = "none";
            }
            function editFirstName(){
                var x = document.getElementById("myFirstName");
                x.style.display = "block";

                var y = document.getElementById("firstName");
                y.style.display = "none";
            }
            function editLastName(){
                var x = document.getElementById("myLastName");
                x.style.display = "block";

                var y = document.getElementById("lastName");
                y.style.display = "none";
            }
            function editPhoneNum(){
                var x = document.getElementById("myPhoneNum");
                x.style.display = "block";

                var y = document.getElementById("phoneNum");
                y.style.display = "none";
            }
            function editEmail(){
                var x = document.getElementById("myEmail");
                x.style.display = "block";

                var y = document.getElementById("email");
                y.style.display = "none";
            }
            function editPassword(){
                var x = document.getElementById("myPassword");
                x.style.display = "block";

                var y = document.getElementById("password");
                y.style.display = "none";
            }
            function editGender(){
                var x = document.getElementById("myGender");
                x.style.display = "block";

                var y = document.getElementById("gender");
                y.style.display = "none";
            }
            function editState(){
                var x = document.getElementById("myState");
                x.style.display = "block";

                var y = document.getElementById("state");
                y.style.display = "none";
            }
        </script>

    </body>
</html>