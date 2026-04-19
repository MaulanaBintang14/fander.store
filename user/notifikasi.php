<?php
session_start();
include '../config/koneksi.php';

$id_user = $_SESSION['user']['id_user'];

$q = mysqli_query($koneksi,"
SELECT * FROM pesanan 
WHERE id_user='$id_user'
ORDER BY id_pesanan DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Notifikasi</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-4">

<h3>Notifikasi</h3>
<hr>

<?php while($d = mysqli_fetch_assoc($q)){ ?>

<div class="card mb-3 <?= $d['notif_dibaca'] ? '' : 'border-primary'; ?>">
    <div class="card-body">

        <b>Pesanan #<?= $d['id_pesanan']; ?></b><br>

        <?php if(!empty($d['catatan'])){ ?>
            <span class="badge bg-warning text-dark">Pre Order</span><br>
        <?php } ?>

        Status:
        <b><?= $d['status']; ?></b><br>

        Total:
        Rp <?= number_format($d['total_harga']); ?><br>

        <a href="pesanan_saya.php" class="btn btn-sm btn-primary mt-2">
            Lihat Pesanan
        </a>

    </div>
</div>

<?php } ?>

</div>
</body>
</html>

<?php
// AUTO READ
mysqli_query($koneksi,"
UPDATE pesanan SET notif_dibaca=1 
WHERE id_user='$id_user'
");
?>