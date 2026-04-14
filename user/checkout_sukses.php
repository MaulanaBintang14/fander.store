<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout Berhasil</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5 text-center">

<div class="alert alert-success">
    <h3>Checkout Berhasil!</h3>
    <p>
        Terima kasih sudah berbelanja di Fander Leather.
        Pesanan Anda sedang diproses oleh admin.
    </p>
</div>

<a href="../index.php" class="btn btn-primary">
    Kembali ke Beranda
</a>

<a href="pesanan_saya.php" class="btn btn-success">
    Lihat Pesanan Saya
</a>

</div>

</body>
</html>
