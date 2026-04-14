<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['user'])){
    echo "<script>
    alert('Silakan login terlebih dahulu');
    window.location='../user/login.php';
    </script>";
    exit;
}

$id_produk = $_POST['id_produk'];
$jumlah = $_POST['jumlah'];

// Ambil data produk
$data = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'");
$produk = mysqli_fetch_array($data);

// Cek stok
if($jumlah > $produk['stok']){
    echo "<script>
    alert('Jumlah melebihi stok yang tersedia');
    window.location='../detail_produk.php?id=$id_produk';
    </script>";
    exit;
}

// Jika session keranjang belum ada
if(!isset($_SESSION['keranjang'])){
    $_SESSION['keranjang'] = [];
}

// Jika produk sudah ada di keranjang
if(isset($_SESSION['keranjang'][$id_produk])){
    $_SESSION['keranjang'][$id_produk] += $jumlah;
} else {
    $_SESSION['keranjang'][$id_produk] = $jumlah;
}

echo "<script>
alert('Produk berhasil ditambahkan ke keranjang');
window.location='keranjang.php';
</script>";

?>
