<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['user'])){
    header("location:login.php");
    exit;
}

$id_user = $_SESSION['user']['id_user'];

/* Ambil semua pesanan user */
$data = mysqli_query($koneksi,
"SELECT * FROM pesanan 
 WHERE id_user='$id_user' 
 ORDER BY id_pesanan DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Pesanan Saya</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #3e1f0d, #8b5e34);
    font-family: 'Segoe UI', sans-serif;
}

/* BOX UTAMA */
.main-box {
    background: #f8f5f0;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.3);
}

/* TITLE */
.title {
    color: #5a3e2b;
    font-weight: bold;
}

/* TABLE */
.table {
    background: white;
    border-radius: 15px;
    overflow: hidden;
}

.table thead {
    background: #5a3e2b;
    color: white;
}

/* STATUS BADGE */
.badge-status{
    padding:6px 12px;
    border-radius:10px;
    font-size:13px;
}

/* CUSTOM WARNA STATUS */
.bg-warning { background:#f1c40f !important; color:black; }
.bg-info { background:#3498db !important; }
.bg-primary { background:#5a3e2b !important; }
.bg-success { background:#27ae60 !important; }
.bg-dark { background:#2c2c2c !important; }

/* BUTTON */
.btn-gold {
    background: #c89b3c;
    color: white;
    border-radius: 10px;
    font-weight: bold;
}

.btn-gold:hover {
    background: #a67c2b;
}

.btn-outline-brown {
    border: 1px solid #5a3e2b;
    color: #5a3e2b;
    border-radius: 10px;
}

/* ALERT */
.alert {
    border-radius: 10px;
}
</style>
</head>

<body>

<div class="container mt-5">

<div class="main-box">

<h3 class="title mb-3">📦 Pesanan Saya</h3>

<?php if(mysqli_num_rows($data) == 0){ ?>
    <div class="alert alert-info">
        Kamu belum memiliki pesanan.
    </div>
<?php } ?>

<table class="table table-hover align-middle">
<thead>
<tr>
    <th>No</th>
    <th>Tanggal</th>
    <th>Total</th>
    <th>Metode</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>
<?php 
$no=1; 
while($d=mysqli_fetch_array($data)){ 

    $badge = "secondary";

    switch($d['status']){
        case "menunggu pembayaran": $badge="warning"; break;
        case "menunggu verifikasi": $badge="info"; break;
        case "diproses": $badge="primary"; break;
        case "dikirim": $badge="success"; break;
        case "selesai": $badge="dark"; break;
    }
?>

<tr>
    <td><?php echo $no++; ?></td>
    <td><?php echo date('d M Y', strtotime($d['tanggal'])); ?></td>
    <td><strong>Rp <?php echo number_format($d['total_harga']); ?></strong></td>
    <td><?php echo $d['metode_pembayaran']; ?></td>

    <td>
        <span class="badge bg-<?php echo $badge; ?> badge-status">
            <?php echo ucfirst($d['status']); ?>
        </span>
    </td>

    <td>

        <a href="detail_pesanan.php?id=<?php echo $d['id_pesanan']; ?>"
           class="btn btn-outline-brown btn-sm">
           Detail
        </a>

        <?php if($d['metode_pembayaran']=="Transfer" && $d['status']=="menunggu pembayaran"){ ?>
            <a href="upload_bukti.php?id=<?php echo $d['id_pesanan']; ?>"
               class="btn btn-gold btn-sm">
               Upload Bukti
            </a>
        <?php } ?>

        <?php if($d['metode_pembayaran']=="COD"){ ?>
            <span class="badge bg-secondary">
                COD - Menunggu Admin
            </span>
        <?php } ?>

    </td>
</tr>

<?php } ?>
</tbody>
</table>

</div>

</div>

</body>
</html>