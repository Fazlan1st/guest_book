<?php
session_start();
include '../function.php';

if (isset($_GET['id'])) {
    $status_id = $_GET['id'];

    $query = "DELETE FROM tstatus WHERE id = '$status_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='hadir.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data: " . mysqli_error($conn) . "');</script>";
    }
}
?>
