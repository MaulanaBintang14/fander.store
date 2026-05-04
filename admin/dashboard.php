<?php
session_start();
include '../config/koneksi.php';

// CEK LOGIN ADMIN (JANGAN DIUBAH)
if(!isset($_SESSION['admin'])){
    header("location:login.php");
    exit;
}

/* ======================= */
$totalProduk = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM produk"));
$totalPesanan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan"));
$totalUser = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM users"));

$menunggu = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) as jml FROM pesanan WHERE status='menunggu pembayaran'"))['jml'];
$diproses = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) as jml FROM pesanan WHERE status='diproses'"))['jml'];
$dikirim = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) as jml FROM pesanan WHERE status='dikirim'"))['jml'];
$selesai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) as jml FROM pesanan WHERE status='selesai'"))['jml'];

$data = mysqli_query($koneksi,"SELECT * FROM pesanan ORDER BY id_pesanan DESC LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
:root {
    --gold:#d4af37;
    --dark:#2c1810;
    --brown:#44190c;
}

/* BACKGROUND */
body{
    background: linear-gradient(135deg,#c8956d,#6b3e1a,#44190c);
    font-family:'Segoe UI';
    opacity:0;
    animation:fadeIn .5s forwards;
}
@keyframes fadeIn{to{opacity:1;}}

/* NAVBAR USER STYLE */
.navbar{
    background: linear-gradient(135deg,var(--dark),var(--brown)) !important;
    box-shadow:0 8px 30px rgba(0,0,0,.4);
}

/* LOGO + TEXT */
.navbar-brand{
    font-weight:bold;
    font-size:1.6rem;
    color:var(--gold)!important;
    transition:.3s;
}
.navbar-brand:hover{
    transform:translateY(-2px);
}

.navbar-brand img{
    border:2px solid var(--gold);
    transition:.3s;
}
.navbar-brand:hover img{
    transform:scale(1.1);
}

/* MENU */
.nav-link{
    color:#eee!important;
    transition:.3s;
}
.nav-link:hover{
    color:var(--gold)!important;
    transform:translateY(-1px);
}

/* ACTIVE MENU */
.nav-link.active{
    color:var(--gold)!important;
    font-weight:bold;
}

/* BUTTON */
.btn-logout{
    background:linear-gradient(135deg,#8b2635,#a0394a);
    border:none;
}

/* CONTAINER */
.container-box{
    background:rgba(255,255,255,.9);
    border-radius:25px;
    padding:30px;
    margin-top:30px;
}

/* CARD */
.card{
    border:none;
    border-radius:20px;
    transition:.3s;
}
.card:hover{
    transform:translateY(-5px);
}

.card-produk{background:linear-gradient(135deg,#7a4b2c,#a47148);color:#fff;}
.card-pesanan{background:linear-gradient(135deg,#d4a437,#e6c15a);}
.card-user{background:linear-gradient(135deg,#3e1f0d,#6b3e26);color:#fff;}

.table thead{
    background:#5a3e2b;
    color:#fff;
}
</style>

</head>

<body>

<!-- 🔥 NAVBAR USER STYLE -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
<div class="container">

<a class="navbar-brand d-flex align-items-center" href="dashboard.php">
    <img src="../assets/images/logo.png" width="45" class="me-2 rounded-circle">
    Fander Leather
</a>

<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="nav">
<ul class="navbar-nav ms-auto align-items-center">

<li class="nav-item">
<a href="dashboard.php" class="nav-link">Dashboard</a>
</li>

<li class="nav-item">
<a href="produk.php" class="nav-link">Produk</a>
</li>

<li class="nav-item">
<a href="pesanan.php" class="nav-link">Pesanan</a>
</li>

<li class="nav-item ms-3">
<a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
</li>

</ul>
</div>

</div>
</nav>

<!-- CONTENT -->
<div class="container container-box">

<h3>Dashboard Admin</h3>

<div class="row g-4 mt-3">

<div class="col-md-4">
<div class="card card-produk p-4">
<h6>Produk</h6>
<h3><?= $totalProduk ?></h3>
</div>
</div>

<div class="col-md-4">
<div class="card card-pesanan p-4">
<h6>Pesanan</h6>
<h3><?= $totalPesanan ?></h3>
</div>
</div>

<div class="col-md-4">
<div class="card card-user p-4">
<h6>User</h6>
<h3><?= $totalUser ?></h3>
</div>
</div>

</div>

<h5 class="mt-5">Pesanan Terbaru</h5>

<div class="card p-3">
<table class="table">

<thead>
<tr>
<th>No</th>
<th>Tanggal</th>
<th>Nama</th>
<th>Total</th>
<th>Status</th>
</tr>
</thead>

<tbody>
<?php $no=1; while($d=mysqli_fetch_array($data)){ ?>
<tr>
<td><?= $no++ ?></td>
<td><?= date('d M Y H:i', strtotime($d['tanggal'])) ?></td>
<td><?= $d['nama_penerima'] ?: '-' ?></td>
<td><b>Rp <?= number_format($d['total_harga']) ?></b></td>
<td>
<?php
if($d['status']=='menunggu pembayaran') echo '<span class="badge bg-warning text-dark">Menunggu</span>';
elseif($d['status']=='diproses') echo '<span class="badge bg-info">Diproses</span>';
elseif($d['status']=='dikirim') echo '<span class="badge bg-primary">Dikirim</span>';
elseif($d['status']=='selesai') echo '<span class="badge bg-success">Selesai</span>';
?>
</td>
</tr>
<?php } ?>
</tbody>

</table>
</div>

</div>

<!-- 🔥 SCRIPT ANIMASI -->
<script>
const links = document.querySelectorAll('.nav-link');

links.forEach(link=>{
link.addEventListener('click',function(e){
    e.preventDefault();
    const href=this.getAttribute('href');

    document.body.style.opacity='0';

    setTimeout(()=>{
        window.location=href;
    },200);
});
});

// ACTIVE MENU
const current=window.location.pathname;
links.forEach(link=>{
if(current.includes(link.getAttribute('href'))){
link.classList.add('active');
}
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>