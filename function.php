<?php

require 'vendor/autoload.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

$host = "localhost";
$user = "root";
$password = "";
$dbname = "guest_book";

$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Fungsi Generate QR Code
function generateQrCode($text, $filename) {
    $qrCode = QrCode::create($text)->setSize(200);
    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    $filePath = __DIR__ . "/qrcodes/" . $filename;
    file_put_contents($filePath, $result->getString());
    
    return $filename;
}

// Create (Tambah Data + Generate QR)
function addGuest($name, $email, $mobile) {
    global $conn;
    $query = "INSERT INTO guests (name, email, mobile) VALUES ('$name', '$email', '$mobile')";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $id = mysqli_insert_id($conn);
        
        $qrFilename = "guest_$id.png";
        
        // QR Code hanya berisi ID saja
        generateQrCode("$id", $qrFilename);

        // Simpan nama file QR di database
        $updateQuery = "UPDATE guests SET qr_code='$qrFilename' WHERE id=$id";
        mysqli_query($conn, $updateQuery);

        return $qrFilename;
    }
    return false;
}


// Read (Ambil Semua Data)
function getGuests() {
    global $conn;
    $query = "SELECT * FROM guests";
    return mysqli_query($conn, $query);
}

function getCheckInList() {
    global $conn;
    $query = "SELECT guests.name, guests.email, status.scan_time, status.status 
              FROM status 
              JOIN guests ON status.guest_id = guests.id 
              ORDER BY status.scan_time DESC";
    return mysqli_query($conn, $query);
}

function checkInGuest($qrData) {
    global $conn;
    
    date_default_timezone_set('Asia/Jakarta');
    // Query untuk mencari tamu berdasarkan ID
    $query = "SELECT id, name FROM guests WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $qrData); // Gunakan parameter tipe integer
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Cek apakah tamu ditemukan
    if ($row = mysqli_fetch_assoc($result)) {
        $guest_id = $row['id'];
        $guest_name = $row['name'];  // Ambil nama tamu
        
        // Ambil waktu dan tanggal saat ini
        $current_time = date("H:i:s"); // Format waktu 24 jam
        $current_date = date("Y-m-d"); // Format tanggal YYYY-MM-DD
        
        // Simpan status tamu di tabel status
        $insertQuery = "INSERT INTO tstatus (guest_id, status, time, date) VALUES (?, '1', ?, ?)";
        $stmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmt, "iss", $guest_id, $current_time, $current_date); // Gunakan parameter tipe string untuk time dan date
        $success = mysqli_stmt_execute($stmt);
        
        // Kembalikan response dengan nama tamu
        return $success 
            ? ["status" => "success", "message" => "Check-in berhasil untuk tamu: $guest_name"]
            : ["status" => "error", "message" => "Gagal menyimpan status"];
    } else {
        // Jika tidak ditemukan
        return ["status" => "error", "message" => "Tamu tidak ditemukan!"];
    }
}
// function registerUser ($username, $pass, $role) {
//     global $conn;

//     $hash = password_hash($pass, PASSWORD_BCRYPT);

//     $result = "INSERT INTO users (username, password, roles) VALUES ('$username', '$hash', $role)";
//     $conn->query($result);

// }


function loginUser ($username, $pass) {
    global $conn;

    $username = $conn->real_escape_string($username);

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if (!$result) {
        return ""; // Menampilkan error query jika gagal
    }

    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if(password_verify($pass, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['roles'] = $user['roles'];

            if($user['roles'] == 1) {
                header("location: dashboard/admin.php");
            } else {
                header("location: dashboard/panitia.php");
            }
            exit;
        } else {
            return "<script>alert('Username dan Password salah')</script>";
        }
    } else {
        return "<script>alert('Username dan Password salah')</script>";
    }
}

function updateGuest($id, $name, $email, $mobile) {
    global $conn;

    $query = "UPDATE guests SET
        name = '$name',
        email = '$email',
        mobile = '$mobile',
        WHERE id = '$id'";

        return mysqli_query($conn, $query);
}

function deleteGuest($id) {
    global $conn;
    
    // Query untuk menghapus data tamu
    $query = "DELETE FROM guests WHERE id = '$id'";
    
    if (mysqli_query($conn, $query)) {
        return true;  // Mengindikasikan berhasil menghapus
    } else {
        return false;  // Jika gagal menghapus
    }
}
?>