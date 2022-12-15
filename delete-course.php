<?php

global $conn;

include_once 'dbconn.php';

$sql = "DELETE FROM coursetb WHERE courseID='" . $_GET["id"] . "'";

if (mysqli_query($conn, $sql)) {
    echo '<script>alert("Course deleted successfully.")</script>';
    echo "<script> window.location = 'edit-courses.php'</script>";
} else {
    echo "Error deleting course: " . mysqli_error($conn);
}

mysqli_close($conn);
?>