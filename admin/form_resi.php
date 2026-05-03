<?php
include '../config/koneksi.php';

$id = $_GET['id'];
?>

<form method="POST">
    <label>Nomor Resi</label>
    <input type="text" name="resi" class="form-control" required>

    <button class="btn btn-success mt-2">Kirim</button>
</form>

<?php
if(isset($_POST['resi'])){
    $resi = $_POST['resi'];

    mysqli_query($koneksi,"
    UPDATE pesanan SET
    resi='$resi',
    status='dikirim'
    WHERE id_pesanan='$id'
    ");

    echo "<script>
    alert('Pesanan dikirim');
    window.location='pesanan.php';
    </script>";
}
?>