<?php
session_start();
include 'config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fander Leather</title>

<!-- BOOTSTRAP CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- GOOGLE FONTS -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --leather-dark: #2c1810;
    --leather-brown: #44190c;
    --leather-medium: #6b3e1a;
    --leather-light: #8b5a2b;
    --leather-tan: #c8956d;
    --leather-cream: #e8d5b7;
    --accent-gold: #d4af37;
    --accent-bronze: #cd7f32;
    --text-dark: #1a120e;
    --text-light: #f5f5f0;
}

* {
    font-family: 'Inter', sans-serif;
}

body {
    background: linear-gradient(135deg, var(--leather-tan) 0%, var(--leather-medium) 50%, var(--leather-brown) 100%);
    min-height: 100vh;
    position: relative;
}

body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: 
        radial-gradient(circle at 25% 25%, rgba(212, 175, 55, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 75% 75%, rgba(139, 90, 43, 0.1) 0%, transparent 50%),
        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="1.5" fill="rgba(212,175,55,0.2)"/><circle cx="80" cy="80" r="1" fill="rgba(212,175,55,0.15)"/><circle cx="40" cy="60" r="0.8" fill="rgba(212,175,55,0.1)"/><circle cx="90" cy="10" r="1.2" fill="rgba(212,175,55,0.2)"/><circle cx="10" cy="90" r="0.5" fill="rgba(212,175,55,0.1)"/></svg>');
    pointer-events: none;
    z-index: -1;
}

.navbar {
    background: linear-gradient(135deg, var(--leather-dark) 0%, var(--leather-brown) 100%) !important;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 32px rgba(44, 24, 16, 0.3);
    border-bottom: 1px solid rgba(212, 175, 55, 0.2);
}

.navbar-brand {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    font-size: 1.6rem;
    transition: all 0.3s ease;
    color: var(--accent-gold) !important;
}

.navbar-brand:hover {
    transform: translateY(-2px);
    color: var(--leather-cream) !important;
}

.navbar-brand img {
    transition: all 0.3s ease;
    border: 2px solid var(--accent-gold);
    box-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
}

.navbar-brand:hover img {
    transform: scale(1.1);
    border-color: var(--leather-cream);
    box-shadow: 0 0 15px rgba(212, 175, 55, 0.5);
}

.nav-link {
    transition: all 0.3s ease;
    position: relative;
    color: var(--leather-cream) !important;
}

.nav-link:hover {
    transform: translateY(-1px);
    color: var(--accent-gold) !important;
}

.btn {
    transition: all 0.3s ease;
    border: none;
    border-radius: 25px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.85rem;
    position: relative;
    overflow: hidden;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
}

.btn-warning {
    background: linear-gradient(135deg, var(--accent-gold) 0%, var(--accent-bronze) 100%);
    color: var(--text-dark);
    box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
}

.btn-warning:hover {
    color: var(--text-light);
    box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
}

.btn-success {
    background: linear-gradient(135deg, var(--leather-medium) 0%, var(--leather-light) 100%);
    color: var(--text-light);
    box-shadow: 0 4px 15px rgba(107, 62, 26, 0.3);
}

.btn-primary {
    background: linear-gradient(135deg, var(--leather-brown) 0%, var(--leather-medium) 100%);
    color: var(--text-light);
    box-shadow: 0 4px 15px rgba(68, 25, 12, 0.3);
}

.btn-danger {
    background: linear-gradient(135deg, #8b2635 0%, #a0394a 100%);
    color: var(--text-light);
    box-shadow: 0 4px 15px rgba(139, 38, 53, 0.3);
}

.content-wrapper {
    background: rgba(245, 245, 240, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 25px;
    margin: 2rem 0;
    box-shadow: 0 20px 60px rgba(44, 24, 16, 0.2);
    border: 1px solid rgba(212, 175, 55, 0.2);
}

.page-title {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    background: linear-gradient(135deg, var(--leather-brown) 0%, var(--leather-medium) 50%, var(--accent-gold) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 2.8rem;
    margin-bottom: 0;
}

.title-underline {
    width: 120px;
    height: 4px;
    background: linear-gradient(135deg, var(--leather-brown) 0%, var(--accent-gold) 100%);
    border-radius: 2px;
    margin: 1rem 0 2rem 0;
}

.product-card {
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: none;
    border-radius: 20px;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    box-shadow: 0 10px 40px rgba(44, 24, 16, 0.15);
    position: relative;
    border: 1px solid rgba(212, 175, 55, 0.1);
}

.product-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(68, 25, 12, 0.05) 0%, rgba(212, 175, 55, 0.05) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 1;
}

.product-card:hover {
    transform: translateY(-15px) scale(1.02);
    box-shadow: 0 25px 60px rgba(44, 24, 16, 0.25);
    border-color: var(--accent-gold);
}

.product-card:hover::before {
    opacity: 1;
}

.product-card .card-img-top {
    transition: all 0.4s ease;
    height: 250px;
    object-fit: cover;
    position: relative;
    z-index: 2;
    border-bottom: 2px solid transparent;
}

.product-card:hover .card-img-top {
    transform: scale(1.05);
    border-bottom-color: var(--accent-gold);
}

.card-body {
    position: relative;
    z-index: 3;
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.8);
}

.card-title {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 1rem;
    font-size: 1.1rem;
    font-family: 'Playfair Display', serif;
}

.price {
    font-size: 1.4rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--leather-brown) 0%, var(--accent-bronze) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
}

