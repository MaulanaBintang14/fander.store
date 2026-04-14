<?php
session_start();

$id = $_GET['id'];

unset($_SESSION['keranjang'][$id]);

echo "<script>
alert('Produk berhasil dihapus dari keranjang');
window.location='keranjang.php';
</script>";
?>
