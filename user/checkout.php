<?php 
session_start();
include '../config/koneksi.php';

// CEK LOGIN
if(!isset($_SESSION['user'])){
    echo "<script>alert('Silakan login'); window.location='login.php';</script>";
    exit;
}

// 🔥 AMBIL DATA BELANJA
if(isset($_SESSION['beli_sekarang'])){
    $keranjang = $_SESSION['beli_sekarang'];
} else {
    $keranjang = $_SESSION['keranjang'] ?? [];
}

// CEK KOSONG
if(empty($keranjang)){
    echo "<script>alert('Tidak ada produk'); window.location='../index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
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

/* INPUT */
.form-control {
    border-radius: 10px;
    border: 1px solid #d6c3a3;
}

/* PAYMENT */
.payment-box {
    border: 1px solid #d6c3a3;
    border-radius: 12px;
    padding: 12px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: 0.2s;
    background: white;
}

.payment-box:hover {
    border-color: #c89b3c;
    background: #fffaf2;
}

.payment-logo {
    height: 35px;
    margin-right: 10px;
}

/* CARD */
.card {
    border-radius: 15px;
    border: none;
}

/* BUTTON */
.btn-gold {
    background: #c89b3c;
    color: white;
    border-radius: 12px;
    font-weight: bold;
}

.btn-gold:hover {
    background: #a67c2b;
}

/* ALERT */
.alert {
    border-radius: 10px;
}
</style>
</head>

<body>

<div class="container mt-5">

<div class="main-box">

<h3 class="title mb-3">🧾 Checkout Pesanan</h3>
<hr>

<?php if(isset($_SESSION['beli_sekarang'])){ ?>
<div class="alert alert-info">
    Mode: Beli Langsung
</div>
<?php } ?>

<form method="POST" action="proses_checkout.php">

<!-- DATA PENERIMA -->
<h5 class="mt-3">Data Penerima</h5>

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
    <label>Detail Alamat</label>
    <textarea name="detail_alamat" class="form-control" required></textarea>
</div>

</div>

<div class="mb-3">
    <label>No HP</label>
    <input type="text" name="telepon" class="form-control" required>
</div>

<!-- METODE PEMBAYARAN -->
<h5 class="mt-4">Metode Pembayaran</h5>

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
    <div class="card-header fw-bold" style="background:#e6d3b3; color:#5a3e2b;">
        <?php echo $label; ?>
    </div>

    <div class="card-body">

        <?php while($m = mysqli_fetch_array($q)){ ?>

        <label class="payment-box d-flex align-items-center">
            <input type="radio" name="id_metode" value="<?php echo $m['id_metode']; ?>" required>

            <?php if(!empty($m['logo'])){ ?>
                <img src="../uploads/logo/<?php echo $m['logo']; ?>" class="payment-logo">
            <?php } ?>

            <div>
                <b><?php echo $m['nama_metode']; ?></b><br>

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

<div id="qris-box" style="display:none;" class="text-center mt-3">
    <h5>Scan QRIS</h5>
    <img src="../uploads/qris.png" width="250">
</div>

<hr>

<!-- RINCIAN -->
<h5>Rincian Belanja</h5>

<?php
$total = 0;

foreach($keranjang as $id => $qty){
    $q = mysqli_query($koneksi,"SELECT * FROM produk WHERE id_produk='$id'");
    $d = mysqli_fetch_array($q);

    $sub = $d['harga'] * $qty;
    $total += $sub;
?>

<p><b><?php echo $d['nama_produk']; ?></b> (<?php echo $qty; ?>)</p>

<?php } ?>

<h4 class="mt-3">Total: <span style="color:#c89b3c;">Rp <?php echo number_format($total); ?></span></h4>

<input type="hidden" name="total_belanja" value="<?php echo $total; ?>">

<button class="btn btn-gold mt-3 w-100">
    🚀 Checkout Sekarang
</button>

</form>

</div>

</div>

<script>
const radios = document.querySelectorAll('input[name="id_metode"]');
radios.forEach(r => {
    r.addEventListener('change', function(){
        let label = this.closest('.payment-box').innerText;
        document.getElementById('qris-box').style.display = label.includes('QRIS') ? 'block' : 'none';
    });
});
</script>

</body>
</html>