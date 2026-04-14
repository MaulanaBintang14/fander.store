<?php
include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query($koneksi,
"UPDATE pesanan SET status='diproses' WHERE id_pesanan='$id'");

echo "<script>
alert('Pembayaran berhasil diverifikasi');
window.location='pesanan.php';
</script>";
?>
