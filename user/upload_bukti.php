<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['user'])){
    header("location:login.php");
    exit;
}

$id_user = $_SESSION['user']['id_user'];
$id_pesanan = $_GET['id'] ?? 0;

// Validasi bahwa pesanan milik user
$cek = mysqli_query($koneksi,"
    SELECT * FROM pesanan 
    WHERE id_pesanan='$id_pesanan' 
    AND id_user='$id_user'
");

if(mysqli_num_rows($cek) == 0){
    echo "<script>alert('Pesanan tidak ditemukan'); location='pesanan_saya.php';</script>";
    exit;
}

if(isset($_POST['kirim'])){

    if(!isset($_FILES['bukti']) || $_FILES['bukti']['error'] != 0){
        echo "<script>alert('File tidak valid');</script>";
        exit;
    }

    $nama_file  = $_FILES['bukti']['name'];
    $tmp        = $_FILES['bukti']['tmp_name'];
    $ext        = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    $allowed    = ['jpg','jpeg','png'];

    if(!in_array($ext, $allowed)){
        echo "<script>alert('File harus JPG, JPEG atau PNG');</script>";
        exit;
    }

    $folder = "../uploads/bukti/";
    if(!is_dir($folder)){
        mkdir($folder, 0777, true);
    }

    $file_baru = time().'_'.$nama_file;

    if(move_uploaded_file($tmp, $folder.$file_baru)){

        $tanggal = date('Y-m-d H:i:s');

        // Hapus bukti lama jika ada
        mysqli_query($koneksi,"DELETE FROM pembayaran WHERE id_pesanan='$id_pesanan'");

        // Insert bukti baru
        mysqli_query($koneksi,"
            INSERT INTO pembayaran (id_pesanan, bukti_transfer, tanggal_bayar)
            VALUES ('$id_pesanan','$file_baru','$tanggal')
        ");

        // Update status pesanan menjadi menunggu verifikasi
        mysqli_query($koneksi,"
            UPDATE pesanan 
            SET status='menunggu verifikasi'
            WHERE id_pesanan='$id_pesanan'
        ");

        echo "<script>
            alert('Bukti pembayaran berhasil dikirim');
            window.location='pesanan_saya.php';
        </script>";
        exit;

    } else {
        echo "Upload gagal";
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Upload Bukti Pembayaran</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #3e1f0d, #8b5e34);
    font-family: 'Segoe UI', sans-serif;
}

/* BOX */
.main-box {
    background: #f8f5f0;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.3);
}

/* TITLE */
.title {
    color: #5a3e2b;
    font-weight: bold;
}

/* INPUT */
.form-control {
    border-radius: 10px;
    border: 1px solid #d6c3a3;
}

/* BUTTON */
.btn-gold {
    background: #c89b3c;
    color: white;
    border-radius: 10px;
    font-weight: bold;
}

.btn-gold:hover {
    background: #a67c2b;
}

.btn-outline-brown {
    border: 1px solid #5a3e2b;
    color: #5a3e2b;
    border-radius: 10px;
}

/* PREVIEW */
.preview-img {
    margin-top: 10px;
    max-width: 200px;
    border-radius: 10px;
    display: none;
}
</style>
</head>

<body>

<div class="container mt-5">

<div class="main-box">

<h4 class="title mb-3">📤 Upload Bukti Pembayaran</h4>
<hr>

<form method="post" enctype="multipart/form-data">

    <div class="mb-3">
        <label>Foto Bukti Transfer</label>
        <input type="file" name="bukti" id="bukti" class="form-control" accept="image/*" required>

        <!-- PREVIEW -->
        <img id="preview" class="preview-img">
    </div>

    <button class="btn btn-gold" name="kirim">
        Kirim Bukti
    </button>

    <a href="pesanan_saya.php" class="btn btn-outline-brown">
        Kembali
    </a>

</form>

</div>

</div>

<script>
document.getElementById('bukti').addEventListener('change', function(e){
    const file = e.target.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            const img = document.getElementById('preview');
            img.src = e.target.result;
            img.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
</script>

</body>
</html>