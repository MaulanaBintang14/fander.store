<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['user'])){
    echo "<script>alert('Login dulu'); window.location='login.php';</script>";
    exit;
}

$id_user = $_SESSION['user']['id_user'];
$id_produk = $_POST['id_produk'];
$jumlah = $_POST['jumlah'];
$catatan = $_POST['catatan'];
$tanggal = date('Y-m-d H:i:s');

/* ================= UPLOAD OPSIONAL ================= */
$file_name = NULL;

if(isset($_FILES['file_custom']) && $_FILES['file_custom']['error'] == 0){

    $ext = pathinfo($_FILES['file_custom']['name'], PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','webp'];

    if(in_array(strtolower($ext), $allowed)){
        $file_name = time() . '_' . $_FILES['file_custom']['name'];

        move_uploaded_file(
            $_FILES['file_custom']['tmp_name'],
            '../uploads/custom/' . $file_name
        );
    }
}

/* ================= AMBIL PRODUK ================= */
$produk = mysqli_fetch_assoc(mysqli_query($koneksi,
"SELECT * FROM produk WHERE id_produk='$id_produk'"));

$subtotal = $produk['harga'] * $jumlah;

/* ================= INSERT PESANAN ================= */
mysqli_query($koneksi,"
INSERT INTO pesanan 
(id_user, tanggal, total_harga, status, 
nama_penerima, telepon,
provinsi, kota, kecamatan, desa, kode_pos, detail_alamat,
catatan, file_custom, biaya_tambahan)

VALUES
('$id_user','$tanggal','$subtotal','menunggu konfirmasi admin',
'','','','','','','','',
'$catatan','$file_name','0')
");

$id_pesanan = mysqli_insert_id($koneksi);

/* ================= 🔥 WAJIB: INSERT DETAIL ================= */
mysqli_query($koneksi,"
INSERT INTO detail_pesanan (id_pesanan, id_produk, jumlah, subtotal)
VALUES ('$id_pesanan','$id_produk','$jumlah','$subtotal')
");

/* ================= SELESAI ================= */
echo "<script>
alert('Pre Order berhasil, tunggu konfirmasi admin');
window.location='pesanan_saya.php';
</script>";