<?php
require_once 'db_connect.php';

// Filmleri getir
$filmler = mysqli_query($conn, "SELECT * FROM filmler");
if (!$filmler) {
    die("Film sorgusu hatası: " . mysqli_error($conn));
}

// Salonları getir
$salonlar = mysqli_query($conn, "SELECT * FROM salonlar");

// Bilet alma işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isim = $_POST['isim'];
    $film = $_POST['film'];
    $salon = $_POST['salon'];
    $koltuk = $_POST['koltuk'];
    $kart = $_POST['kart'];
    $tarih = $_POST['tarih'];
    $cvv = $_POST['cvv'];

    // Boş alan kontrolü
    if (empty($isim) || empty($film) || empty($salon) || empty($koltuk) || empty($kart) || empty($tarih) || empty($cvv)) {
        echo "<div style='color: red; background: white; padding: 10px; margin: 10px auto; width: 300px;'>Tüm alanları doldurun!</div>";
    } else {
        // Kart kontrolü
        if (strlen($kart) != 16) {
            echo "<div style='color: red; background: white; padding: 10px; margin: 10px auto; width: 300px;'>Kart numarası 16 haneli olmalı!</div>";
        } else if (strlen($cvv) != 3) {
            echo "<div style='color: red; background: white; padding: 10px; margin: 10px auto; width: 300px;'>CVV 3 haneli olmalı!</div>";
        } else {
            // Film fiyatını al
            $film_query = mysqli_query($conn, "SELECT film_fiyat FROM filmler WHERE id = '$film'");
            $film_data = mysqli_fetch_assoc($film_query);
            $fiyat = $film_data['film_fiyat'];

            // Bileti veritabanına kaydet
            $sql = "INSERT INTO biletler (isim_soyisim, film_id, salon_id, koltuk_no, fiyat) 
                    VALUES ('$isim', '$film', '$salon', '$koltuk', '$fiyat')";
            
            if (mysqli_query($conn, $sql)) {
                echo "<div style='color: green; background: white; padding: 10px; margin: 10px auto; width: 300px;'>Bilet başarıyla alındı!</div>";
            } else {
                echo "<div style='color: red; background: white; padding: 10px; margin: 10px auto; width: 300px;'>Hata: " . mysqli_error($conn) . "</div>";
            }
        }
    }
}

// Filmleri tekrar getir (form için)
$filmler = mysqli_query($conn, "SELECT * FROM filmler");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sinema Bilet Sistemi</title>
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
    </style>
</head>
<body>
    <div class="menu">
        <a href="index.php">Anasayfa</a>
        <a href="iptal.php">Bilet İptal</a>
        <a href="admin.php">Yönetim Paneli</a>
    </div>

    <h1>Sinema Bilet Sistemi</h1>
    
    <div class="form-kutu">
        <form method="POST">
            <h2>Ad Soyad</h2>
            <input type="text" name="isim" required>

            <h2>Film Seç</h2>
            <select name="film" required>
                <option value="">Film Seçin</option>
                <?php while($film = mysqli_fetch_assoc($filmler)) { ?>
                    <option value="<?php echo $film['id']; ?>">
                        <?php echo $film['film_adi']; ?> - <?php echo isset($film['film_fiyat']) ? $film['film_fiyat'] : 'Fiyat Yok'; ?> TL
                    </option>
                <?php } ?>
            </select>

            <h2>Salon Seç</h2>
            <select name="salon" required>
                <option value="">Salon Seçin</option>
                <?php while($salon = mysqli_fetch_assoc($salonlar)) { ?>
                    <option value="<?php echo $salon['id']; ?>">
                        Salon <?php echo $salon['salon_no']; ?>
                    </option>
                <?php } ?>
            </select>

            <h2>Koltuk Seç</h2>
            <select name="koltuk" required>
                <option value="">Koltuk Seçin</option>
                <?php 
                for($i = 1; $i <= 10; $i++) { 
                    echo "<option value='A$i'>A$i</option>";
                }
                ?>
            </select>

            <h2>Kart Bilgileri</h2>
            <input type="text" name="kart" placeholder="Kart Numarası" maxlength="16" required>
            <input type="text" name="tarih" placeholder="Son Kullanma (AA/YY)" maxlength="5" required>
            <input type="text" name="cvv" placeholder="CVV" maxlength="3" required>

            <button type="submit">Bilet Al</button>
        </form>
    </div>
</body>
</html> 