.stock-info {
    color: var(--leather-medium);
    font-size: 0.9rem;
    font-weight: 500;
    background: rgba(212, 175, 55, 0.1);
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    display: inline-block;
}

.card-footer {
    background: rgba(232, 213, 183, 0.5) !important;
    border: none;
    padding: 1.5rem;
    position: relative;
    z-index: 3;
}

.detail-btn {
    width: 100%;
    font-weight: 600;
    padding: 12px;
    border-radius: 15px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, var(--leather-brown) 0%, var(--leather-medium) 100%);
    color: var(--text-light);
    box-shadow: 0 4px 15px rgba(68, 25, 12, 0.3);
}

.detail-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(212, 175, 55, 0.3), transparent);
    transition: left 0.5s;
}

.detail-btn:hover {
    background: linear-gradient(135deg, var(--leather-medium) 0%, var(--accent-gold) 100%);
    color: var(--text-dark);
    box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
}

.detail-btn:hover::before {
    left: 100%;
}

.no-products {
    background: linear-gradient(135deg, var(--leather-brown) 0%, var(--leather-medium) 100%);
    border: 2px solid var(--accent-gold);
    border-radius: 20px;
    color: var(--text-light);
    font-weight: 500;
    padding: 3rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.no-products::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M10,10 Q50,5 90,10 Q95,50 90,90 Q50,95 10,90 Q5,50 10,10" fill="none" stroke="rgba(212,175,55,0.1)" stroke-width="1"/></svg>');
    opacity: 0.3;
}

.footer {
    background: linear-gradient(135deg, var(--leather-dark) 0%, var(--leather-brown) 100%);
    color: var(--leather-cream);
    text-align: center;
    padding: 2.5rem 0;
    margin-top: 3rem;
    border-top: 3px solid var(--accent-gold);
    position: relative;
}

.footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--accent-gold), transparent);
}

.footer-content {
    font-weight: 500;
    font-size: 1rem;
}

.notification-badge {
    animation: pulse 2s infinite;
    background: linear-gradient(135deg, var(--accent-gold) 0%, var(--accent-bronze) 100%) !important;
    color: var(--text-dark) !important;
    border: 2px solid var(--leather-cream);
}

.leather-texture {
    position: relative;
}

.leather-texture::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 2px 2px, rgba(212,175,55,0.1) 1px, transparent 0),
        radial-gradient(circle at 12px 12px, rgba(68,25,12,0.1) 1px, transparent 0);
    background-size: 20px 20px;
    opacity: 0.3;
    pointer-events: none;
}

@keyframes pulse {
    0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.4); }
    50% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(212, 175, 55, 0); }
    100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(212, 175, 55, 0); }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeInUp 0.8s ease-out;
}

