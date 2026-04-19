<?php
session_start();
include '../config/koneksi.php';

// ================= LOGIN =================
if(!isset($_SESSION['user'])){
    echo "<script>alert('Login dulu'); window.location='login.php';</script>";
    exit;
}

$id_user = $_SESSION['user']['id_user'];
$tanggal = date('Y-m-d H:i:s');

// ================= AMBIL KERANJANG =================
$keranjang = $_SESSION['beli_sekarang'] ?? $_SESSION['keranjang'] ?? [];

if(empty($keranjang)){
    echo "<script>alert('Keranjang kosong'); window.location='../index.php';</script>";
    exit;
}

// ================= HITUNG TOTAL =================
$total_belanja = 0;

foreach($keranjang as $id_produk => $jumlah){

    $produk = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT harga FROM produk WHERE id_produk='$id_produk'"));

    if($produk){
        $total_belanja += $produk['harga'] * $jumlah;
    }
}

// DEBUG (hapus nanti kalau sudah normal)
// echo $total_belanja; die;

// ================= METODE =================
$id_metode = $_POST['id_metode'];
$metode = mysqli_fetch_assoc(mysqli_query($koneksi,
"SELECT * FROM metode_pembayaran WHERE id_metode='$id_metode'"));

$tipe = $metode['tipe'];

// ================= DATA =================
$nama = $_POST['nama'];
$telepon = $_POST['telepon'];
$provinsi = $_POST['provinsi'];
$kota = $_POST['kota'];
$kecamatan = $_POST['kecamatan'];
$desa = $_POST['desa'];
$kode_pos = $_POST['kode_pos'];
$detail_alamat = $_POST['detail_alamat'];

// ================= STATUS =================
$status = ($tipe == "cod")
    ? "menunggu konfirmasi admin"
    : "menunggu pembayaran";

// ================= INSERT PESANAN =================
mysqli_query($koneksi,"
INSERT INTO pesanan
(id_user, tanggal, total_harga, status, id_metode,
nama_penerima, telepon,
provinsi, kota, kecamatan, desa, kode_pos, detail_alamat)
VALUES
('$id_user','$tanggal','$total_belanja','$status','$id_metode',
'$nama','$telepon',
'$provinsi','$kota','$kecamatan','$desa','$kode_pos','$detail_alamat')
");

$id_pesanan = mysqli_insert_id($koneksi);

// ================= DETAIL =================
foreach($keranjang as $id_produk => $jumlah){

    $produk = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT * FROM produk WHERE id_produk='$id_produk'"));

    $subtotal = $produk['harga'] * $jumlah;

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
'Pesanan berhasil dibuat',
'detail_pesanan.php?id=$id_pesanan',
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