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
</head>
<body>
<div class="container mt-4">
<h4>Upload Bukti Pembayaran</h4>
<hr>

<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Foto Bukti Transfer</label>
        <input type="file" name="bukti" class="form-control" accept="image/*" required>
    </div>
    <button class="btn btn-primary" name="kirim">Kirim Bukti</button>
    <a href="pesanan_saya.php" class="btn btn-secondary">Kembali</a>
</form>

</div>
</body>
</html>