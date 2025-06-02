<?php
// MySQL bağlantısı
$conn = mysqli_connect("localhost", "root", "", "sinema");

// Hata varsa göster
if (!$conn) {
    echo "Bağlantı hatası!";
    die();
}
?> 