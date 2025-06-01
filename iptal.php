<?php
require_once 'db_connect.php';

$iptal_mesaji = '';
$iptal_edilen_bilet = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isim_soyisim = $_POST['isim_soyisim'];
    $koltuk_no = $_POST['koltuk_no'];

    if (empty($isim_soyisim) || empty($koltuk_no)) {
        $iptal_mesaji = "<div style='color: red; background: white; padding: 10px; margin: 10px auto; width: 300px;'>Tüm alanları doldurunuz!</div>";
    } else {
        // Bilet kontrolü ve bilgileri alma
        $kontrol = "SELECT b.*, f.film_adi, s.salon_no 
                   FROM biletler b
                   JOIN filmler f ON b.film_id = f.id
                   JOIN salonlar s ON b.salon_id = s.id
                   WHERE b.isim_soyisim = '$isim_soyisim' 
                   AND b.koltuk_no = '$koltuk_no'";
        $sonuc = mysqli_query($conn, $kontrol);

        if (mysqli_num_rows($sonuc) > 0) {
            $iptal_edilen_bilet = mysqli_fetch_assoc($sonuc);
            
            $sql = "DELETE FROM biletler WHERE isim_soyisim = '$isim_soyisim' AND koltuk_no = '$koltuk_no'";
            
            if (mysqli_query($conn, $sql)) {
                $iptal_mesaji = "<div style='color: green; background: white; padding: 10px; margin: 10px auto; width: 300px;'>Bilet başarıyla iptal edildi!</div>";
            } else {
                $iptal_mesaji = "<div style='color: red; background: white; padding: 10px; margin: 10px auto; width: 300px;'>Hata: " . mysqli_error($conn) . "</div>";
            }
        } else {
            $iptal_mesaji = "<div style='color: red; background: white; padding: 10px; margin: 10px auto; width: 300px;'>Bilet bulunamadı!</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bilet İptal - Sinema Bilet Sistemi</title>
    <style>
        body {
            text-align: center;
            font-family: Arial;
            margin: 20px;
            background-color: #1a237e;
            color: white;
        }

        .form-kutu {
            border: 1px solid #ccc;
            padding: 20px;
            width: 300px;
            margin: 0 auto;
            text-align: left;
            background-color: white;
            color: black;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        input, select {
            width: 100%;
            padding: 5px;
            margin: 5px 0;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #4CAF50;
            color: white;
            border: none;
            margin-top: 10px;
        }

        h2 {
            margin: 10px 0;
        }

        .menu {
            margin-bottom: 20px;
        }

        .menu a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            padding: 5px;
        }

        .menu a:hover {
            text-decoration: underline;
        }

        .iptal-detay {
            background-color: white;
            color: black;
            padding: 20px;
            border-radius: 5px;
            width: 300px;
            margin: 20px auto;
            text-align: left;
        }

        .iptal-detay h3 {
            color: #1a237e;
            margin-top: 0;
        }

        .iptal-detay p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="menu">
        <a href="index.php">Anasayfa</a>
        <a href="iptal.php">Bilet İptal</a>
        <a href="admin.php">Yönetim Paneli</a>
    </div>

    <h1>Bilet İptal</h1>

    <?php echo $iptal_mesaji; ?>

    <div class="form-kutu">
        <form method="POST">
            <h2>Ad Soyad</h2>
            <input type="text" name="isim_soyisim" required>

            <h2>Koltuk Numarası</h2>
            <input type="text" name="koltuk_no" required>

            <button type="submit">Bileti İptal Et</button>
        </form>
    </div>

    <?php if ($iptal_edilen_bilet): ?>
    <div class="iptal-detay">
        <h3>İptal Edilen Bilet Detayları</h3>
        <p><strong>Ad Soyad:</strong> <?php echo $iptal_edilen_bilet['isim_soyisim']; ?></p>
        <p><strong>Film:</strong> <?php echo $iptal_edilen_bilet['film_adi']; ?></p>
        <p><strong>Salon:</strong> <?php echo $iptal_edilen_bilet['salon_no']; ?></p>
        <p><strong>Koltuk:</strong> <?php echo $iptal_edilen_bilet['koltuk_no']; ?></p>
        <p><strong>Fiyat:</strong> <?php echo $iptal_edilen_bilet['fiyat']; ?> TL</p>
    </div>
    <?php endif; ?>
</body>
</html> 