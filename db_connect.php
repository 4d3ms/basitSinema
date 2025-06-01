<?php
$conn = mysqli_connect("localhost", "root", "", "sinema");

if (!$conn) {
    echo "Veritabanı bağlantı hatası: " . mysqli_connect_error();
    die();
}
?> 