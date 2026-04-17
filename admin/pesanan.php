<?php
include '../config/koneksi.php';

$data = mysqli_query($koneksi,"SELECT * FROM pesanan ORDER BY id_pesanan DESC");
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

<table class="table table-bordered">
<tr>
    <th>No</th>
    <th>Tanggal</th>
    <th>Total</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php $no=1; while($d=mysqli_fetch_array($data)){ ?>

<tr>
    <td><?php echo $no++; ?></td>
    <td><?php echo $d['tanggal']; ?></td>
    <td>Rp <?php echo number_format($d['total_harga']); ?></td>
    <td><?php echo $d['status']; ?></td>

    <td>

        <!-- DETAIL -->
        <a href="detail_pesanan.php?id=<?php echo $d['id_pesanan']; ?>" 
           class="btn btn-info btn-sm">Detail</a>

        <!-- VERIFIKASI -->
        <?php if($d['status']=="menunggu verifikasi"){ ?>
        <a href="verifikasi_pembayaran.php?id=<?php echo $d['id_pesanan']; ?>" 
           class="btn btn-success btn-sm">Verifikasi</a>
        <?php } ?>

        <!-- KIRIM -->
        <?php if($d['status']=="diproses"){ ?>
        <a href="kirim_pesanan.php?id=<?php echo $d['id_pesanan']; ?>" 
           class="btn btn-warning btn-sm">Kirim</a>
        <?php } ?>

        <!-- SELESAI -->
        <?php if($d['status']=="dikirim"){ ?>
        <a href="selesai_pesanan.php?id=<?php echo $d['id_pesanan']; ?>" 
           class="btn btn-primary btn-sm">Selesai</a>
        <?php } ?>

    </td>
</tr>

<?php } ?>

</table>

</div>
</body>
</html>