<?php
include '../config/koneksi.php';

$id = $_GET['id'];
$status = $_GET['status'];

mysqli_query($koneksi,
"UPDATE pesanan SET status='$status' WHERE id_pesanan='$id'");

echo "<script>
alert('Status berhasil diupdate');
window.location='pesanan.php';
</script>";
?>
