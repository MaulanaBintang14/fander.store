<?php
include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk='$id'");

echo "<script>
alert('Produk berhasil dihapus');
window.location='produk.php';
</script>";
?>
