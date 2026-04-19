<?php
include '../config/koneksi.php';

$id = $_GET['id'];

/* UPDATE STATUS PESANAN SAJA */
mysqli_query($koneksi,"
UPDATE pesanan SET
biaya_tambahan='$biaya',
total_harga='$total_baru',
status='$status',
notif_dibaca = 0
WHERE id_pesanan='$id'
");

echo "<script>
alert('Pembayaran berhasil diverifikasi');
window.location='pesanan.php';
</script>";
?>