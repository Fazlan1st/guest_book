<?php 
session_start();
require '../function.php';
$sql = "DELETE FROM guests WHERE id='" . $_GET["id"] . "'";
if (mysqli_query($conn, $sql)) {
    echo "Record deleted successfully";
    header("Location: admin.php");
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

?>