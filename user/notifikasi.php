<?php
session_start();
include '../config/koneksi.php';

$id_user = $_SESSION['user']['id_user'];

mysqli_query($koneksi,
"UPDATE notifikasi SET status='read' WHERE id_user='$id_user'");
?>

<!DOCTYPE html>
<html>
<head>
<title>Notifikasi</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">
<h3>Notifikasi</h3>
<hr>

<?php
$data = mysqli_query($koneksi,
"SELECT * FROM notifikasi WHERE id_user='$id_user' ORDER BY id_notif DESC");

while($d = mysqli_fetch_array($data)){
?>

<div class="alert alert-info">
    <?php echo $d['pesan']; ?>
    <br>
    <small><?php echo $d['tanggal']; ?></small>
</div>

<?php } ?>

</div>

</body>
</html>
