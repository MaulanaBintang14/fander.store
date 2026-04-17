<?php
session_start();
include 'config/koneksi.php';
?>

if(!isset($_SESSION['user'])){
    header("location:login.php");
    exit;
}

$id = $_GET['id'];

// ambil data pesanan + metode
$q = mysqli_query($koneksi,"
SELECT pesanan.*, metode_pembayaran.*
FROM pesanan
JOIN metode_pembayaran 
ON pesanan.id_metode = metode_pembayaran.id_metode
WHERE pesanan.id_pesanan='$id'
");

$d = mysqli_fetch_array($q);
?>

<!DOCTYPE html>
<html>
<head>
<title>Pembayaran</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.box {
    background:#f8f9fa;
    padding:20px;
    border-radius:12px;
}
</style>
</head>

<body>
<div class="container mt-4">

<h3>Instruksi Pembayaran</h3>
<hr>

<div class="box">

<h5>Total Bayar</h5>
<h3 class="text-danger">
Rp <?php echo number_format($d['total_harga']); ?>
</h3>

<hr>

<h5>Metode</h5>
<p>
<b><?php echo $d['nama_metode']; ?></b><br>
(<?php echo strtoupper($d['tipe']); ?>)
</p>

<?php if($d['tipe'] != 'qris'){ ?>

<p><b>Nomor Tujuan:</b><br>
<?php echo $d['nomor']; ?></p>

<p><b>Atas Nama:</b><br>
<?php echo $d['atas_nama']; ?></p>

<?php } ?>

<?php if($d['tipe'] == 'qris'){ ?>
<p>Scan QR berikut:</p>
<img src="../uploads/qris.png" width="200">
<?php } ?>

<hr>

<p class="text-muted">
Silakan lakukan pembayaran sesuai total di atas.
</p>

<a href="upload_bukti.php?id=<?php echo $d['id_pesanan']; ?>" 
   class="btn btn-success">
   Upload Bukti Pembayaran
</a>

<a href="pesanan_saya.php" class="btn btn-secondary">
   Lihat Pesanan
</a>

</div>

</div>
</body>
</html>