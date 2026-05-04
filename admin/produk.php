<?php
include 'header.php';
include '../config/koneksi.php';

$data = mysqli_query($koneksi, "SELECT * FROM produk");
?>

<style>
body {
    background: linear-gradient(135deg, #3e1f0d, #8b5e34);
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
}

/* WRAPPER */
.main-box {
    background: rgba(248,245,240,0.95);
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.3);
}

/* TITLE */
.title {
    color: #5a3e2b;
    font-weight: bold;
}

/* TABLE */
.table {
    background: white;
    border-radius: 15px;
    overflow: hidden;
}

.table thead {
    background: #5a3e2b;
    color: white;
}

/* IMAGE */
.img-produk {
    border-radius: 10px;
}

/* BUTTON */
.btn-primary {
    background: #c89b3c;
    border: none;
    font-weight: bold;
}

.btn-primary:hover {
    background: #a67c2b;
}

.btn-warning {
    background: #e0b84c;
    border: none;
}

.btn-danger {
    background: #8b2c2c;
    border: none;
}

/* TABLE ROW */
.table tbody tr:hover {
    background: #f9f3e8;
}
</style>

<div class="container mt-4">

<div class="main-box">

<h3 class="title mb-3">📦 Data Produk</h3>
<hr>

<a href="tambah_produk.php" class="btn btn-primary mb-3">
    + Tambah Produk
</a>

<table class="table table-bordered align-middle">

<thead>
<tr>
<th>No</th>
<th>Gambar</th>
<th>Nama Produk</th>
<th>Harga</th>
<th>Stok</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

<?php 
$no = 1;
while($row = mysqli_fetch_array($data)){ 
?>

<tr>
<td><?php echo $no++; ?></td>

<td>
<img src="uploads/<?php echo $row['gambar']; ?>" width="80" class="img-produk">
</td>

<td><b><?php echo $row['nama_produk']; ?></b></td>
<td>Rp <?php echo number_format($row['harga']); ?></td>
<td><?php echo $row['stok']; ?></td>

<td>
   <a href="edit_produk.php?id=<?php echo $row['id_produk']; ?>"
      class="btn btn-warning btn-sm">Edit</a>

   <a href="hapus_produk.php?id=<?php echo $row['id_produk']; ?>"
      class="btn btn-danger btn-sm"
      onclick="return confirm('Yakin hapus produk ini?')">
      Hapus
   </a>
</td>

</tr>

<?php } ?>

</tbody>
</table>

</div>

</div>

<?php include 'footer.php'; ?>