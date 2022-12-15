<?php

ob_start();

global $conn;

include "dbconn.php";	

if(!isset($_SESSION)){
    session_start();
}

ob_end_flush();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <title>Registered Member Account - Yale School of Art</title>
        <link rel="icon" href="images/icon.png" type="image/x-icon">
        <link rel="stylesheet" href="dashboard-admin.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
        
        <style>
            .button {
                border: 2px solid #f2f2f2;
                border-radius: 50px;
                background-color: white;
                padding: 5px 20px;
                font-size: 20px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                float: right;
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
                    Registered Member
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
                <div class="member-account-details">
                    <h2 style="font-size: x-large; padding: 15px; ">Accounts<a href="create-member-account.php" class="button">Create Account</a></h2>
                    <div class="member-account-table">
                        <table>
                            <tr>
                                <th>No</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Gender</th>
                                <th>State</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Password</th>
                                <th colspan="2" style="text-align: center">Action</th>
                            </tr>
                            <?php
                                $query = "SELECT * FROM myuser WHERE usertype='user'";
                                $rs = $conn->query($query);
                                
                                if ($rs->num_rows > 0){
                                    $num = 1;
                                    while($row = mysqli_fetch_assoc($rs)){ ?>
                                        <tr>
                                            <td><?php echo $num ?></td>
                                            <td><?php echo $row["first_name"]; ?></td>
                                            <td><?php echo $row["last_name"]; ?></td>
                                            <td><?php echo $row["gender"]; ?></td>
                                            <td><?php echo $row["state"]; ?></td>
                                            <td><?php echo $row["email"]; ?></td>
                                            <td><?php echo $row["mobile"]; ?></td>
                                            <td>******</td>
                                            <td><a href="update-member-account.php?id=<?php echo $row["no"]; ?>">Update</a></td>
                                            <td><a href="delete-member-account.php?id=<?php echo $row["no"]; ?>">Delete</a></td>
                                        </tr>
                                        <?php
                                        $num++;
                                    }
                                } else{
                                    echo "<tr>";
                                        echo "<td colspan='10'>There is no registered member record.</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                    </div>
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
        </script>
    </body>
</html>