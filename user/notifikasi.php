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

/* CARD NOTIF */
.notif-card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* NOTIF BELUM DIBACA */
.unread {
    border-left: 5px solid #c89b3c;
    background: #fffaf2;
}

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

/* BADGE */
.badge-po {
    background: #e6d3b3;
    color: #5a3e2b;
}
</style>
</head>

<body>

<div class="container mt-5">

<div class="main-box">

<h3 class="title mb-3">🔔 Notifikasi</h3>
<hr>

<?php while($d = mysqli_fetch_assoc($q)){ ?>

<div class="card notif-card mb-3 <?= $d['notif_dibaca'] ? '' : 'unread'; ?>">
    <div class="card-body">

        <b>Pesanan #<?= $d['id_pesanan']; ?></b><br>

        <?php if(!empty($d['catatan'])){ ?>
            <span class="badge badge-po">Pre Order</span><br>
        <?php } ?>

        Status:
        <b><?= $d['status']; ?></b><br>

        Total:
        <b>Rp <?= number_format($d['total_harga']); ?></b><br>

        <a href="pesanan_saya.php" class="btn btn-sm btn-gold mt-2">
            Lihat Pesanan
        </a>

    </div>
</div>

<?php } ?>

</div>

</div>

</body>
</html>