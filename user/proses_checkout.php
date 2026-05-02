<?php
session_start();
include '../config/koneksi.php';

// ================= CEK LOGIN =================
if(!isset($_SESSION['user'])){
    echo "<script>alert('Login dulu'); window.location='login.php';</script>";
    exit;
}

$id_user = $_SESSION['user']['id_user'];
$tanggal = date('Y-m-d H:i:s');

// ================= AMBIL KERANJANG =================
$keranjang = [];

if(!empty($_SESSION['beli_sekarang'])){
    $keranjang = $_SESSION['beli_sekarang'];
} elseif(!empty($_SESSION['keranjang'])){
    $keranjang = $_SESSION['keranjang'];
}

if(empty($keranjang)){
    echo "<script>alert('Keranjang kosong'); window.location='../index.php';</script>";
    exit;
}

// ================= HITUNG TOTAL =================
$total_belanja = 0;

foreach($keranjang as $id_produk => $jumlah){

    $id_produk = (int)$id_produk;
    $jumlah = (int)$jumlah;

    if($id_produk <= 0 || $jumlah <= 0){
        continue;
    }

    $q = mysqli_query($koneksi, "SELECT harga FROM produk WHERE id_produk = $id_produk LIMIT 1");

    if(mysqli_num_rows($q) == 0){
        continue;
    }

    $produk = mysqli_fetch_assoc($q);
    $harga = (int)$produk['harga'];

    $subtotal = $harga * $jumlah;
    $total_belanja += $subtotal;
}

// VALIDASI TOTAL
if($total_belanja <= 0){
    echo "<script>alert('Total belanja tidak valid'); window.location='keranjang.php';</script>";
    exit;
}

// ================= METODE =================
$id_metode = $_POST['id_metode'] ?? 0;

$q_metode = mysqli_query($koneksi, "SELECT * FROM metode_pembayaran WHERE id_metode = $id_metode");
$metode = mysqli_fetch_assoc($q_metode);

if(!$metode){
    echo "<script>alert('Metode tidak valid'); window.history.back();</script>";
    exit;
}

$tipe = $metode['tipe'];

// ================= DATA USER =================
$nama = $_POST['nama'] ?? '';
$telepon = $_POST['telepon'] ?? '';
$provinsi = $_POST['provinsi'] ?? '';
$kota = $_POST['kota'] ?? '';
$kecamatan = $_POST['kecamatan'] ?? '';
$desa = $_POST['desa'] ?? '';
$kode_pos = $_POST['kode_pos'] ?? '';
$detail_alamat = $_POST['detail_alamat'] ?? '';

if(empty($nama) || empty($telepon)){
    echo "<script>alert('Nama & Telepon wajib diisi'); window.history.back();</script>";
    exit;
}

// ================= STATUS =================
$status = ($tipe == "cod")
    ? "menunggu konfirmasi admin"
    : "menunggu pembayaran";

// ================= INSERT PESANAN =================
$query = mysqli_query($koneksi,"
INSERT INTO pesanan
(id_user, tanggal, total_harga, status, id_metode,
nama_penerima, telepon,
provinsi, kota, kecamatan, desa, kode_pos, detail_alamat, notif_dibaca)
VALUES
('$id_user','$tanggal','$total_belanja','$status','$id_metode',
'$nama','$telepon',
'$provinsi','$kota','$kecamatan','$desa','$kode_pos','$detail_alamat','0')
");

if(!$query){
    die("ERROR INSERT PESANAN: " . mysqli_error($koneksi));
}

$id_pesanan = mysqli_insert_id($koneksi);

// ================= DETAIL =================
foreach($keranjang as $id_produk => $jumlah){

    $id_produk = (int)$id_produk;
    $jumlah = (int)$jumlah;

    $q = mysqli_query($koneksi, "SELECT harga FROM produk WHERE id_produk = $id_produk");
    $produk = mysqli_fetch_assoc($q);

    if(!$produk) continue;

    $harga = (int)$produk['harga'];
    $subtotal = $harga * $jumlah;

    mysqli_query($koneksi,"
    INSERT INTO detail_pesanan(id_pesanan,id_produk,jumlah,subtotal)
    VALUES('$id_pesanan','$id_produk','$jumlah','$subtotal')
    ");

    mysqli_query($koneksi,"
    UPDATE produk SET stok = stok - $jumlah 
    WHERE id_produk='$id_produk'
    ");
}

// ================= NOTIF =================
mysqli_query($koneksi,"
INSERT INTO notifikasi(id_user,id_pesanan,pesan,link,status)
VALUES(
'$id_user',
'$id_pesanan',
'Pesanan #$id_pesanan berhasil dibuat',
'user/detail_pesanan.php?id=$id_pesanan',
'unread'
)
");

// ================= CLEAR =================
unset($_SESSION['keranjang']);
unset($_SESSION['beli_sekarang']);

// ================= REDIRECT =================
echo "<script>
alert('Checkout berhasil!');
window.location='pesanan_saya.php';
</script>";
?>