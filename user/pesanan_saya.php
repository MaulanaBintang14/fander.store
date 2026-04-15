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
.badge-status{
    padding:6px 10px;
    border-radius:8px;
    font-size:13px;
}
</style>
</head>

<body>
<div class="container mt-4">

<h3 class="mb-3">Pesanan Saya</h3>

<?php if(mysqli_num_rows($data) == 0){ ?>
    <div class="alert alert-info">
        Kamu belum memiliki pesanan.
    </div>
<?php } ?>

<table class="table table-hover align-middle">
<thead class="table-light">
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

    // Badge warna status
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

        <!-- DETAIL PESANAN -->
        <a href="detail_pesanan.php?id=<?php echo $d['id_pesanan']; ?>"
           class="btn btn-outline-primary btn-sm">
           Detail
        </a>

        <!-- TRANSFER → tombol upload muncul hanya jika metode Transfer dan status menunggu pembayaran -->
        <?php if($d['metode_pembayaran']=="Transfer" && $d['status']=="menunggu pembayaran"){ ?>
            <a href="upload_bukti.php?id=<?php echo $d['id_pesanan']; ?>"
               class="btn btn-success btn-sm">
               Upload Bukti
            </a>
        <?php } ?>

        <!-- COD → hanya tampil badge -->
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
</body>
</html>