/* User greeting styling */
.user-greeting {
    background: rgba(212, 175, 55, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    border: 1px solid rgba(212, 175, 55, 0.3);
    color: var(--text-light) !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-title {
        font-size: 2.2rem;
    }
    
    .content-wrapper {
        margin: 1rem;
        border-radius: 15px;
    }
    
    .product-card {
        margin-bottom: 2rem;
    }

    .navbar-brand {
        font-size: 1.3rem;
    }
}
</style>

</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
<div class="container">

    <a class="navbar-brand d-flex align-items-center" href="index.php">
        <img src="assets/images/logo.png"
             class="me-2 rounded-circle"
             style="width: 45px; height: 45px; object-fit: cover;">
        Fander Leather
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">

            <?php if(isset($_SESSION['user'])){ ?>

            <!-- NOTIFIKASI -->
            <li class="nav-item me-3">
                <a href="user/notifikasi.php" class="nav-link position-relative">
                    <i class="fa fa-bell fa-lg"></i>

                    <?php
                    $id_user = $_SESSION['user']['id_user'];

                    $cek = mysqli_query($koneksi,
                    "SELECT * FROM notifikasi WHERE id_user='$id_user' AND status='unread'");

                    $jumlah = mysqli_num_rows($cek);

                    if($jumlah > 0){
                    ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill notification-badge">
                            <?php echo $jumlah; ?>
                        </span>
                    <?php } ?>
                </a>
            </li>

            <?php } ?>

            <!-- KERANJANG -->
            <li class="nav-item me-3">
                <a href="user/keranjang.php" class="btn btn-warning btn-sm">
                    <i class="fa fa-shopping-cart"></i> Keranjang
                </a>
            </li>

            <?php if(isset($_SESSION['user'])){ ?>

                <li class="nav-item me-3">
                    <span class="user-greeting">
                        <i class="fa fa-user me-2"></i>Halo, <?php echo $_SESSION['user']['nama']; ?>
                    </span>
                </li>

                <li class="nav-item">
                    <a href="user/logout.php" class="btn btn-danger btn-sm">
                        <i class="fa fa-sign-out-alt me-1"></i>Logout
                    </a>
                </li>

            <?php } else { ?>

                <li class="nav-item me-2">
                    <a href="user/login.php" class="btn btn-success btn-sm">
                        <i class="fa fa-sign-in-alt me-1"></i>Login
                    </a>
                </li>

                <li class="nav-item">
                    <a href="user/register.php" class="btn btn-primary btn-sm">
                        <i class="fa fa-user-plus me-1"></i>Daftar
                    </a>
                </li>

            <?php } ?>

        </ul>
    </div>

</div>
</nav>
<!-- END NAVBAR -->

<!-- CONTENT -->
<div class="container">
    <div class="content-wrapper leather-texture">
        <div class="p-5">
            <h1 class="page-title fade-in">Koleksi Jaket Kulit Terbaru</h1>
            <div class="title-underline fade-in"></div>

            <div class="row">

            <?php
            $data = mysqli_query($koneksi,"SELECT * FROM produk ORDER BY id_produk DESC");

            if(mysqli_num_rows($data) > 0){
                $delay = 0;
                while($d = mysqli_fetch_array($data)){
            ?>

            <div class="col-lg-3 col-md-6 mb-4 fade-in" style="animation-delay: <?php echo $delay; ?>s;">
            <div class="card product-card h-100">

                <img src="admin/uploads/<?php echo $d['gambar']; ?>" 
                     class="card-img-top" alt="<?php echo $d['nama_produk']; ?>">

                <div class="card-body">
                    <h5 class="card-title">
                        <?php echo $d['nama_produk']; ?>
                    </h5>

                    <p class="price">
                        Rp <?php echo number_format($d['harga']); ?>
                    </p>

                    <div class="stock-info">
                        <i class="fa fa-layer-group me-1"></i>Stok: <?php echo $d['stok']; ?>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="detail_produk.php?id=<?php echo $d['id_produk']; ?>" 
                       class="btn detail-btn">
                        <i class="fa fa-eye me-2"></i>Lihat Detail
                    </a>
                </div>

            </div>
            </div>

            <?php 
                $delay += 0.1;
                } 
            } else { 
            ?>

            <div class="col-12">
                <div class="alert no-products fade-in">
                    <i class="fa fa-shopping-bag fa-3x mb-3"></i>
                    <h4>Koleksi Sedang Dipersiapkan</h4>
                    <p class="mb-0">Jaket kulit premium kami sedang dalam tahap kurasi. Silakan kembali lagi untuk melihat koleksi eksklusif terbaru!</p>
                </div>
            </div>

            <?php } ?>

            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->

<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <i class="fa fa-copyright me-2"></i>
            <?php echo date('Y'); ?> Fander Leather - Crafted with Passion for Premium Leather
        </div>
    </div>
</footer>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced leather-themed animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all product cards with leather-inspired effects
    document.querySelectorAll('.product-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
        
        // Add leather texture hover effect
        card.addEventListener('mouseenter', function() {
            this.style.boxShadow = '0 25px 60px rgba(44, 24, 16, 0.3), inset 0 1px 0 rgba(212, 175, 55, 0.2)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.boxShadow = '0 10px 40px rgba(44, 24, 16, 0.15)';
        });
    });
    
    // Add premium leather brand feel
    const navbar = document.querySelector('.navbar-brand');
    navbar.addEventListener('mouseenter', function() {
        this.style.textShadow = '0 0 10px rgba(212, 175, 55, 0.5)';
    });
    
    navbar.addEventListener('mouseleave', function() {
        this.style.textShadow = 'none';
    });
});
</script>

</body>
</html>
