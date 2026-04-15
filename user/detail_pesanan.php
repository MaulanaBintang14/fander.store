<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['user'])){
    header("location:login.php");
    exit;
}

$id_user = $_SESSION['user']['id_user'];
$id = $_GET['id'] ?? 0;

/* Validasi pesanan milik user dan join ke tabel pembayaran */
$ambil = mysqli_query($koneksi, "
    SELECT pesanan.*, pembayaran.bukti_transfer
    FROM pesanan
    LEFT JOIN pembayaran
    ON pesanan.id_pesanan = pembayaran.id_pesanan
    WHERE pesanan.id_pesanan='$id' AND pesanan.id_user='$id_user'
");

if(mysqli_num_rows($ambil) == 0){
    echo "<script>alert('Pesanan tidak ditemukan'); location='pesanan_saya.php';</script>";
    exit;
}

$p = mysqli_fetch_assoc($ambil);
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

<p><b>Tanggal:</b> <?php echo date('d M Y H:i', strtotime($p['tanggal'])); ?></p>
<p><b>Status:</b> <?php echo ucfirst($p['status']); ?></p>
<p><b>Total:</b> Rp <?php echo number_format($p['total_harga']); ?></p>
<p><b>Metode:</b> <?php echo $p['metode_pembayaran']; ?></p>

<hr>
<h5>Produk yang dipesan</h5>

<table class="table table-bordered">
<tr>
    <th>Produk</th>
    <th>Jumlah</th>
    <th>Subtotal</th>
</tr>

<?php
$detail = mysqli_query($koneksi, "
    SELECT dp.*, p.nama_produk 
    FROM detail_pesanan dp
    JOIN produk p ON dp.id_produk = p.id_produk
    WHERE dp.id_pesanan='$id'
");

while($d = mysqli_fetch_array($detail)){
?>
<tr>
    <td><?php echo $d['nama_produk']; ?></td>
    <td><?php echo $d['jumlah']; ?></td>
    <td>Rp <?php echo number_format($d['subtotal']); ?></td>
</tr>
<?php } ?>
</table>

<hr>
<h5>Bukti Pembayaran</h5>

<?php if(!empty($p['bukti_transfer']) && $p['metode_pembayaran']=="Transfer"){ ?>
    <img src="../uploads/bukti/<?php echo $p['bukti_transfer']; ?>" 
         width="300" 
         class="img-thumbnail">
<?php } elseif($p['metode_pembayaran']=="COD"){ ?>
    <div class="alert alert-info">
        Pesanan COD – tidak memerlukan upload bukti
    </div>
<?php } else { ?>
    <div class="alert alert-warning">
        Belum ada bukti pembayaran
    </div>
<?php } ?>

<br><br>
<a href="pesanan_saya.php" class="btn btn-secondary">Kembali</a>

</div>
</body>
</html>