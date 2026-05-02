<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kontak - Fander Leather</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    background:#f8f5f2;
}

/* HERO */
.hero{
    background: linear-gradient(135deg,#3b2415,#8b5a2b);
    color:white;
    padding:60px;
    text-align:center;
    border-radius:0 0 30px 30px;
}

/* CARD */
.card-custom{
    border-radius:15px;
    padding:25px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

/* ICON */
.icon{
    font-size:22px;
    color:#8b5a2b;
    margin-right:10px;
}
</style>
</head>

<body>

<div class="hero">
<h1>Hubungi Kami</h1>
<p>Kami siap membantu kebutuhan produk kulit Anda</p>
</div>

<div class="container mt-5">

<div class="row g-4">

<!-- INFO -->
<div class="col-md-5">
<div class="card-custom bg-white">

<h5>Informasi Kontak</h5>
<hr>

<p><i class="fa fa-phone icon"></i> 087877050076</p>
<p><i class="fa fa-envelope icon"></i> fanderleather@gmail.com</p>
<p><i class="fa fa-map-marker icon"></i> Tajinan, Malang, Indonesia</p>

<hr>

<a href="https://wa.me/6287877050076" target="_blank" class="btn btn-success w-100">
<i class="fa fa-whatsapp"></i> Chat WhatsApp
</a>

</div>
</div>

<!-- FORM -->
<div class="col-md-7">
<div class="card-custom bg-white">

<h5>Kirim Pesan</h5>
<hr>

<form onsubmit="kirimWA(event)">
    <input type="text" id="nama" class="form-control mb-3" placeholder="Nama" required>
    <input type="email" id="email" class="form-control mb-3" placeholder="Email" required>
    <textarea id="pesan" class="form-control mb-3" rows="4" placeholder="Pesan" required></textarea>

    <button class="btn btn-dark w-100">
        <i class="fa fa-paper-plane"></i> Kirim Pesan
    </button>
</form>

</div>
</div>

</div>

<!-- MAP -->
<div class="mt-5">

<h5 class="mb-3">Lokasi Kami</h5>

<div style="
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
">

<iframe 
src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3950.217838136093!2d112.65487187744982!3d-8.079252371189789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd627d1fbddabeb%3A0xaf0d568ec959fcaf!2sJaket%20kulit%20fander!5e0!3m2!1sid!2sus!4v1777722426964!5m2!1sid!2sus" 
width="100%" 
height="350" 
style="border:0;" 
allowfullscreen="" 
loading="lazy">
</iframe>

</div>

<p class="mt-3 text-muted">
Jl. Kepala Desa, RT 16 / RW 04, Jambearjo, Kec. Tajinan, Kabupaten Malang, Jawa Timur 65172
</p>

<a href="https://www.google.com/maps?q=-8.079252371189789,112.65487187744982" 
target="_blank" 
class="btn btn-outline-dark btn-sm">
Buka di Google Maps
</a>

</div>

</div>

<script>
function kirimWA(e){
    e.preventDefault();

    let nama = document.getElementById('nama').value;
    let email = document.getElementById('email').value;
    let pesan = document.getElementById('pesan').value;

    // 🔴 GANTI NOMOR WA KAMU (format: 628xxxx TANPA +)
    let noWa = "6281234567890";

    let text = 
`Halo Fander Leather 👋

Nama: ${nama}
Email: ${email}

Pesan:
${pesan}

Saya tertarik dengan produk Fander Leather`;

    let url = "https://wa.me/" + noWa + "?text=" + encodeURIComponent(text);

    window.open(url, '_blank');
}
</script>

</body>
</html>