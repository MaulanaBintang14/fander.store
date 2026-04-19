<?php
session_start();
include '../config/koneksi.php';

$id_produk = $_POST['id_produk'];
$jumlah = $_POST['jumlah'];

// ambil produk
$data = mysqli_query($koneksi,"SELECT * FROM produk WHERE id_produk='$id_produk'");
$produk = mysqli_fetch_assoc($data);

// validasi stok
if(!$produk || $jumlah > $produk['stok']){
    echo "<script>
    alert('Stok tidak cukup');
    window.location='../detail_produk.php?id=$id_produk';
    </script>";
    exit;
}

// buat keranjang jika belum ada
if(!isset($_SESSION['keranjang'])){
    $_SESSION['keranjang'] = [];
}

// tambah produk
$_SESSION['keranjang'][$id_produk] = 
    ($_SESSION['keranjang'][$id_produk] ?? 0) + $jumlah;

echo "<script>
alert('Ditambahkan ke keranjang');
window.location='keranjang.php';
</script>";