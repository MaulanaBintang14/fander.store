<?php
include 'header.php';
include '../config/koneksi.php';
?>

<h3>Data Pesanan User</h3>
<hr>

<table class="table table-bordered">
<tr>
    <th>No</th>
    <th>Tanggal</th>
    <th>Nama Penerima</th>
    <th>Total</th>
    <th>Metode</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php
$no = 1;
$data = mysqli_query($koneksi, "SELECT * FROM pesanan ORDER BY id_pesanan DESC");

while($d = mysqli_fetch_array($data)){
?>

<tr>
    <td><?php echo $no++; ?></td>
    <td><?php echo $d['tanggal']; ?></td>
    <td><?php echo $d['nama_penerima']; ?></td>
    <td>Rp <?php echo number_format($d['total_harga']); ?></td>
    <td><?php echo $d['metode_pembayaran']; ?></td>
    <td>
        <span class="badge bg-info">
            <?php echo $d['status']; ?>
        </span>
    </td>
    <td>
        <a href="detail_pesanan.php?id=<?php echo $d['id_pesanan']; ?>" 
           class="btn btn-primary btn-sm">
           Detail
        </a>
    </td>
</tr>

<?php } ?>

</table>

<?php include 'footer.php'; ?>
