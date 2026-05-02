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

<style>
.badge-status {
    font-size: 12px;
    padding: 6px 10px;
    border-radius: 8px;
}
</style>

</head>

<body>
<div class="container mt-4">

<h3>📦 Data Pesanan</h3>
<hr>

<table class="table table-bordered table-hover">
<thead class="table-dark">
<tr>
    <th>No</th>
    <th>Customer</th>
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

    <!-- NAMA -->
    <td><?= $d['nama'] ?? '-'; ?></td>

    <!-- TANGGAL -->
    <td><?= date('d M Y H:i', strtotime($d['tanggal'])); ?></td>

    <!-- TOTAL -->
    <td>
        <b class="text-success">
            Rp <?= number_format($d['total_harga']); ?>
        </b>
    </td>

    <!-- STATUS -->
    <td>
        <?php 
        if($d['status'] == 'menunggu pembayaran'){
            echo '<span class="badge bg-secondary badge-status">Menunggu Pembayaran</span>';
        } elseif($d['status'] == 'diproses'){
            echo '<span class="badge bg-info badge-status">Diproses</span>';
        } elseif($d['status'] == 'dikirim'){
            echo '<span class="badge bg-warning text-dark badge-status">Dikirim</span>';
        } elseif($d['status'] == 'selesai'){
            echo '<span class="badge bg-success badge-status">Selesai</span>';
        } else {
            echo '<span class="badge bg-dark badge-status">'.$d['status'].'</span>';
        }
        ?>
    </td>

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

        <!-- DETAIL -->
        <a href="detail_pesanan.php?id=<?= $d['id_pesanan']; ?>" 
           class="btn btn-sm btn-info mb-1">
           Detail
        </a>

        <!-- PREORDER -->
        <?php if(!empty($d['catatan'])){ ?>
            <a href="proses_preorder_admin.php?id=<?= $d['id_pesanan']; ?>" 
               class="btn btn-sm btn-warning mb-1">
               Proses PO
            </a>
        <?php } ?>

        <!-- FLOW STATUS -->
        <?php if($d['status']=="menunggu pembayaran"){ ?>
            <a href="update_status.php?id=<?= $d['id_pesanan']; ?>&status=diproses" 
               class="btn btn-success btn-sm mb-1">
               Proses
            </a>
        <?php } ?>

        <?php if($d['status']=="diproses"){ ?>
            <a href="update_status.php?id=<?= $d['id_pesanan']; ?>&status=dikirim" 
               class="btn btn-warning btn-sm mb-1">
               Kirim
            </a>
        <?php } ?>

        <?php if($d['status']=="dikirim"){ ?>
            <a href="update_status.php?id=<?= $d['id_pesanan']; ?>&status=selesai" 
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