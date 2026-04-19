<?php
session_start();
include '../config/koneksi.php';

$id = $_GET['id'] ?? 0;

/* ================= AMBIL DATA ================= */
$data = mysqli_fetch_assoc(mysqli_query($koneksi,"
SELECT * FROM pesanan WHERE id_pesanan='$id'
"));

if(!$data){
    echo "<script>alert('Data tidak ditemukan');window.location='pesanan.php';</script>";
    exit;
}

/* ================= PROSES SUBMIT ================= */
if(isset($_POST['biaya'])){

    $biaya = (int)$_POST['biaya'];
    $status = $_POST['status'];

    /* ================= 🔥 HITUNG ULANG TOTAL DARI DETAIL ================= */
    $q = mysqli_query($koneksi,"
    SELECT SUM(subtotal) as total_asli 
    FROM detail_pesanan 
    WHERE id_pesanan='$id'
    ");

    $row = mysqli_fetch_assoc($q);
    $total_asli = $row['total_asli'] ?? 0;

    $total_baru = $total_asli + $biaya;

    /* ================= UPDATE PESANAN ================= */
    mysqli_query($koneksi,"
    UPDATE pesanan SET
    biaya_tambahan='$biaya',
    total_harga='$total_baru',
    status='$status',
    notif_dibaca = 0
    WHERE id_pesanan='$id'
    ");

    /* ================= 🔔 INSERT NOTIF USER ================= */
    $id_user = $data['id_user'];

    $pesan_notif = "Pre Order kamu telah diproses admin. Total: Rp " . number_format($total_baru);

    mysqli_query($koneksi,"
    INSERT INTO notifikasi (id_user, id_pesanan, pesan, link, status)
    VALUES (
        '$id_user',
        '$id',
        '$pesan_notif',
        'detail_pesanan.php?id=$id',
        'unread'
    )
    ");

    echo "<script>
    alert('Preorder berhasil diproses');
    window.location='pesanan.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Proses Preorder</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

<h3>Konfirmasi Pre Order</h3>
<hr>

<!-- CATATAN -->
<p><b>Catatan User:</b><br><?= $data['catatan'] ?: '-' ?></p>

<!-- GAMBAR CUSTOM -->
<?php if(!empty($data['file_custom'])){ ?>
    <img src="../uploads/custom/<?= $data['file_custom']; ?>" 
         width="200" 
         class="mb-3 border rounded">
<?php } ?>

<hr>

<form method="POST">

    <label>Biaya Tambahan</label>
    <input type="number" name="biaya" class="form-control" required>

    <label class="mt-3">Status</label>
    <select name="status" class="form-control">
        <option value="menunggu pembayaran">Setujui</option>
        <option value="ditolak">Tolak</option>
    </select>

    <button class="btn btn-success mt-3">Simpan</button>

    <a href="pesanan.php" class="btn btn-secondary mt-3">Kembali</a>

</form>

</div>

</body>
</html>