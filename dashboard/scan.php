<?php 
session_start();
include '../header.php';
?>

<div class="container">
<div class="position-absolute top-50 start-50 translate-middle">

    <h2>Scan QR Code</h2>
    <video id="preview" style="width: 100%; max-width: 500px;"></video>
    <input type="text" id="qrResult" placeholder="QR Code Result" hidden>
    
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script>
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    
        // Saat QR Code dipindai
        scanner.addListener('scan', function (content) {
            document.getElementById('qrResult').value = content; // Tampilkan hasil scan di input
    
            // Kirim data ID ke server via AJAX (POST)
            fetch('proses_scan.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'qr_data=' + encodeURIComponent(content) // Mengirimkan ID dari QR Code
            })
            .then(response => response.json()) // Pastikan response dalam format JSON
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);  // Tampilkan pesan sukses yang berisi nama tamu
                } else {
                    alert(data.message);  // Tampilkan pesan error
                }
            })
            .catch(error => alert("Error: " + error));
        });
    
        // Akses kamera
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]); // Pilih kamera pertama
            } else {
                console.error("No cameras found.");
                alert("Kamera tidak ditemukan!");
            }
        }).catch(function (e) {
            console.error(e);
            alert("Gagal mengakses kamera: " + e);
        });
    </script>
    <div>
        <a href="./panitia.php" class="btn btn-warning">Back</a>
    </div>
</div>
</div>




<?php 
include '../footer.php';
?>
