<?php
session_start();
include '../config/koneksi.php';

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $cek = mysqli_query($koneksi,
    "SELECT * FROM users WHERE email='$email' AND password='$password'");

    $data = mysqli_fetch_array($cek);

    if($data){
        $_SESSION['user'] = $data;
        echo "<script>
        alert('Login berhasil');
        window.location='../index.php';
        </script>";
    } else {
        echo "<script>alert('Email atau password salah');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5">
<h3>Login User</h3>
<hr>

<form method="POST">

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<button name="login" class="btn btn-success">Login</button>
<a href="register.php" class="btn btn-primary">Daftar</a>

</form>
</div>
</body>
</html>
