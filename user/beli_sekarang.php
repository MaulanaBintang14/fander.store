<?php
session_start();
include '../config/koneksi.php';

// CEK LOGIN
if(!isset($_SESSION['user'])){
    echo "<script>alert('Silakan login dulu'); window.location='login.php';</script>";
    exit;
}

// CEK ID PRODUK
if(!isset($_GET['id'])){
    echo "<script>alert('Produk tidak ditemukan'); window.location='../index.php';</script>";
    exit;
}

$id_produk = $_GET['id'];

// RESET KERANJANG (biar cuma 1 produk)
$_SESSION['keranjang'] = [];

// MASUKKAN PRODUK KE KERANJANG
$_SESSION['keranjang'][$id_produk] = 1;

// REDIRECT KE CHECKOUT
header("Location: checkout.php");
exit;
?>  