<?php
include 'header.php';
include '../config/koneksi.php';

$data = mysqli_query($koneksi, "SELECT * FROM produk");
?>

<h3>Data Produk</h3>
<hr>

<a href="tambah_produk.php" class="btn btn-primary mb-3">Tambah Produk</a>

<table class="table table-bordered">
<tr>
<th>No</th>
<th>Gambar</th>
<th>Nama Produk</th>
<th>Harga</th>
<th>Stok</th>
<th>Aksi</th>
</tr>

<?php 
$no = 1;
while($row = mysqli_fetch_array($data)){ 
?>

<tr>
<td><?php echo $no++; ?></td>

<td>
<img src="uploads/<?php echo $row['gambar']; ?>" width="80">
</td>

<td><?php echo $row['nama_produk']; ?></td>
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

</table>

<?php include 'footer.php'; ?>
