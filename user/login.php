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

    if(isset($_SESSION['redirect'])){
    $redirect = $_SESSION['redirect'];
    unset($_SESSION['redirect']);
    echo "<script>window.location='../$redirect';</script>";
    } else {
        echo "<script>window.location='../index.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
body {
    background: linear-gradient(135deg, #3e1f0d, #8b5e34);
    height: 100vh;
    font-family: 'Segoe UI', sans-serif;
}

.login-box {
    background: #f8f5f0;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.3);
}

.title {
    font-weight: bold;
    text-align: center;
    color: #5a3e2b;
}

.form-control {
    border-radius: 12px;
    padding-left: 40px;
    border: 1px solid #d6c3a3;
}

.input-group-text {
    background: #e6d3b3;
    border-radius: 12px 0 0 12px;
}

.btn-gold {
    background: #c89b3c;
    color: white;
    border-radius: 12px;
    width: 100%;
    font-weight: bold;
}

.btn-gold:hover {
    background: #a67c2b;
}

.btn-outline-custom {
    border-radius: 12px;
    width: 100%;
    border: 1px solid #8b5e34;
    color: #5a3e2b;
}
</style>
</head>

<body>

<div class="d-flex justify-content-center align-items-center" style="height:100vh;">
    <div class="col-md-4">
        <div class="login-box">
            <h3 class="title mb-4">Fander Leather</h3>

            <form method="POST">

            <div class="mb-3">
                <label>Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email..." required>
                </div>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password..." required>
                </div>
            </div>

            <button name="login" class="btn btn-gold mb-2">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </button>

            <a href="register.php" class="btn btn-outline-custom">
                Daftar
            </a>

            </form>
        </div>
    </div>
</div>

</body>
</html>