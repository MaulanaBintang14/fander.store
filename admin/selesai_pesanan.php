<?php
include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query($koneksi,"
UPDATE pesanan 
SET status='selesai'
WHERE id_pesanan='$id'
");

echo "<script>
alert('Pesanan selesai');
window.location='pesanan.php';
</script>";
?>