<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['user'])){
    echo "<pre>";
print_r($_SESSION);
echo "</pre>";
exit;

}

$id_user = $_SESSION['user']['id_user'];
$tanggal = date('Y-m-d H:i:s');

// Hitung total harga
$total_bayar = 0;

foreach($_SESSION['keranjang'] as $id_produk => $jumlah){

    $data = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'");
    $produk = mysqli_fetch_array($data);

    $subtotal = $produk['harga'] * $jumlah;
    $total_bayar += $subtotal;
}

// Ambil input dari form
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$telepon = $_POST['telepon'];
$metode = $_POST['metode'];

// INSERT KE TABEL PESANAN
$query = mysqli_query($koneksi,
"INSERT INTO pesanan
(id_user, tanggal, total_harga, status, metode_pembayaran, nama_penerima, alamat, telepon)
VALUES
('$id_user','$tanggal','$total_bayar','menunggu pembayaran','$metode','$nama','$alamat','$telepon')");

if($metode == "Transfer Bank"){
    $status = "menunggu pembayaran";
} else {
    $status = "menunggu konfirmasi admin";
}

mysqli_query($koneksi,
"INSERT INTO pesanan
(id_user, tanggal, total_harga, status, metode_pembayaran, nama_penerima, alamat, telepon)
VALUES
('$id_user','$tanggal','$total_bayar','$status','$metode','$nama','$alamat','$telepon')");


// Ambil id pesanan terakhir
$id_pesanan = mysqli_insert_id($koneksi);

// Simpan detail pesanan
foreach($_SESSION['keranjang'] as $id_produk => $jumlah){

    $data = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'");
    $produk = mysqli_fetch_array($data);

    $harga = $produk['harga'];
    $subtotal = $harga * $jumlah;

    mysqli_query($koneksi,
    "INSERT INTO detail_pesanan(id_pesanan, id_produk, jumlah, subtotal)
    VALUES('$id_pesanan','$id_produk','$jumlah','$subtotal')");

    // Kurangi stok
    mysqli_query($koneksi,
    "UPDATE produk SET stok = stok - $jumlah WHERE id_produk='$id_produk'");
}

// Kosongkan keranjang
unset($_SESSION['keranjang']);

echo "<script>
alert('Checkout berhasil! Silakan lakukan pembayaran');
window.location='http://localhost/fander_store/user/pesanan_saya.php';
</script>";

?>
