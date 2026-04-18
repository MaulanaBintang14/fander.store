<?php
include 'config/koneksi.php';

$search = $_GET['search'] ?? '';

$query = mysqli_query($koneksi,"
    SELECT * FROM produk 
    WHERE nama_produk LIKE '%$search%' 
    OR deskripsi LIKE '%$search%'
    ORDER BY id_produk DESC
");

if(mysqli_num_rows($query) > 0){

    while($d = mysqli_fetch_array($query)){
?>

<div class="col-md-3 mb-4">
    <div class="card product-card h-100">

        <img src="admin/uploads/<?php echo $d['gambar']; ?>" 
             class="card-img-top">

        <div class="card-body">
            <h6><?php echo $d['nama_produk']; ?></h6>
            <b>Rp <?php echo number_format($d['harga']); ?></b><br>
            <small>Stok: <?php echo $d['stok']; ?></small>
        </div>

        <div class="card-footer">
            <a href="detail_produk.php?id=<?php echo $d['id_produk']; ?>" 
               class="btn btn-dark w-100">
               Lihat Detail
            </a>
        </div>

    </div>
</div>

<?php
    }

}else{
    echo "<div class='text-center'>Produk tidak ditemukan</div>";
}
?>