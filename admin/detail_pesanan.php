<?php
session_start();
include '../config/koneksi.php';

// Proteksi admin login
if(!isset($_SESSION['admin'])){
    header("location:login.php");
    exit;
}

// Ambil ID pesanan
$id = $_GET['id'] ?? 0;

// Ambil data pesanan
$ambil = mysqli_query($koneksi, "
    SELECT pesanan.*, pembayaran.bukti_transfer 
    FROM pesanan 
    LEFT JOIN pembayaran 
    ON pesanan.id_pesanan = pembayaran.id_pesanan
    WHERE pesanan.id_pesanan='$id'
");

if(mysqli_num_rows($ambil) == 0){
    echo "<script>alert('Pesanan tidak ditemukan'); window.location='pesanan.php';</script>";
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

<p><b>Nama:</b> <?php echo $p['nama_penerima']; ?></p>
<p><b>Alamat:</b> <?php echo $p['alamat']; ?></p>
<p><b>Telepon:</b> <?php echo $p['telepon']; ?></p>
<p><b>Metode:</b> <?php echo $p['metode_pembayaran']; ?></p>
<p><b>Status:</b> <?php echo ucfirst($p['status']); ?></p>

<hr>
<h5>Produk yang dipesan</h5>

<table class="table table-bordered">
<tr>
    <th>Produk</th>
    <th>Jumlah</th>
    <th>Subtotal</th>
</tr>

<?php
$detail = mysqli_query($koneksi,"
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

<?php if($p['metode_pembayaran']=="Transfer"){ ?>

<h5>Bukti Pembayaran</h5>

<?php if(!empty($p['bukti_transfer'])){ ?>
    <img src="../uploads/bukti/<?php echo $p['bukti_transfer']; ?>" 
         width="300" 
         class="img-thumbnail mb-3">

    <br>
    <a href="verifikasi.php?id=<?php echo $id; ?>" class="btn btn-success">
        Verifikasi Pembayaran
    </a>

<?php } else { ?>
    <div class="alert alert-warning">
        Belum ada bukti pembayaran
    </div>
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