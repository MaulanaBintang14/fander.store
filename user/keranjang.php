<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['user'])){
    echo "<script>
    alert('Silakan login terlebih dahulu');
    window.location='login.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Keranjang Belanja</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

<h3>Keranjang Belanja</h3>
<hr>

<?php if(!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])){ ?>

<div class="alert alert-warning">
    Keranjang masih kosong
</div>

<a href="../index.php" class="btn btn-primary">Belanja Sekarang</a>

<?php } else { ?>

<table class="table table-bordered">
<tr>
    <th>No</th>
    <th>Nama Produk</th>
    <th>Harga</th>
    <th>Jumlah</th>
    <th>Total</th>
    <th>Aksi</th>
</tr>

<?php
$no = 1;
$total_belanja = 0;

foreach($_SESSION['keranjang'] as $id_produk => $jumlah){

    $data = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'");
    $d = mysqli_fetch_array($data);

    $total = $d['harga'] * $jumlah;
    $total_belanja += $total;
?>

<tr>
    <td><?php echo $no++; ?></td>
    <td><?php echo $d['nama_produk']; ?></td>
    <td>Rp <?php echo number_format($d['harga']); ?></td>
    <td><?php echo $jumlah; ?></td>
    <td>Rp <?php echo number_format($total); ?></td>
    <td>
        <a href="hapus_keranjang.php?id=<?php echo $id_produk; ?>" 
           class="btn btn-danger btn-sm">
            Hapus
        </a>
    </td>
</tr>

<?php } ?>

<tr>
    <th colspan="4">Total Belanja</th>
    <th colspan="2">Rp <?php echo number_format($total_belanja); ?></th>
</tr>

</table>

<a href="../index.php" class="btn btn-secondary">
    Lanjut Belanja
</a>

<a href="checkout.php" class="btn btn-success">
    Checkout
</a>

<?php } ?>

</div>

</body>
</html>
