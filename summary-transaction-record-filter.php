<?php
//filter.php
global $conn;  

if(isset($_POST["from_date"], $_POST["to_date"]))  
{  
    include "dbConnection.php";
    $output = '';  
    $query = "  
        SELECT * FROM transtb  
        WHERE date BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'  
    ";  
    $result = mysqli_query($conn, $query);  
    $output .= '  
        <table class="table table-bordered">  
            <tr>
                <th>No</th>  
                <th>User ID</th>  
                <th>Transaction ID</th>  
                <th>Total Amount</th>  
                <th>Date</th>
                <th>Time</th>  
            </tr>  
    ';  
    $num = 1;
    if(mysqli_num_rows($result) > 0){  
        while($row = mysqli_fetch_array($result)){
            $date = $row["date"];  
            $output .= '  
                <tr>
                    <td>'. $num .'</td>  
                    <td>'. $row["userID"] .'</td>  
                    <td>'. $row["transID"] .'</td>  
                    <td>'. $row["totalAmount"] .'</td>   
                    <td>'. date("Y-m-d", strtotime($date)) .'</td>
                    <td>'. date("H:i:s", strtotime($date)) .'</td>  
                </tr>  
            '; 
            $num++; 
        }  
    }  
    else{  
        $output .= '  
            <tr>  
                <td colspan="6">No Order Found</td>  
            </tr>  
        ';  
    }  
    $output .= '</table>';  
    echo $output;  
}  
?>