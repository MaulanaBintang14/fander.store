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
</head>

<body>

<div class="container mt-4">

<h3>Detail Pesanan</h3>
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
<p><b>Status:</b> <?= $p['status'] ?></p>

<hr>

<!-- ================= PREORDER INFO ================= -->
<?php if(!empty($p['catatan'])){ ?>

<div class="alert alert-info">
<b>🛠 Pre Order</b><br>

<b>Catatan:</b><br>
<?= $p['catatan']; ?><br><br>

<?php if($p['file_custom']){ ?>
<img src="../uploads/custom/<?= $p['file_custom']; ?>" width="150">
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
<tr>
    <th>Produk</th>
    <th>Jumlah</th>
    <th>Subtotal</th>
</tr>

<?php while($x = mysqli_fetch_array($d)){ ?>
<tr>
<td><?= $x['nama_produk']; ?></td>
<td><?= $x['jumlah']; ?></td>
<td>Rp <?= number_format($x['subtotal']); ?></td>
</tr>
<?php } ?>

</table>

<hr>

<!-- ================= TOTAL ================= -->
<h4>Total: Rp <?= number_format($p['total_harga']); ?></h4>

<!-- ================= PEMBAYARAN ================= -->
<h5>Pembayaran</h5>

<?php if(empty($p['bukti_pembayaran'])){ ?>

<div class="alert alert-warning">
Belum ada bukti pembayaran
</div>

<?php if($p['status'] == 'menunggu pembayaran'){ ?>
<a href="upload_bukti.php?id=<?= $p['id_pesanan']; ?>" class="btn btn-primary">
Upload Bukti Pembayaran
</a>
<?php } ?>

<?php } else { ?>

<img src="../uploads/bukti/<?= $p['bukti_pembayaran']; ?>" width="200">

<?php } ?>

<br><br>

<a href="pesanan_saya.php" class="btn btn-secondary">Kembali</a>

</div>

</body>
</html>