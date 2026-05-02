<?php
include 'header.php';
include '../config/koneksi.php';

/* =======================
   STATISTIK
======================= */
$totalProduk = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM produk"));
$totalPesanan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan"));
$totalUser = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM users"));

/* =======================
   STATUS COUNT
======================= */
$menunggu = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) as jml FROM pesanan WHERE status='menunggu pembayaran'"))['jml'];

$diproses = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) as jml FROM pesanan WHERE status='diproses'"))['jml'];

$dikirim = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) as jml FROM pesanan WHERE status='dikirim'"))['jml'];

$selesai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) as jml FROM pesanan WHERE status='selesai'"))['jml'];

/* =======================
   DATA TERBARU
======================= */
$data = mysqli_query($koneksi,"
SELECT * FROM pesanan 
ORDER BY id_pesanan DESC 
LIMIT 5
");
?>

<div class="container mt-4">

<h3 class="mb-4">Dashboard Admin</h3>

<!-- =======================
     CARD UTAMA
======================= -->
<div class="row g-4">

<div class="col-md-4">
<div class="card shadow border-0 rounded-4 p-4 text-white"
style="background: linear-gradient(135deg,#1e3c72,#2a5298);">
    <div class="d-flex justify-content-between">
        <div>
            <h6>Produk</h6>
            <h3><?= $totalProduk ?></h3>
        </div>
        <i class="fa fa-box fa-2x"></i>
    </div>
    <a href="produk.php" class="btn btn-light btn-sm mt-3">Kelola</a>
</div>
</div>

<div class="col-md-4">
<div class="card shadow border-0 rounded-4 p-4 text-white"
style="background: linear-gradient(135deg,#11998e,#38ef7d);">
    <div class="d-flex justify-content-between">
        <div>
            <h6>Pesanan</h6>
            <h3><?= $totalPesanan ?></h3>
        </div>
        <i class="fa fa-shopping-cart fa-2x"></i>
    </div>
    <a href="pesanan.php" class="btn btn-light btn-sm mt-3">Lihat</a>
</div>
</div>

<div class="col-md-4">
<div class="card shadow border-0 rounded-4 p-4 text-white"
style="background: linear-gradient(135deg,#f7971e,#ffd200);">
    <div class="d-flex justify-content-between">
        <div>
            <h6>User</h6>
            <h3><?= $totalUser ?></h3>
        </div>
        <i class="fa fa-users fa-2x"></i>
    </div>
</div>
</div>

</div>

<!-- =======================
     STATUS RINGKAS
======================= -->
<div class="row mt-4 g-3">

<div class="col-md-3">
<div class="card p-3 shadow-sm rounded-4 text-center">
<h6>Menunggu</h6>
<h4><?= $menunggu ?></h4>
</div>
</div>

<div class="col-md-3">
<div class="card p-3 shadow-sm rounded-4 text-center">
<h6>Diproses</h6>
<h4><?= $diproses ?></h4>
</div>
</div>

<div class="col-md-3">
<div class="card p-3 shadow-sm rounded-4 text-center">
<h6>Dikirim</h6>
<h4><?= $dikirim ?></h4>
</div>
</div>

<div class="col-md-3">
<div class="card p-3 shadow-sm rounded-4 text-center">
<h6>Selesai</h6>
<h4><?= $selesai ?></h4>
</div>
</div>

</div>

<!-- =======================
     TABEL PESANAN
======================= -->
<h5 class="mt-5 mb-3">Pesanan Terbaru</h5>

<div class="card shadow-sm border-0 rounded-4 p-3">
<table class="table align-middle">

<thead class="table-light">
<tr>
    <th>No</th>
    <th>Tanggal</th>
    <th>Nama</th>
    <th>Total</th>
    <th>Status</th>
</tr>
</thead>

<tbody>
<?php 
$no = 1; 
while($d = mysqli_fetch_array($data)){ 
?>
<tr>

<td><?= $no++ ?></td>

<td><?= date('d M Y H:i', strtotime($d['tanggal'])) ?></td>

<td><?= $d['nama_penerima'] ?: '-' ?></td>

<td>
<b>Rp <?= number_format($d['total_harga']) ?></b>
</td>

<td>
<?php
$status = $d['status'];

if($status == 'menunggu pembayaran'){
    echo '<span class="badge bg-warning text-dark">Menunggu</span>';
}
elseif($status == 'diproses'){
    echo '<span class="badge bg-info">Diproses</span>';
}
elseif($status == 'dikirim'){
    echo '<span class="badge bg-primary">Dikirim</span>';
}
elseif($status == 'selesai'){
    echo '<span class="badge bg-success">Selesai</span>';
}
else{
    echo '<span class="badge bg-secondary">'.$status.'</span>';
}
?>
</td>

</tr>
<?php } ?>
</tbody>

</table>
</div>

</div>

<?php include 'footer.php'; ?>