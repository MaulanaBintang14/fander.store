<?php
session_start();
include '../config/koneksi.php';

if(isset($_POST['simpan'])){

    $nama  = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok  = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    move_uploaded_file($tmp, "uploads/".$gambar);

    mysqli_query($koneksi,
    "INSERT INTO produk(id_kategori, nama_produk, harga, stok, deskripsi, gambar)
    VALUES('$kategori','$nama','$harga','$stok','$deskripsi','$gambar')");

    echo "<script>
    alert('Produk berhasil ditambahkan');
    window.location='produk.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Produk</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

<h3>Tambah Produk</h3>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
    <label>Nama Produk</label>
    <input type="text" name="nama" class="form-control" required>
</div>

<div class="mb-3">
    <label>Kategori</label>
    <select name="kategori" class="form-control" required>
        <option value="">-- Pilih Kategori --</option>

        <?php
        $data = mysqli_query($koneksi, "SELECT * FROM kategori");
        while($d = mysqli_fetch_array($data)){
        ?>
            <option value="<?php echo $d['id_kategori']; ?>">
                <?php echo $d['nama_kategori']; ?>
            </option>
        <?php } ?>

    </select>
</div>

<div class="mb-3">
    <label>Harga</label>
    <input type="number" name="harga" class="form-control" required>
</div>

<div class="mb-3">
    <label>Stok</label>
    <input type="number" name="stok" class="form-control" required>
</div>

<div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="deskripsi" class="form-control"></textarea>
</div>

<div class="mb-3">
    <label>Gambar Produk</label>
    <input type="file" name="gambar" class="form-control" required>
</div>

<button name="simpan" class="btn btn-primary">Simpan</button>
<a href="produk.php" class="btn btn-secondary">Batal</a>

</form>

</div>
</body>
</html>
