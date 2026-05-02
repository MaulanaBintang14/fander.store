<?php
session_start();
include '../config/koneksi.php';

// ================= CEK LOGIN =================
if(!isset($_SESSION['user'])){
    echo "<script>
    alert('Silakan login dulu');
    window.location='login.php';
    </script>";
    exit;
}

// ================= AMBIL DATA =================
$id_produk = $_GET['id'] ?? 0;
$jumlah = $_GET['qty'] ?? 1;

// VALIDASI INPUT
$id_produk = (int)$id_produk;
$jumlah = (int)$jumlah;

if($id_produk <= 0){
    echo "<script>
    alert('Produk tidak valid');
    window.location='../index.php';
    </script>";
    exit;
}

if($jumlah <= 0){
    $jumlah = 1;
}

// ================= CEK PRODUK =================
$q = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'");
$produk = mysqli_fetch_assoc($q);

if(!$produk){
    echo "<script>
    alert('Produk tidak ditemukan');
    window.location='../index.php';
    </script>";
    exit;
}

// ================= CEK STOK =================
if($jumlah > $produk['stok']){
    echo "<script>
    alert('Stok tidak cukup');
    window.location='../detail_produk.php?id=$id_produk';
    </script>";
    exit;
}

// ================= SET SESSION KHUSUS =================
// ❗ INI YANG PALING PENTING (beda dari keranjang biasa)
$_SESSION['beli_sekarang'] = [
    $id_produk => $jumlah
];

// OPTIONAL: bersihkan keranjang biar tidak tabrakan
unset($_SESSION['keranjang']);

// ================= REDIRECT =================
header("Location: checkout.php");
exit;
?>