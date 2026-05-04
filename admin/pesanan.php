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
/* BACKGROUND */
body {
    background: linear-gradient(135deg, #3e1f0d, #8b5e34);
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
}

/* CONTAINER */
.container {
    background: rgba(248,245,240,0.95);
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.3);
}

/* TITLE */
h3 {
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
    background: #5a3e2b !important;
    color: white;
}

/* HOVER */
.table-hover tbody tr:hover {
    background-color: #f9f3e8;
}

/* BADGE */
.badge-status {
    font-size: 12px;
    padding: 6px 10px;
    border-radius: 8px;
}

/* ROW STATUS */
.row-menunggu { background-color: #fff8e1; }
.row-verifikasi { background-color: #e3f2fd; }
.row-batal { background-color: #fdecea; }

/* BUTTON */
.btn-info {
    background: #c89b3c;
    border: none;
    color: white;
}

.btn-info:hover {
    background: #a67c2b;
}

.btn-warning {
    background: #e0b84c;
    border: none;
}

.btn-success {
    background: #2e7d32;
    border: none;
}

.btn-primary {
    background: #5a3e2b;
    border: none;
}

.btn-danger {
    background: #8b2c2c;
    border: none;
}

.btn-secondary {
    background: #6c757d;
}

/* TEXT */
.text-muted {
    font-size: 12px;
}

/* BUTTON SPACING */
.btn-sm {
    margin-bottom: 3px;
}
</style>

</head>

<body>

<div class="container mt-4">

<h3 class="mb-3">📦 Data Pesanan</h3>
<hr>

<table class="table table-bordered table-hover align-middle">

<thead>
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

// WARNA ROW (TIDAK DIUBAH)
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

    <td><b><?= !empty($d['nama']) ? $d['nama'] : 'Guest'; ?></b></td>

    <td><?= date('d M Y H:i', strtotime($d['tanggal'])); ?></td>

    <td>
        <b style="color:#c89b3c;">
            Rp <?= number_format($d['total_harga']); ?>
        </b>
    </td>

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

    <td>
        <?php if(!empty($d['catatan'])){ ?>
            <span class="badge bg-warning text-dark">Pre Order</span>
        <?php } else { ?>
            <span class="badge bg-primary">Biasa</span>
        <?php } ?>
    </td>

    <td>

        <a href="detail_pesanan.php?id=<?= $d['id_pesanan']; ?>" 
           class="btn btn-info btn-sm">
           Detail
        </a>

        <?php if(!empty($d['catatan'])){ ?>
            <a href="proses_preorder_admin.php?id=<?= $d['id_pesanan']; ?>" 
               class="btn btn-warning btn-sm">
               Proses PO
            </a>
        <?php } ?>

        <?php if($d['status']=="menunggu pembayaran"){ ?>
            <span class="text-muted d-block">Menunggu user bayar</span>
        <?php } ?>

        <?php if($d['status']=="menunggu verifikasi"){ ?>
            <a href="update_status.php?id=<?= $d['id_pesanan']; ?>&status=diproses" 
               class="btn btn-success btn-sm">
               Verifikasi & Proses
            </a>
        <?php } ?>

        <?php if($d['status']=="diproses"){ ?>
            <span class="text-muted d-block">Sedang packing</span>

            <a href="form_resi.php?id=<?= $d['id_pesanan']; ?>" 
               class="btn btn-warning btn-sm">
               Input Resi
            </a>
        <?php } ?>

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