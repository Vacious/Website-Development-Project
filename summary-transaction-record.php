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
        <title>Transaction Summary - Yale School of Art</title>
        <link rel="icon" href="images/icon.png" type="image/x-icon">
        <link rel="stylesheet" href="dashboard-admin.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>  
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> 
    </head>

    <style>
        main button{
            border: 2px solid #f2f2f2;
            border-radius: 50px;
            background-color: white;
            padding: 5px 20px;
            margin-bottom: 10px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }
        .column{
            margin-top:5px;
        }
    </style>
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
                        <a href="edit-courses.php"><span class="fas fa-school"></span>
                        <span>Courses</span></a>
                    </li>
                    <li>
                        <a href="summary-transaction-record.php" class="active"><span class="far fa-money-bill-alt"></span>
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
                    Transaction Records
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
                <a href="generate-report.php"><button class="print"><i class="fa fa-print" aria-hidden="true" style="margin-right: 10px;"></i>PDF</button></a>
                <div class="member-account-details">
                    <div class="filter-block">
                        <h3 style="font-size: x-large; padding: 15px">Summary of Transaction Records</h3>
                        <div class="column">
                            <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" />  
                        </div>  
                        <div class="column">
                            <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" />  
                        </div>  
                        <div class="column2">
                            <input type="button" name="filter" id="filter" value="Filter" class="btn btn-info" />  
                        </div>
                    </div>
                    
                    <div class="member-account-table" id="transaction">
                        <table>
                            <tr>
                                <th>No</th>
                                <th>User ID</th>
                                <th>Transaction ID</th>
                                <th>Total Amount</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                            <?php
                                $query = "SELECT * FROM transtb ORDER BY date DESC";
                                $rs = $conn->query($query);
                                                
                                if ($rs->num_rows > 0){
                                    $num = 1;
                                    while($row = mysqli_fetch_assoc($rs)){
                                        echo "<tr>";
                                        echo "<td>" . $num . "</td>";
                                        echo "<td>" . $row["userID"] . "</td>";
                                        echo "<td>" . $row["transID"] . "</td>";
                                        echo "<td>" . $row["totalAmount"] . "</td>";
                                        $date = $row["date"];
                                        echo "<td>" . date("Y-m-d", strtotime($date)) . "</td>";
                                        echo "<td>" . date("H:i:s", strtotime($date)) . "</td>";
                                        echo "</tr>";
                                        $num++;
                                    }
                                } else{
                                    echo "<tr>";
                                        echo "<td colspan='6'>There is no transaction record.</td>";
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

<script>    
    $(document).ready(function(){  
        $.datepicker.setDefaults({  
            dateFormat: 'yy-mm-dd', 
            changeMonth: true,
            changeYear: true,
        });
         
        $(function(){
            $("#from_date").datepicker(); 
            $("#to_date").datepicker();
        });  
        $('#filter').click(function(){  
            var from_date = $('#from_date').val();  
            var to_date = $('#to_date').val();  
            if(from_date != '' && to_date != ''){  
                $.ajax({  
                    url:"summary-transaction-record-filter.php",  
                    method:"POST",  
                    data:{from_date:from_date, to_date:to_date},  
                    success:function(data){
                        $('#transaction').html(data);  
                    }  
                });  
            }  
            else{  
                alert("Please Select Date");  
            }  
        });  
    });  
</script>