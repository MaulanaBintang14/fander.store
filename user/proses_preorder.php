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

// ================= AMBIL INPUT =================
$id_produk = (int)($_POST['id_produk'] ?? 0);
$jumlah = (int)($_POST['jumlah'] ?? 0);
$catatan = $_POST['catatan'] ?? '';

// VALIDASI DASAR
if($id_produk <= 0 || $jumlah <= 0){
    die("Data preorder tidak valid");
}

// ================= CEK PRODUK =================
$q = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'");
$produk = mysqli_fetch_assoc($q);

if(!$produk){
    die("Produk tidak ditemukan");
}

// ================= CEK STOK =================
if($jumlah > $produk['stok']){
    echo "<script>
    alert('Jumlah melebihi stok');
    window.location='../detail_produk.php?id=$id_produk';
    </script>";
    exit;
}

// ================= HITUNG HARGA =================
$harga = (int)$produk['harga'];
$subtotal = $harga * $jumlah;

if($subtotal <= 0){
    die("Subtotal preorder error");
}

// ================= UPLOAD FILE (OPSIONAL) =================
$file_name = NULL;

if(isset($_FILES['file_custom']) && $_FILES['file_custom']['error'] == 0){

    $ext = strtolower(pathinfo($_FILES['file_custom']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','webp'];

    if(in_array($ext, $allowed)){

        // buat nama file aman
        $file_name = 'custom_' . time() . '.' . $ext;

        move_uploaded_file(
            $_FILES['file_custom']['tmp_name'],
            '../uploads/custom/' . $file_name
        );
    }
}

// ================= INSERT PESANAN =================
$query = mysqli_query($koneksi,"
INSERT INTO pesanan 
(id_user, tanggal, total_harga, status, 
nama_penerima, telepon,
provinsi, kota, kecamatan, desa, kode_pos, detail_alamat,
catatan, file_custom, biaya_tambahan, notif_dibaca)

VALUES
('$id_user','$tanggal','$subtotal','menunggu konfirmasi admin',
'','','','','','','','',
'$catatan','$file_name','0','0')
");

if(!$query){
    die("Gagal insert pesanan: " . mysqli_error($koneksi));
}

$id_pesanan = mysqli_insert_id($koneksi);

// ================= INSERT DETAIL =================
mysqli_query($koneksi,"
INSERT INTO detail_pesanan (id_pesanan, id_produk, jumlah, subtotal)
VALUES ('$id_pesanan','$id_produk','$jumlah','$subtotal')
");

// ================= NOTIF USER =================
mysqli_query($koneksi,"
INSERT INTO notifikasi (id_user, id_pesanan, pesan, link, status)
VALUES (
'$id_user',
'$id_pesanan',
'Pre Order #$id_pesanan berhasil dibuat. Tunggu konfirmasi admin.',
'detail_pesanan.php?id=$id_pesanan',
'unread'
)
");

// ================= REDIRECT =================
echo "<script>
alert('Pre Order berhasil, tunggu konfirmasi admin');
window.location='pesanan_saya.php';
</script>";
?>