<?php include 'config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Cara Order - Fander Leather</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    background:#f8f5f2;
    font-family: 'Segoe UI', sans-serif;
}

/* HERO */
.hero{
    background: linear-gradient(135deg,#3b2415,#8b5a2b);
    color:white;
    padding:60px 20px;
    border-radius:0 0 30px 30px;
    text-align:center;
}

/* STEP CARD */
.step{
    background:white;
    border-radius:15px;
    padding:25px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
    transition:0.3s;
}
.step:hover{
    transform:translateY(-5px);
}

.step-icon{
    font-size:30px;
    color:#8b5a2b;
}

/* PREORDER BOX */
.preorder{
    background:#fff3cd;
    border-left:5px solid #ffc107;
    padding:20px;
    border-radius:10px;
}

/* CTA */
.cta{
    background:#3b2415;
    color:white;
    padding:40px;
    border-radius:20px;
    text-align:center;
}
</style>
</head>

<body>

<div class="hero">
    <h1>Belanja Mudah di Fander Leather</h1>
    <p>Dari produk ready sampai custom desain sendiri</p>
</div>

<div class="container mt-5">

<h3 class="mb-4">Alur Pembelian</h3>

<div class="row g-4">

<div class="col-md-3">
<div class="step text-center">
<i class="fa fa-search step-icon"></i>
<h5 class="mt-3">Pilih Produk</h5>
<p>Cari produk terbaik sesuai kebutuhanmu</p>
</div>
</div>

<div class="col-md-3">
<div class="step text-center">
<i class="fa fa-shopping-cart step-icon"></i>
<h5 class="mt-3">Checkout</h5>
<p>Isi alamat & pilih metode pembayaran</p>
</div>
</div>

<div class="col-md-3">
<div class="step text-center">
<i class="fa fa-credit-card step-icon"></i>
<h5 class="mt-3">Pembayaran</h5>
<p>Transfer / E-wallet / QRIS / COD</p>
</div>
</div>

<div class="col-md-3">
<div class="step text-center">
<i class="fa fa-truck step-icon"></i>
<h5 class="mt-3">Pengiriman</h5>
<p>Pesanan dikirim ke alamatmu</p>
</div>
</div>

</div>

<!-- PREORDER -->
<div class="mt-5 preorder">
<h5>🔥 Pre Order (Custom Produk)</h5>
<p>
Ingin desain sendiri? Kamu bisa request:
</p>
<ul>
<li>Model jaket custom</li>
<li>Warna & bahan</li>
<li>Upload gambar referensi (opsional)</li>
</ul>

<p>
Admin akan konfirmasi harga + biaya tambahan sebelum kamu bayar.
</p>
</div>

<!-- CTA -->
<div class="mt-5 cta">
<h4>Siap Belanja?</h4>
<p>Temukan produk terbaik sekarang</p>
<a href="index.php" class="btn btn-warning">Belanja Sekarang</a>
</div>

</div>

</body>
</html>