<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("location:login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Fander Leather</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-dark bg-dark">
<div class="container">

    <a class="navbar-brand" href="dashboard.php">
        Admin Fander Leather
    </a>

    <div>
        <a href="dashboard.php" class="btn btn-secondary">Dashboard</a>
        <a href="produk.php" class="btn btn-primary">Produk</a>
        <a href="pesanan.php" class="btn btn-info">Pesanan</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

</div>
</nav>

<div class="container mt-4">
