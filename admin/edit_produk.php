<?php
session_start();
include '../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($koneksi,"SELECT * FROM produk WHERE id_produk='$id'");
$d = mysqli_fetch_array($data);

if(isset($_POST['update'])){

    $nama  = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok  = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];

    if($_FILES['gambar']['name'] != ""){

        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];

        move_uploaded_file($tmp, "uploads/".$gambar);

        mysqli_query($koneksi,
        "UPDATE produk SET
        id_kategori='$kategori',
        nama_produk='$nama',
        harga='$harga',
        stok='$stok',
        deskripsi='$deskripsi',
        gambar='$gambar'
        WHERE id_produk='$id'");

    } else {

        mysqli_query($koneksi,
        "UPDATE produk SET
        id_kategori='$kategori',
        nama_produk='$nama',
        harga='$harga',
        stok='$stok',
        deskripsi='$deskripsi'
        WHERE id_produk='$id'");
    }

    echo "<script>
    alert('Produk berhasil diupdate');
    window.location='produk.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Produk</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

<h3>Edit Produk</h3>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
    <label>Nama Produk</label>
    <input type="text" name="nama" class="form-control" 
    value="<?php echo $d['nama_produk']; ?>" required>
</div>

<div class="mb-3">
    <label>Kategori</label>
    <select name="kategori" class="form-control" required>

        <?php
        $kat = mysqli_query($koneksi, "SELECT * FROM kategori");
        while($k = mysqli_fetch_array($kat)){
        ?>
        <option value="<?php echo $k['id_kategori']; ?>"
        <?php if($k['id_kategori'] == $d['id_kategori']) echo "selected"; ?>>
            <?php echo $k['nama_kategori']; ?>
        </option>
        <?php } ?>

    </select>
</div>

<div class="mb-3">
    <label>Harga</label>
    <input type="number" name="harga" class="form-control"
    value="<?php echo $d['harga']; ?>" required>
</div>

<div class="mb-3">
    <label>Stok</label>
    <input type="number" name="stok" class="form-control"
    value="<?php echo $d['stok']; ?>" required>
</div>

<div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="deskripsi" class="form-control"><?php echo $d['deskripsi']; ?></textarea>
</div>

<div class="mb-3">
    <label>Gambar Sekarang</label><br>
    <img src="uploads/<?php echo $d['gambar']; ?>" width="150">
</div>

<div class="mb-3">
    <label>Ganti Gambar (opsional)</label>
    <input type="file" name="gambar" class="form-control">
</div>

<button name="update" class="btn btn-primary">Update</button>
<a href="produk.php" class="btn btn-secondary">Batal</a>

</form>

</div>
</body>
</html>
