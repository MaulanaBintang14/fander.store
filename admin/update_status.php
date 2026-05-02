<?php
include '../config/koneksi.php';

$id = $_GET['id'];
$status = $_GET['status'];

mysqli_query($koneksi,"
UPDATE pesanan SET status='$status'
WHERE id_pesanan='$id'
");

header("Location: pesanan.php");