<?php
function kirim_notif($koneksi, $id_user, $id_pesanan, $pesan, $link){
    mysqli_query($koneksi,"
    INSERT INTO notifikasi (id_user, id_pesanan, pesan, link)
    VALUES ('$id_user','$id_pesanan','$pesan','$link')
    ");
}