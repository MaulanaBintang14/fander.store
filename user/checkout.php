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

if(!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])){
    echo "<script>
    alert('Keranjang masih kosong');
    window.location='keranjang.php';
    </script>";
    exit;
}

$id_user = $_SESSION['user']['id_user'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

<h3>Checkout Pesanan</h3>
<hr>

<form method="POST" action="proses_checkout.php">

<div class="mb-3">
    <label>Nama Penerima</label>
    <input type="text" name="nama" class="form-control" required>
</div>

<div class="mb-3">
    <label>Alamat Lengkap</label>
    <textarea name="alamat" class="form-control" required></textarea>
</div>

<div class="mb-3">
    <label>No Telepon</label>
    <input type="text" name="telepon" class="form-control" required>
</div>

<div class="mb-3">
    <label>Metode Pembayaran</label>
    <select name="metode" class="form-control" required>
        <option value="Transfer Bank">Transfer Bank</option>
        <option value="COD">COD</option>
    </select>
</div>

<hr>

<h5>Rincian Pesanan</h5>

<table class="table table-bordered">
<tr>
    <th>Produk</th>
    <th>Harga</th>
    <th>Jumlah</th>
    <th>Total</th>
</tr>

<?php
$total_belanja = 0;

foreach($_SESSION['keranjang'] as $id_produk => $jumlah){

    $data = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'");
    $d = mysqli_fetch_array($data);

    $total = $d['harga'] * $jumlah;
    $total_belanja += $total;
?>

<tr>
    <td><?php echo $d['nama_produk']; ?></td>
    <td>Rp <?php echo number_format($d['harga']); ?></td>
    <td><?php echo $jumlah; ?></td>
    <td>Rp <?php echo number_format($total); ?></td>
</tr>

<?php } ?>

<tr>
    <th colspan="3">Total Bayar</th>
    <th>Rp <?php echo number_format($total_belanja); ?></th>
</tr>

</table>

<!-- KIRIM TOTAL BELANJA KE HALAMAN PROSES -->
<input type="hidden" name="total_belanja" value="<?php echo $total_belanja; ?>">

<button type="submit" class="btn btn-success">
    Konfirmasi Checkout
</button>

<a href="keranjang.php" class="btn btn-secondary">
    Kembali
</a>

</form>

</div>

</body>
</html>
