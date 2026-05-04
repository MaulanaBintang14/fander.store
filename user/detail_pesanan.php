<?php
session_start();
include '../config/koneksi.php';

$id = $_GET['id'];

// ================= PESANAN =================
$p = mysqli_fetch_assoc(mysqli_query($koneksi,"
SELECT p.*, m.nama_metode 
FROM pesanan p
LEFT JOIN metode_pembayaran m ON p.id_metode = m.id_metode
WHERE p.id_pesanan='$id'
"));

// ================= DETAIL =================
$d = mysqli_query($koneksi,"
SELECT dp.*, pr.nama_produk 
FROM detail_pesanan dp
LEFT JOIN produk pr ON dp.id_produk = pr.id_produk
WHERE dp.id_pesanan='$id'
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Detail Pesanan</title>
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

/* TABLE */
.table {
    background: white;
    border-radius: 15px;
    overflow: hidden;
}

.table thead {
    background: #5a3e2b;
    color: white;
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

/* ALERT */
.alert {
    border-radius: 12px;
}

/* IMAGE */
.img-preview {
    border-radius: 10px;
    margin-top: 10px;
}
</style>
</head>

<body>

<div class="container mt-5">

<div class="main-box">

<h3 class="title mb-3">📦 Detail Pesanan</h3>
<hr>

<p><b>Nama:</b> <?= $p['nama_penerima'] ?: '-' ?></p>
<p><b>Telepon:</b> <?= $p['telepon'] ?: '-' ?></p>

<p><b>Alamat:</b><br>
<?= $p['detail_alamat'] ?: '-' ?><br>
<?= $p['kecamatan'] ?>, <?= $p['kota'] ?><br>
<?= $p['provinsi'] ?><br>
Kode Pos: <?= $p['kode_pos'] ?>
</p>

<p><b>Metode:</b> <?= $p['nama_metode'] ?: '-' ?></p>
<p><b>Status:</b> <span style="color:#c89b3c;"><b><?= $p['status'] ?></b></span></p>

<hr>

<!-- ================= PREORDER ================= -->
<?php if(!empty($p['catatan'])){ ?>

<div class="alert alert-info">
<b>🛠 Pre Order</b><br><br>

<b>Catatan:</b><br>
<?= $p['catatan']; ?><br><br>

<?php if($p['file_custom']){ ?>
<img src="../uploads/custom/<?= $p['file_custom']; ?>" width="150" class="img-preview">
<?php } ?>

<?php if($p['biaya_tambahan'] > 0){ ?>
<hr>
<b>Biaya Custom:</b> Rp <?= number_format($p['biaya_tambahan']); ?>
<?php } ?>

</div>

<?php } ?>

<!-- ================= PRODUK ================= -->
<h5>Produk yang dipesan</h5>

<table class="table table-bordered">
<thead>
<tr>
    <th>Produk</th>
    <th>Jumlah</th>
    <th>Subtotal</th>
</tr>
</thead>

<tbody>
<?php while($x = mysqli_fetch_array($d)){ ?>
<tr>
<td><b><?= $x['nama_produk']; ?></b></td>
<td><?= $x['jumlah']; ?></td>
<td>Rp <?= number_format($x['subtotal']); ?></td>
</tr>
<?php } ?>
</tbody>
</table>

<hr>

<!-- ================= TOTAL ================= -->
<h4>Total: <span style="color:#c89b3c;">Rp <?= number_format($p['total_harga']); ?></span></h4>

<!-- ================= PEMBAYARAN ================= -->
<h5 class="mt-4">Pembayaran</h5>

<?php if(empty($p['bukti_pembayaran'])){ ?>

<div class="alert alert-warning">
Belum ada bukti pembayaran
</div>

<?php if($p['status'] == 'menunggu pembayaran'){ ?>
<a href="upload_bukti.php?id=<?= $p['id_pesanan']; ?>" class="btn btn-gold">
Upload Bukti Pembayaran
</a>
<?php } ?>

<?php } else { ?>

<img src="../uploads/bukti/<?= $p['bukti_pembayaran']; ?>" width="200" class="img-preview">

<?php } ?>

<br><br>

<a href="pesanan_saya.php" class="btn btn-outline-brown">
← Kembali
</a>

</div>

</div>

</body>
</html>