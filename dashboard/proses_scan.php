<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json");

include '../function.php'; // pastikan ini ada

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qr_data'])) {
    $qrData = $_POST['qr_data'];  // Ambil ID yang terkandung dalam QR Code

    // Cari tamu berdasarkan ID
    $response = checkInGuest($qrData);

    // Kembalikan response dalam bentuk JSON
    echo json_encode($response);
    exit;
}

echo json_encode(["status" => "error", "message" => "Invalid request"]);
?>
