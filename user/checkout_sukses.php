<?php
session_start();
include '../config/koneksi.php';

// Proteksi login user
if(!isset($_SESSION['user'])){
    echo "<script>alert('Silakan login terlebih dahulu');window.location='login.php';</script>";
    exit;
}

$id_user = $_SESSION['user']['id_user'];

// Pastikan ada keranjang
if(!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])){
    echo "<script>alert('Keranjang masih kosong');window.location='keranjang.php';</script>";
    exit;
}

// Ambil data form
$nama   = $_POST['nama'];
$alamat = $_POST['alamat'];
$telepon= $_POST['telepon'];
$id_metode = $_POST['id_metode'];
$total_belanja = $_POST['total_belanja'];

// Tentukan metode dan status awal
$metode_query = mysqli_query($koneksi,"SELECT * FROM metode_pembayaran WHERE id_metode='$id_metode'");
$metode_data  = mysqli_fetch_assoc($metode_query);

$metode = $metode_data['nama_metode'];
$tipe   = $metode_data['tipe'];

$status = ($tipe == "COD") ? "menunggu konfirmasi admin" : "menunggu pembayaran";
$tanggal = date('Y-m-d H:i:s');

// Insert ke tabel pesanan
mysqli_query($koneksi,
"INSERT INTO pesanan 
(id_user, tanggal, total_harga, status, metode_pembayaran, nama_penerima, alamat, telepon)
VALUES
('$id_user','$tanggal','$total_belanja','$status','$metode','$nama','$alamat','$telepon')"
);

$id_pesanan = mysqli_insert_id($koneksi);

// Insert detail pesanan
foreach($_SESSION['keranjang'] as $id_produk => $jumlah){
    $produk_query = mysqli_query($koneksi,"SELECT * FROM produk WHERE id_produk='$id_produk'");
    $produk = mysqli_fetch_assoc($produk_query);

    $harga    = $produk['harga'];
    $subtotal = $harga * $jumlah;

    mysqli_query($koneksi,
    "INSERT INTO detail_pesanan
    (id_pesanan, id_produk, jumlah, harga, subtotal)
    VALUES('$id_pesanan','$id_produk','$jumlah','$harga','$subtotal')"
    );

    // Kurangi stok produk
    $stok_baru = $produk['stok'] - $jumlah;
    mysqli_query($koneksi,"UPDATE produk SET stok='$stok_baru' WHERE id_produk='$id_produk'");
}

// Kosongkan keranjang
unset($_SESSION['keranjang']);

// Redirect ke halaman sukses
echo "<script>
alert('Checkout berhasil! Silakan lakukan langkah berikut sesuai metode pembayaran.');
window.location='checkout_sukses.php';
</script>";
?>