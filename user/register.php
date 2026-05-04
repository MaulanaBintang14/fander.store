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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
body {
    background: linear-gradient(135deg, #3e1f0d, #8b5e34);
    min-height: 100vh;
}

.register-box {
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

<div class="d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="col-md-5">

        <div class="register-box">
            <h3 class="title mb-4">Fander Leather</h3>

            <form method="POST">

            <div class="mb-3">
                <label>Nama</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="nama" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Alamat</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                    <textarea name="alamat" class="form-control"></textarea>
                </div>
            </div>

            <div class="mb-3">
                <label>Telepon</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                    <input type="text" name="telepon" class="form-control">
                </div>
            </div>

            <button name="daftar" class="btn btn-gold mb-2">
                Daftar
            </button>

            <a href="login.php" class="btn btn-outline-custom">
                Login
            </a>

            </form>
        </div>

    </div>
</div>

</body>
</html>