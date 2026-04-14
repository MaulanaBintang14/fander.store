<?php
session_start();
include '../config/koneksi.php';

$id = $_GET['id'];

$p = mysqli_fetch_array(mysqli_query($koneksi,
"SELECT * FROM pesanan WHERE id_pesanan='$id'"));
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

<p><b>Nama:</b> <?php echo $p['nama_penerima']; ?></p>
<p><b>Alamat:</b> <?php echo $p['alamat']; ?></p>
<p><b>Telepon:</b> <?php echo $p['telepon']; ?></p>
<p><b>Metode:</b> <?php echo $p['metode_pembayaran']; ?></p>
<p><b>Status:</b> <?php echo $p['status']; ?></p>

<hr>

<h5>Produk</h5>

<table class="table table-bordered">
<tr>
    <th>Produk</th>
    <th>Jumlah</th>
    <th>Subtotal</th>
</tr>

<?php
$detail = mysqli_query($koneksi,
"SELECT detail_pesanan.*, produk.nama_produk
 FROM detail_pesanan
 JOIN produk ON detail_pesanan.id_produk = produk.id_produk
 WHERE id_pesanan='$id'");

while($d=mysqli_fetch_array($detail)){
?>
<tr>
    <td><?php echo $d['nama_produk']; ?></td>
    <td><?php echo $d['jumlah']; ?></td>
    <td>Rp <?php echo number_format($d['subtotal']); ?></td>
</tr>
<?php } ?>
</table>

<hr>

<?php if($p['metode_pembayaran']=="Transfer Bank"){ ?>

<h5>Bukti Pembayaran</h5>

<?php
$bukti = mysqli_fetch_array(mysqli_query($koneksi,
"SELECT * FROM pembayaran WHERE id_pesanan='$id'"));

if($bukti){
?>

<img src="../bukti/<?php echo $bukti['bukti']; ?>" width="300">

<br><br>

<a href="verifikasi.php?id=<?php echo $id; ?>"
   class="btn btn-success">Verifikasi Pembayaran</a>

<?php } else { ?>
<p>Belum ada bukti pembayaran</p>
<?php } ?>

<?php } else { ?>

<h5>Pesanan COD</h5>

<a href="update_status.php?id=<?php echo $id; ?>&status=diproses"
   class="btn btn-primary">
   Konfirmasi COD
</a>

<?php } ?>

<br><br>

<a href="pesanan.php" class="btn btn-secondary">Kembali</a>

</div>
</body>
</html>
