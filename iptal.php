<?php
// Veritabanına bağlan
include 'db_connect.php';

// Değişkenler
$mesaj = '';
$bilet_bilgisi = '';

// Form gönderildi mi?
if ($_POST) {
    $isim = $_POST['isim_soyisim'];
    $koltuk = $_POST['koltuk_no'];
    
    // İsim boş mu diye bak
    if ($isim == "") {
        $mesaj = '<p class="hata">İsim yazın!</p>';
    } else {
        // Bileti bul
        $sorgu = "SELECT b.*, f.film_adi, s.salon_no 
                FROM biletler b, filmler f, salonlar s 
                WHERE b.film_id = f.id 
                AND b.salon_id = s.id 
                AND b.isim_soyisim = '$isim' 
                AND b.koltuk_no = '$koltuk'";
        
        $sonuc = mysqli_query($conn, $sorgu);
        
        // Bilet var mı?
        if (mysqli_num_rows($sonuc) > 0) {
            $bilet = mysqli_fetch_array($sonuc);
            
            // Bilet bilgilerini göster
            $bilet_bilgisi = "
            <div class='biletDetay'>
                <h3>İptal Edilen Bilet</h3>
                <p>Ad Soyad: {$bilet['isim_soyisim']}</p>
                <p>Film: {$bilet['film_adi']}</p>
                <p>Salon: {$bilet['salon_no']}</p>
                <p>Koltuk: {$bilet['koltuk_no']}</p>
                <p>Fiyat: {$bilet['fiyat']} TL</p>
            </div>";
            
            // Bileti sil
            $sil = "DELETE FROM biletler WHERE isim_soyisim = '$isim' AND koltuk_no = '$koltuk'";
            if (mysqli_query($conn, $sil)) {
                $mesaj = '<p class="basarili">Bilet iptal edildi!</p>';
            } else {
                $mesaj = '<p class="hata">İptal hatası!</p>';
            }
        } else {
            $mesaj = '<p class="hata">Bilet bulunamadı!</p>';
        }
    }
}

// HTML sayfasını oku
$sayfa = file_get_contents('iptal.html');

// Mesaj ve bilet bilgisini ekle
$sayfa = str_replace('<div id="mesaj"></div>', $mesaj, $sayfa);
$sayfa = str_replace('<div id="iptal-detay"></div>', $bilet_bilgisi, $sayfa);

// Sayfayı göster
echo $sayfa;
?> 