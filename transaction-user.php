<?php

global $conn;

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
        <title>User Dashboard - Yale School of Art</title>
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
                        <a href="profile.php"><span class="far fa-address-card"></span>
                        <span>Profile</span></a>
                    </li>
                    <li>
                        <a href="transaction-user.php" class="active"><span class="far fa-money-bill-alt"></span>
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
                    Transaction
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
                <div class="transaction-details">
                    <h2>Transaction History</h2>
                    <div class="transaction-table">
                        <table>
                            <tr>
                                <th>No</th>
                                <th>Item Name</th>
                                <th>Transaction ID</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Price</th>
                                <th>Total Amount</th>
                            </tr>
                            <?php

                            $query = "SELECT carttb.courseName, transtb.transID, transtb.date, carttb.coursePrice, transtb.totalAmount FROM carttb INNER JOIN transtb ON carttb.transID = transtb.transID WHERE carttb.userID = '$id' ORDER BY date DESC";
                            $rs = $conn->query($query);
                            
                            if ($rs->num_rows > 0){
                                $num = 1;
                                while($row = mysqli_fetch_assoc($rs)){
                                    echo "<tr>";
                                        echo "<td>" . $num . "</td>";
                                        echo "<td>" . $row["courseName"] . "</td>";
                                        echo "<td>" . $row["transID"] . "</td>";
                                        $date = $row["date"];
                                        echo "<td>" . date("d M Y", strtotime($date)) . "</td>";
                                        echo "<td>" . date("H:i:s", strtotime($date)) . "</td>";
                                        echo "<td>" . $row["coursePrice"] . "</td>";
                                        echo "<td>" . $row["totalAmount"] . "</td>";
                                    echo "</tr>";
                                    $num++;
                                }
                            } else{
                                echo "<tr>";
                                    echo "<td colspan='7'>There is no transaction record.</td>";
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