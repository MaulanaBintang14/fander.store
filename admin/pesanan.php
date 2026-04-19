<?php
include '../config/koneksi.php';

$q = mysqli_query($koneksi,"
SELECT p.*, u.nama 
FROM pesanan p
LEFT JOIN users u ON p.id_user = u.id_user
ORDER BY p.id_pesanan DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Pesanan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-4">

<h3>Data Pesanan</h3>
<hr>

<table class="table table-bordered table-striped">
<thead>
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Tanggal</th>
    <th>Total</th>
    <th>Status</th>
    <th>Tipe</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

<?php 
$no=1; 
while($d=mysqli_fetch_array($q)){ 
?>

<tr>
    <td><?= $no++; ?></td>
    <td><?= $d['nama']; ?></td>
    <td><?= $d['tanggal']; ?></td>
    <td>Rp <?= number_format($d['total_harga']); ?></td>
    <td><?= $d['status']; ?></td>

    <!-- TIPE -->
    <td>
        <?php if(!empty($d['catatan'])){ ?>
            <span class="badge bg-warning text-dark">Pre Order</span>
        <?php } else { ?>
            <span class="badge bg-primary">Biasa</span>
        <?php } ?>
    </td>

    <!-- AKSI -->
    <td>

        <!-- DETAIL / PREORDER -->
        <?php if(!empty($d['catatan'])){ ?>
            <a href="proses_preorder_admin.php?id=<?= $d['id_pesanan']; ?>" 
               class="btn btn-sm btn-warning mb-1">
               Proses Preorder
            </a>
        <?php } else { ?>
            <a href="detail_pesanan.php?id=<?= $d['id_pesanan']; ?>" 
               class="btn btn-sm btn-info mb-1">
               Detail
            </a>
        <?php } ?>

        <!-- VERIFIKASI -->
        <?php if($d['status']=="menunggu verifikasi"){ ?>
            <a href="verifikasi_pembayaran.php?id=<?= $d['id_pesanan']; ?>" 
               class="btn btn-success btn-sm mb-1">
               Verifikasi
            </a>
        <?php } ?>

        <!-- KIRIM -->
        <?php if($d['status']=="diproses"){ ?>
            <a href="kirim_pesanan.php?id=<?= $d['id_pesanan']; ?>" 
               class="btn btn-warning btn-sm mb-1">
               Kirim
            </a>
        <?php } ?>

        <!-- SELESAI -->
        <?php if($d['status']=="dikirim"){ ?>
            <a href="selesai_pesanan.php?id=<?= $d['id_pesanan']; ?>" 
               class="btn btn-primary btn-sm mb-1">
               Selesai
            </a>
        <?php } ?>

    </td>
</tr>

<?php } ?>

</tbody>
</table>

</div>
</body>
</html>