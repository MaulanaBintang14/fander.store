<?php
require '../vendor/autoload.php';
include '../config/koneksi.php';

use Dompdf\Dompdf;

$id = $_GET['id'];

// 🔥 ambil data lengkap
$data = mysqli_query($koneksi, "
SELECT 
    p.*,
    m.nama_metode
FROM pesanan p
LEFT JOIN metode_pembayaran m ON p.id_metode = m.id_metode
WHERE p.id_pesanan='$id'
");

$p = mysqli_fetch_assoc($data);

// 🔥 ambil detail produk
$detail = mysqli_query($koneksi, "
SELECT dp.*, pr.nama_produk 
FROM detail_pesanan dp
JOIN produk pr ON dp.id_produk = pr.id_produk
WHERE dp.id_pesanan='$id'
");

// 🔥 HTML untuk PDF
$html = '
<h2 style="text-align:center;">LABEL PENGIRIMAN</h2>
<hr>

<b>Nama:</b> '.$p['nama_penerima'].'<br>
<b>No HP:</b> '.$p['telepon'].'<br><br>

<b>Alamat:</b><br>
'.$p['detail_alamat'].'<br>
'.$p['desa'].', '.$p['kecamatan'].'<br>
'.$p['kota'].', '.$p['provinsi'].'<br>
Kode Pos: '.$p['kode_pos'].'<br>

<hr>

<b>Produk:</b><br>
<ul>
';

while($d = mysqli_fetch_array($detail)){
    $html .= '<li>'.$d['nama_produk'].' x '.$d['jumlah'].'</li>';
}

$html .= '
</ul>

<hr>
<b>Total:</b> Rp '.number_format($p['total_harga']).'
';

// 🔥 generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A6'); // ukuran kecil seperti label
$dompdf->render();
$dompdf->stream("resi_pesanan_".$id.".pdf", ["Attachment"=>1]);