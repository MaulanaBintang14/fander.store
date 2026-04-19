<?php
include '../config/koneksi.php';

$id = $_GET['id'];

if(isset($_POST['kirim'])){

    $resi = $_POST['resi'];

    mysqli_query($koneksi,"
    UPDATE pesanan SET
    biaya_tambahan='$biaya',
    total_harga='$total_baru',
    status='$status',
    notif_dibaca = 0
    WHERE id_pesanan='$id'
    ");

    echo "<script>
    alert('Pesanan dikirim');
    window.location='pesanan.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Kirim Pesanan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-4">

<h4>Input Resi</h4>

<form method="post">
    <input type="text" name="resi" class="form-control mb-3" placeholder="Masukkan nomor resi" required>
    <button class="btn btn-warning" name="kirim">Kirim Barang</button>
</form>

</div>
</body>
</html>