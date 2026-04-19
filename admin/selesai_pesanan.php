<?php
include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query($koneksi,"
UPDATE pesanan SET
biaya_tambahan='$biaya',
total_harga='$total_baru',
status='$status',
notif_dibaca = 0
WHERE id_pesanan='$id'
");

echo "<script>
alert('Pesanan selesai');
window.location='pesanan.php';
</script>";
?>