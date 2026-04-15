<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['user'])){
    echo "<script>alert('Silakan login'); window.location='login.php';</script>";
    exit;
}

$id_user = $_SESSION['user']['id_user'];
$tanggal = date('Y-m-d H:i:s');

// Total belanja
$total_belanja = 0;
foreach($_SESSION['keranjang'] as $id_produk => $jumlah){
    $produk = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM produk WHERE id_produk='$id_produk'"));
    $subtotal = $produk['harga'] * $jumlah;
    $total_belanja += $subtotal;
}

// Ambil metode pembayaran
$id_metode = $_POST['id_metode'];
$metode_data = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM metode_pembayaran WHERE id_metode='$id_metode'"));
$metode = $metode_data['nama_metode'];
$tipe   = $metode_data['tipe'];

// Ambil data penerima
$nama   = $_POST['nama'];
$alamat = $_POST['alamat'];
$telepon= $_POST['telepon'];

// Status otomatis
$status = ($tipe=="COD") ? "menunggu konfirmasi admin" : "menunggu pembayaran";

// Insert pesanan
mysqli_query($koneksi,"
INSERT INTO pesanan
(id_user, tanggal, total_harga, status, id_metode, nama_penerima, alamat, telepon)
VALUES
('$id_user','$tanggal','$total_belanja','$status','$id_metode','$nama','$alamat','$telepon')
");

$id_pesanan = mysqli_insert_id($koneksi);

// Insert detail pesanan
foreach($_SESSION['keranjang'] as $id_produk => $jumlah){
    $produk = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM produk WHERE id_produk='$id_produk'"));
    $subtotal = $produk['harga'] * $jumlah;

    mysqli_query($koneksi,"
    INSERT INTO detail_pesanan(id_pesanan, id_produk, jumlah, subtotal)
    VALUES('$id_pesanan','$id_produk','$jumlah','$subtotal')
    ");

    // Kurangi stok
    mysqli_query($koneksi,"UPDATE produk SET stok = stok - $jumlah WHERE id_produk='$id_produk'");
}

// Kosongkan keranjang
unset($_SESSION['keranjang']);

echo "<script>
alert('Checkout berhasil! Silakan lanjutkan sesuai metode pembayaran.');
window.location='pesanan_saya.php';
</script>";
?>