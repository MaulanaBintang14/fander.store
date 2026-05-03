<?php
include '../config/koneksi.php';

$id = $_GET['id'];
$status = $_GET['status'];

// VALIDASI STATUS
$allowed = [
    'menunggu pembayaran',
    'diproses',
    'dikirim',
    'selesai',
    'dibatalkan'
];

if(!in_array($status, $allowed)){
    die("Status tidak valid");
}

mysqli_query($koneksi,"
UPDATE pesanan SET status='$status'
WHERE id_pesanan='$id'
");

header("Location: pesanan.php");