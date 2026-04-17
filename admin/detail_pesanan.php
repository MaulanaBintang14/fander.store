<?php
session_start();
include '../config/koneksi.php';

// Proteksi admin
if(!isset($_SESSION['admin'])){
    header("location:login.php");
    exit;
}

$id = $_GET['id'] ?? 0;

/* 🔥 JOIN PESANAN + METODE + PEMBAYARAN */
$ambil = mysqli_query($koneksi, "
SELECT 
    p.*,
    m.nama_metode, m.tipe,
    pb.bukti_transfer
FROM pesanan p
LEFT JOIN metode_pembayaran m ON p.id_metode = m.id_metode
LEFT JOIN pembayaran pb ON p.id_pesanan = pb.id_pesanan
WHERE p.id_pesanan='$id'
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
<p><b>Telepon:</b> <?php echo $p['telepon']; ?></p>

<p><b>Alamat:</b><br>
<?php echo $p['detail_alamat']; ?><br>
<?php echo $p['desa']; ?>, <?php echo $p['kecamatan']; ?><br>
<?php echo $p['kota']; ?>, <?php echo $p['provinsi']; ?><br>
Kode Pos: <?php echo $p['kode_pos']; ?>
</p>

<p><b>Metode:</b> <?php echo $p['nama_metode']; ?> (<?php echo $p['tipe']; ?>)</p>
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
SELECT dp.*, pr.nama_produk 
FROM detail_pesanan dp 
JOIN produk pr ON dp.id_produk = pr.id_produk
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

<!-- 🔥 PEMBAYARAN -->
<h5>Pembayaran</h5>

<?php if($p['tipe'] == "cod"){ ?>

<div class="alert alert-info">
    COD - Bayar saat barang diterima
</div>

<a href="update_status.php?id=<?php echo $id; ?>&status=diproses" 
   class="btn btn-primary">
   Konfirmasi COD
</a>

<?php } else { ?>

<?php if(!empty($p['bukti_transfer'])){ ?>

    <img src="../uploads/bukti/<?php echo $p['bukti_transfer']; ?>" 
         width="300" 
         class="img-thumbnail mb-3">

    <br>

    <a href="verifikasi_pembayaran.php?id=<?php echo $id; ?>" 
       class="btn btn-success">
       Verifikasi Pembayaran
    </a>

    <a href="cetak_resi.php?id=<?php echo $id; ?>" 
        class="btn btn-dark">
        Download Resi (PDF)
    </a>

<?php } else { ?>

    <div class="alert alert-warning">
        Belum ada bukti pembayaran
    </div>

<?php } ?>

<?php } ?>

<br><br>
<a href="pesanan.php" class="btn btn-secondary">Kembali</a>

</div>
</body>
</html>