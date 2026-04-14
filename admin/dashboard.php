<?php
include 'header.php';
include '../config/koneksi.php';

// hitung statistik sederhana
$totalProduk = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM produk"));
$totalPesanan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan"));
$totalUser = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user"));
?>

<h3>Dashboard Admin</h3>
<hr>

<div class="row">

<!-- PRODUK -->
<div class="col-md-4">
<div class="card bg-primary text-white">
<div class="card-body">
    <h5>Manajemen Produk</h5>
    <p>Total Produk: <?php echo $totalProduk; ?></p>
    <a href="produk.php" class="btn btn-light btn-sm">Buka</a>
</div>
</div>
</div>

<!-- PESANAN -->
<div class="col-md-4">
<div class="card bg-success text-white">
<div class="card-body">
    <h5>Data Pesanan</h5>
    <p>Total Pesanan: <?php echo $totalPesanan; ?></p>
    <a href="pesanan.php" class="btn btn-light btn-sm">Buka</a>
</div>
</div>
</div>

<!-- USER -->
<div class="col-md-4">
<div class="card bg-warning text-white">
<div class="card-body">
    <h5>Data User</h5>
    <p>Total User: <?php echo $totalUser; ?></p>
    <a href="#" class="btn btn-light btn-sm">Buka</a>
</div>
</div>
</div>

</div>

<hr>

<h5>Status Pesanan Terbaru</h5>

<table class="table table-bordered">
<tr>
    <th>No</th>
    <th>Tanggal</th>
    <th>Nama</th>
    <th>Total</th>
    <th>Status</th>
</tr>

<?php
$no = 1;
$data = mysqli_query($koneksi,
"SELECT * FROM pesanan ORDER BY id_pesanan DESC LIMIT 5");

while($d = mysqli_fetch_array($data)){
?>
<tr>
    <td><?php echo $no++; ?></td>
    <td><?php echo $d['tanggal']; ?></td>
    <td><?php echo $d['nama_penerima']; ?></td>
    <td>Rp <?php echo number_format($d['total_harga']); ?></td>
    <td><?php echo $d['status']; ?></td>
</tr>
<?php } ?>

</table>

<?php include 'footer.php'; ?>
