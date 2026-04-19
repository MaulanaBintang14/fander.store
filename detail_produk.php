<?php
session_start();
include 'config/koneksi.php';

// CEK ID
if(!isset($_GET['id'])){
    echo "<script>
    alert('Produk tidak ditemukan');
    window.location='index.php';
    </script>";
    exit;
}

$id = $_GET['id'];

// AMANKAN QUERY
$id = mysqli_real_escape_string($koneksi, $id);

$data = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id'");
$produk = mysqli_fetch_assoc($data);

// CEK DATA
if(!$produk){
    echo "<script>
    alert('Produk tidak ditemukan');
    window.location='index.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $produk['nama_produk']; ?> - Fander Leather</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body {
    background-color: #f3e9dc;
}

.detail-container {
    background: white;
    border-radius: 20px;
    padding: 30px;
    margin-top: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.product-image {
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.price {
    font-size: 28px;
    font-weight: bold;
    color: #6b3e1a;
}

.stock {
    background: #f3e9dc;
    padding: 8px 15px;
    border-radius: 10px;
    display: inline-block;
}

.btn-custom {
    background: #6b3e1a;
    color: white;
}

.btn-custom:hover {
    background: #8b5a2b;
    color: white;
}
</style>

</head>

<body>

<div class="container">

<div class="detail-container">

<div class="row">

    <!-- GAMBAR -->
    <div class="col-md-5 text-center">
        <img src="admin/uploads/<?= $produk['gambar']; ?>" 
             class="img-fluid product-image">
    </div>

    <!-- DETAIL -->
    <div class="col-md-7">

        <h2><?= $produk['nama_produk']; ?></h2>
        <hr>

        <p class="price">
            Rp <?= number_format($produk['harga']); ?>
        </p>

        <p class="stock">
            <i class="fa fa-box"></i>
            Stok Tersedia: <?= $produk['stok']; ?>
        </p>

        <hr>

        <h5>Deskripsi Produk</h5>
        <p><?= nl2br($produk['deskripsi']); ?></p>

        <hr>

        <?php if($produk['stok'] > 0){ ?>

        <!-- FORM KERANJANG -->
        <form method="POST" action="user/tambah_keranjang.php">

            <input type="hidden" name="id_produk" value="<?= $produk['id_produk']; ?>">

            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="jumlah" class="form-control" 
                       value="1" min="1" max="<?= $produk['stok']; ?>" required>
            </div>

            <button class="btn btn-warning w-100 mb-2" name="keranjang">
                <i class="fa fa-shopping-cart"></i> Tambah ke Keranjang
            </button>

        </form>

        <!-- BELI SEKARANG (FIXED) -->
        <a href="user/beli_sekarang.php?id=<?= $produk['id_produk']; ?>" 
           class="btn btn-success w-100 mb-2">
            <i class="fa fa-bolt"></i> Beli Sekarang
        </a>

        <?php } else { ?>

        <button class="btn btn-secondary w-100 mb-2" disabled>
            Stok Habis
        </button>

        <?php } ?>

        <!-- PRE ORDER -->
        <a href="user/preorder.php?id=<?= $produk['id_produk']; ?>" 
           class="btn btn-custom w-100">
            <i class="fa fa-paint-brush"></i> Pesan Custom / Pre Order
        </a>

    </div>

</div>

<hr>

<a href="index.php" class="btn btn-secondary">
    <i class="fa fa-arrow-left"></i> Kembali
</a>

</div>

</div>

</body>
</html>