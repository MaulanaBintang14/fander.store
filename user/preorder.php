<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['user'])){
    echo "<script>alert('Login dulu'); window.location='login.php';</script>";
    exit;
}

$id_produk = $_GET['id'];

$produk = mysqli_fetch_assoc(mysqli_query($koneksi,
"SELECT * FROM produk WHERE id_produk='$id_produk'"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Pre Order</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-4">

<h3>Pre Order / Custom</h3>
<hr>

<div class="card p-3 mb-3">
    <h5><?= $produk['nama_produk']; ?></h5>
    <p>Harga dasar: Rp <?= number_format($produk['harga']); ?></p>
</div>

<form method="POST" action="proses_preorder.php" enctype="multipart/form-data">

<input type="hidden" name="id_produk" value="<?= $produk['id_produk']; ?>">

<label>Jumlah</label>
<input type="number" name="jumlah" class="form-control" required>

<label>Catatan Custom</label>
<textarea name="catatan" class="form-control"></textarea>

<label>Upload Desain (Opsional)</label>
<input type="file" name="file_custom" class="form-control">

<button class="btn btn-dark mt-3">
    Kirim Pre Order
</button>

</form>

</div>
</body>
</html>