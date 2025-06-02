<?php
// Veritabanına bağlan
include 'db_connect.php';

// Hata mesajı için değişken
$mesaj = '';

// Bilet alma formu gönderildi mi?
if (isset($_POST['bilet_al'])) {
    $isim = $_POST['isim'];
    
    // İsim boş mu diye bak
    if ($isim == "") {
        $mesaj = '<p class="hata">İsim yazın!</p>';
    } else {
        // Bileti kaydet
        $sql = "INSERT INTO biletler SET 
                isim_soyisim = '$isim',
                film_id = '$_POST[film]',
                salon_id = 1,
                koltuk_no = '$_POST[koltuk]',
                fiyat = 50";
        
        // Kayıt başarılı mı?
        if (mysqli_query($conn, $sql)) {
            $mesaj = '<p class="basarili">Bilet alındı!</p>';
        } else {
            $mesaj = '<p class="hata">Hata oluştu!</p>';
        }
    }
}

// Film listesini al
$filmler = mysqli_query($conn, "SELECT * FROM filmler");

// Film seçeneklerini hazırla
$film_secenekleri = '<option value="">Film Seçin</option>';
while($film = mysqli_fetch_array($filmler)) {
    $secili = (isset($_POST['film']) && $_POST['film'] == $film['id']) ? 'selected' : '';
    $film_secenekleri .= "<option value='" . $film['id'] . "' $secili>" . $film['film_adi'] . " - " . $film['film_fiyat'] . " TL</option>";
}

// Koltuk seçeneklerini hazırla
$koltuk_secenekleri = '<option value="">Koltuk Seçin</option>';

// Film seçildi mi?
if (isset($_POST['film']) && $_POST['film'] != '') {
    // Dolu koltukları al
    $dolu_koltuklar = array();
    $sorgu = "SELECT koltuk_no FROM biletler WHERE film_id = '$_POST[film]'";
    $sonuc = mysqli_query($conn, $sorgu);
    while ($row = mysqli_fetch_array($sonuc)) {
        $dolu_koltuklar[] = $row['koltuk_no'];
    }

    // Tüm koltukları oluştur (1'den 10'a kadar)
    $toplam_koltuk_sayisi = 10;
    
    // Her koltuk için
    for ($koltuk_no = 1; $koltuk_no <= $toplam_koltuk_sayisi; $koltuk_no++) {
        // Eğer koltuk dolu değilse, seçeneklere ekle
        if (!in_array($koltuk_no, $dolu_koltuklar)) {
            // Eğer bu koltuk daha önce seçilmişse, selected özelliği ekle
            $koltuk_secili = (isset($_POST['koltuk']) && $_POST['koltuk'] == $koltuk_no) ? 'selected' : '';
            
            // Koltuk seçeneğini listeye ekle
            $koltuk_secenekleri .= "<option value='$koltuk_no' $koltuk_secili>Koltuk $koltuk_no</option>";
        }
    }
}

// HTML sayfasını oku
$sayfa = file_get_contents('index.html');

// Seçenekleri sayfaya ekle
$sayfa = str_replace('<option value="">Film Seçin</option>', $film_secenekleri, $sayfa);
$sayfa = str_replace('<option value="">Koltuk Seçin</option>', $koltuk_secenekleri, $sayfa);

// Mesaj varsa ekle
if ($mesaj != '') {
    $sayfa = str_replace('<h1>Bilet Al</h1>', '<h1>Bilet Al</h1>' . $mesaj, $sayfa);
}

// Sayfayı göster
echo $sayfa; 