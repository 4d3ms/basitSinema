<?php
// Veritabanına bağlan
include 'db_connect.php';

// Hata mesajı için değişken
$mesaj = '';

// Film ekleme butonu tıklandı mı?
if (isset($_POST['film_ekle'])) {
    $film_adi = $_POST['film_adi'];
    
    // Film adı boş mu diye bak
    if ($film_adi == "") {
        $mesaj .= '<p class="hata">Film adını yazın!</p>';
    } else {
        // Filmi kaydet
        $sql = "INSERT INTO filmler SET 
                film_adi = '$film_adi',
                film_suresi = '$_POST[film_suresi]',
                film_fiyat = '$_POST[film_fiyat]'";
        
        if (mysqli_query($conn, $sql)) {
            $mesaj .= '<p class="basarili">Film eklendi!</p>';
        } else {
            $mesaj .= '<p class="hata">Film eklenemedi!</p>';
        }
    }
}

// Seans ekleme butonu tıklandı mı?
if (isset($_POST['seans_ekle'])) {
    $film_id = $_POST['film_id'];
    
    // Film seçildi mi diye bak
    if ($film_id == "") {
        $mesaj .= '<p class="hata">Film seçin!</p>';
    } else {
        // Seansı kaydet
        $sql = "INSERT INTO seanslar SET 
                film_id = '$film_id',
                salon_id = 1,
                saat = '$_POST[seans_saati]'";
        
        if (mysqli_query($conn, $sql)) {
            $mesaj .= '<p class="basarili">Seans eklendi!</p>';
        } else {
            $mesaj .= '<p class="hata">Seans eklenemedi!</p>';
        }
    }
}

// Film listesini al
$filmler = mysqli_query($conn, "SELECT * FROM filmler");

// Film seçeneklerini hazırla
$film_secenekleri = '<option value="">Film Seçin</option>';
while($film = mysqli_fetch_array($filmler)) {
    $film_secenekleri .= "<option value='" . $film['id'] . "'>" . $film['film_adi'] . "</option>";
}

// HTML sayfasını oku
$sayfa = file_get_contents('admin.html');

// Film seçeneklerini sayfaya ekle
$sayfa = str_replace('<option value="">Film Seçin</option>', $film_secenekleri, $sayfa);

// Mesaj varsa ekle
if ($mesaj != '') {
    $sayfa = str_replace('<h1>Yönetim Paneli</h1>', '<h1>Yönetim Paneli</h1>' . $mesaj, $sayfa);
}

// Sayfayı göster
echo $sayfa; 