<?php
session_start();
include '../config/koneksi.php';

// Proteksi login admin
if(!isset($_SESSION['admin'])){
    echo "<script>alert('Silakan login sebagai admin'); window.location='login.php';</script>";
    exit;
}

$id = $_GET['id'] ?? 0;

// Validasi pesanan
$cek = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_pesanan='$id'");
if(mysqli_num_rows($cek) == 0){
    echo "<script>alert('Pesanan tidak ditemukan'); window.location='pesanan.php';</script>";
    exit;
}

// Update status menjadi diproses
mysqli_query($koneksi, "
    UPDATE pesanan 
    SET status='diproses'
    WHERE id_pesanan='$id'
");

echo "<script>
    alert('Pembayaran berhasil diverifikasi, status pesanan diproses');
    window.location='pesanan.php';
</script>";
?>