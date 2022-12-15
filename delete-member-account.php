<?php

global $conn;

include_once 'dbconn.php';

$sql = "DELETE FROM myuser WHERE no='" . $_GET["id"] . "'";

if (mysqli_query($conn, $sql)) {
    echo '<script>alert("User deleted successfully")</script>';
    echo "<script> window.location = 'registered-member-account.php'</script>";
} else {
    echo "Error deleting course: " . mysqli_error($conn);
}

mysqli_close($conn);
?>