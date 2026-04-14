<?php
include '../config/koneksi.php';

if(isset($_POST['daftar'])){

    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];

    mysqli_query($koneksi,
    "INSERT INTO users(nama,email,password,alamat,telepon)
    VALUES('$nama','$email','$password','$alamat','$telepon')");

    echo "<script>
    alert('Registrasi berhasil, silakan login');
    window.location='login.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5">
<h3>Registrasi User</h3>
<hr>

<form method="POST">

<div class="mb-3">
<label>Nama</label>
<input type="text" name="nama" class="form-control" required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<div class="mb-3">
<label>Alamat</label>
<textarea name="alamat" class="form-control"></textarea>
</div>

<div class="mb-3">
<label>Telepon</label>
<input type="text" name="telepon" class="form-control">
</div>

<button name="daftar" class="btn btn-primary">Daftar</button>
<a href="login.php" class="btn btn-secondary">Login</a>

</form>
</div>
</body>
</html>
