<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['user'])){
    echo "<script>
    alert('Silakan login terlebih dahulu');
    window.location='login.php';
    </script>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Keranjang Belanja</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #3e1f0d, #8b5e34);
    font-family: 'Segoe UI', sans-serif;
}

/* CONTAINER BOX */
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

/* BUTTON GOLD */
.btn-gold {
    background: #c89b3c;
    color: white;
    border-radius: 10px;
    font-weight: bold;
}

.btn-gold:hover {
    background: #a67c2b;
}

/* BUTTON OUTLINE */
.btn-outline-brown {
    border: 1px solid #5a3e2b;
    color: #5a3e2b;
    border-radius: 10px;
}

.alert {
    border-radius: 10px;
}
</style>
</head>

<body>

<div class="container mt-5">

<div class="main-box">

<h3 class="title mb-3">🛒 Keranjang Belanja</h3>
<hr>

<?php if(!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])){ ?>

<div class="alert alert-warning">
    Keranjang masih kosong
</div>

<a href="../index.php" class="btn btn-gold">Belanja Sekarang</a>

<?php } else { ?>

<table class="table table-bordered align-middle">
<thead>
<tr>
    <th>No</th>
    <th>Produk</th>
    <th>Harga</th>
    <th>Jumlah</th>
    <th>Total</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

<?php
$no = 1;
$total_belanja = 0;

foreach($_SESSION['keranjang'] as $id_produk => $jumlah){

    $data = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'");
    $d = mysqli_fetch_array($data);

    $total = $d['harga'] * $jumlah;
    $total_belanja += $total;
?>

<tr>
    <td><?php echo $no++; ?></td>
    <td><strong><?php echo $d['nama_produk']; ?></strong></td>
    <td>Rp <?php echo number_format($d['harga']); ?></td>
    <td><?php echo $jumlah; ?></td>
    <td><strong>Rp <?php echo number_format($total); ?></strong></td>
    <td>
        <a href="hapus_keranjang.php?id=<?php echo $id_produk; ?>" 
           class="btn btn-danger btn-sm">
            Hapus
        </a>
    </td>
</tr>

<?php } ?>

</tbody>

<tfoot>
<tr>
    <th colspan="4">Total Belanja</th>
    <th colspan="2" class="text-success">
        Rp <?php echo number_format($total_belanja); ?>
    </th>
</tr>
</tfoot>

</table>

<div class="d-flex justify-content-between mt-3">
    <a href="../index.php" class="btn btn-outline-brown">
        ← Lanjut Belanja
    </a>

    <a href="checkout.php" class="btn btn-gold">
        Checkout →
    </a>
</div>

<?php } ?>

</div>

</div>

</body>
</html>