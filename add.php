<?php 
include_once('./header.php');
include './function.php';
$qrFilename = ''; // Deklarasikan variabel lebih awal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qrFilename = addGuest($_POST['name'], $_POST['email'], $_POST['mobile']); // Dapatkan nama QR Code

    if (!$qrFilename) {
        echo "Gagal menambahkan data!";
    }
}
?>
<div class="container mt-5">
        <div class="position-absolute top-50 start-50 translate-middle">
            <form action="" method="POST">
                <input type="text" class="form-control mb-2" name="name" placeholder="Yourname" required>
                <input type="email" class="form-control mb-2" name="email" placeholder="Email" required>
                <input type="text" class="form-control mb-2" name="mobile" placeholder="Phone Number" required>
                <button class="btn btn-primary" type="submit">Register</button>
            </form>
            <?php if ($qrFilename): ?>
                <img src="./qrcodes/<?php echo $qrFilename; ?>" width="200">
                <a href="./qrcodes/<?php echo $qrFilename; ?>" download="qr_code.png" class="btn btn-success mt-2">Unduh QR Code</a>
                <?php endif; ?>
                <div>
                    <a href="./index.php" class="btn btn-warning">Back</a>
                </div>
            </div>
</div>

<?php 
include_once('./footer.php');
?>