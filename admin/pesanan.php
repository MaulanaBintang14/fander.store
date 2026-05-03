<?php
include '../config/koneksi.php';

// QUERY DATA
$q = mysqli_query($koneksi,"
SELECT p.*, u.nama 
FROM pesanan p
LEFT JOIN users u ON p.id_user = u.id_user
ORDER BY p.id_pesanan DESC
");

if(!$q){
    die("Query error: " . mysqli_error($koneksi));
}
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

.table-hover tbody tr:hover {
    background-color: #f5f5f5;
}

/* Highlight kondisi penting */
.row-menunggu { background-color: #fff3cd; }
.row-verifikasi { background-color: #cfe2ff; }
.row-batal { background-color: #f8d7da; }

.btn-sm { margin-bottom: 3px; }
</style>

</head>

<body>
<div class="container mt-4">

<h3 class="mb-3">📦 Data Pesanan</h3>
<hr>

<table class="table table-bordered table-hover align-middle">
<thead class="table-dark">
<tr>
    <th>No</th>
    <th>Customer</th>
    <th>Tanggal</th>
    <th>Total</th>
    <th>Status</th>
    <th>Tipe</th>
    <th width="300">Aksi</th>
</tr>
</thead>

<tbody>

<?php 
$no = 1; 
while($d = mysqli_fetch_assoc($q)){ 

// WARNA ROW
$rowClass = '';
if($d['status'] == 'menunggu pembayaran'){
    $rowClass = 'row-menunggu';
}
if($d['status'] == 'menunggu verifikasi'){
    $rowClass = 'row-verifikasi';
}
if($d['status'] == 'dibatalkan'){
    $rowClass = 'row-batal';
}
?>

<tr class="<?= $rowClass; ?>">
    <td><?= $no++; ?></td>

    <!-- CUSTOMER -->
    <td><b><?= !empty($d['nama']) ? $d['nama'] : 'Guest'; ?></b></td>

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
        switch($d['status']){
            case 'menunggu pembayaran':
                echo '<span class="badge bg-secondary badge-status">Menunggu Pembayaran</span>';
                break;
            case 'menunggu verifikasi':
                echo '<span class="badge bg-primary badge-status">Verifikasi</span>';
                break;
            case 'diproses':
                echo '<span class="badge bg-info badge-status">Diproses</span>';
                break;
            case 'dikirim':
                echo '<span class="badge bg-warning text-dark badge-status">Dikirim</span>';
                break;
            case 'selesai':
                echo '<span class="badge bg-success badge-status">Selesai</span>';
                break;
            case 'dibatalkan':
                echo '<span class="badge bg-danger badge-status">Dibatalkan</span>';
                break;
            default:
                echo '<span class="badge bg-dark">'.$d['status'].'</span>';
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
           class="btn btn-info btn-sm">
           Detail
        </a>

        <!-- PREORDER -->
        <?php if(!empty($d['catatan'])){ ?>
            <a href="proses_preorder_admin.php?id=<?= $d['id_pesanan']; ?>" 
               class="btn btn-warning btn-sm">
               Proses PO
            </a>
        <?php } ?>

        <!-- MENUNGGU PEMBAYARAN -->
        <?php if($d['status']=="menunggu pembayaran"){ ?>
            <span class="text-muted d-block">Menunggu user bayar</span>
        <?php } ?>

        <!-- VERIFIKASI -->
        <?php if($d['status']=="menunggu verifikasi"){ ?>
            <a href="update_status.php?id=<?= $d['id_pesanan']; ?>&status=diproses" 
               class="btn btn-success btn-sm">
               Verifikasi & Proses
            </a>
        <?php } ?>

        <!-- DIPROSES -->
        <?php if($d['status']=="diproses"){ ?>
            <span class="text-muted d-block">Sedang packing</span>

            <a href="form_resi.php?id=<?= $d['id_pesanan']; ?>" 
               class="btn btn-warning btn-sm">
               Input Resi
            </a>
        <?php } ?>

        <!-- DIKIRIM -->
        <?php if($d['status']=="dikirim"){ ?>
            <span class="text-muted d-block">Dalam pengiriman</span>

            <a href="update_status.php?id=<?= $d['id_pesanan']; ?>&status=selesai" 
               class="btn btn-primary btn-sm">
               Selesai
            </a>

            <a href="update_status.php?id=<?= $d['id_pesanan']; ?>&status=diproses" 
               class="btn btn-secondary btn-sm">
               ← Kembali
            </a>
        <?php } ?>

        <!-- BATALKAN -->
        <?php if($d['status']!="selesai" && $d['status']!="dibatalkan"){ ?>
            <a href="update_status.php?id=<?= $d['id_pesanan']; ?>&status=dibatalkan"
               class="btn btn-danger btn-sm"
               onclick="return confirm('Yakin batalkan pesanan?')">
               Batalkan
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