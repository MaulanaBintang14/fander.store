<?php
session_start();
include '../config/koneksi.php';

// CEK LOGIN
if(!isset($_SESSION['user'])){
    echo "<script>alert('Silakan login'); window.location='login.php';</script>";
    exit;
}

// CEK KERANJANG
if(!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])){
    echo "<script>alert('Keranjang masih kosong'); window.location='keranjang.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.payment-box {
    border: 1px solid #ddd;
    border-radius: 12px;
    padding: 12px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: 0.2s;
}

.payment-box:hover {
    border-color: #0d6efd;
    background: #f8f9fa;
}

.payment-box input {
    margin-right: 10px;
}

.payment-logo {
    height: 35px;
    margin-right: 10px;
}
</style>

</head>

<body>
<div class="container mt-4">

<h3>Checkout Pesanan</h3>
<hr>

<form method="POST" action="proses_checkout.php">

<!-- DATA PENERIMA -->
<div class="mb-3">
    <label>Nama Penerima</label>
    <input type="text" name="nama" class="form-control" required>
</div>

<div class="row">

<div class="col-md-6 mb-3">
    <label>Provinsi</label>
    <input type="text" name="provinsi" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
    <label>Kota / Kabupaten</label>
    <input type="text" name="kota" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
    <label>Kecamatan</label>
    <input type="text" name="kecamatan" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
    <label>Desa</label>
    <input type="text" name="desa" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
    <label>Kode Pos</label>
    <input type="text" name="kode_pos" class="form-control" required>
</div>

<div class="col-md-12 mb-3">
    <label>Detail Alamat (Jalan, RT/RW, dll)</label>
    <textarea name="detail_alamat" class="form-control" required></textarea>
</div>

</div>

<div class="mb-3">
    <label>No HP</label>
    <input type="text" name="telepon" class="form-control" required>
</div>

<!-- ================= METODE PEMBAYARAN ================= -->
<h5 class="mt-4">Pilih Pembayaran</h5>

<?php
$kategori = [
    'bank' => 'Transfer Bank',
    'ewallet' => 'E-Wallet',
    'qris' => 'QRIS',
    'cod' => 'COD'
];

foreach($kategori as $tipe => $label){

    $q = mysqli_query($koneksi, "SELECT * FROM metode_pembayaran WHERE tipe='$tipe'");

    if(mysqli_num_rows($q) > 0){
?>

<div class="card mb-3 shadow-sm">
    <div class="card-header fw-bold bg-light">
        <?php echo $label; ?>
    </div>

    <div class="card-body">

        <?php while($m = mysqli_fetch_array($q)){ ?>

        <label class="payment-box d-flex align-items-center">
            <input type="radio" name="id_metode"
                   value="<?php echo $m['id_metode']; ?>" required>

            <!-- LOGO -->
            <?php if(!empty($m['logo'])){ ?>
                <img src="../uploads/logo/<?php echo $m['logo']; ?>" class="payment-logo">
            <?php } ?>

            <div>
                <b><?php echo $m['nama_metode']; ?></b><br>

                <!-- INFO PEMBAYARAN -->
                <?php if($m['tipe'] != 'cod'){ ?>
                <small class="text-muted">
                    <?php echo $m['nomor']; ?> a.n <?php echo $m['atas_nama']; ?>
                </small>
                <?php } ?>
            </div>
        </label>

        <?php } ?>

    </div>
</div>

<?php } } ?>

<!-- QRIS AUTO MUNCUL -->
<div id="qris-box" style="display:none;" class="text-center mt-3">
    <h5>Scan QRIS</h5>
    <img src="../uploads/qris.png" width="250">
</div>

<hr>

<h5>Rincian</h5>

<?php
$total = 0;

foreach($_SESSION['keranjang'] as $id => $qty){
    $q = mysqli_query($koneksi,"SELECT * FROM produk WHERE id_produk='$id'");
    $d = mysqli_fetch_array($q);

    $sub = $d['harga'] * $qty;
    $total += $sub;
?>

<p><?php echo $d['nama_produk']; ?> (<?php echo $qty; ?>)</p>

<?php } ?>

<h4>Total: Rp <?php echo number_format($total); ?></h4>

<input type="hidden" name="total_belanja" value="<?php echo $total; ?>">

<button class="btn btn-success">Checkout</button>

</form>

</div>

<!-- SCRIPT QRIS -->
<script>
const radios = document.querySelectorAll('input[name="id_metode"]');

radios.forEach(r => {
    r.addEventListener('change', function(){
        let label = this.closest('.payment-box').innerText;

        if(label.includes('QRIS')){
            document.getElementById('qris-box').style.display = 'block';
        } else {
            document.getElementById('qris-box').style.display = 'none';
        }
    });
});
</script>

</body>
</html>