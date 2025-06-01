<?php
require_once 'db_connect.php';

// Film ekleme
if (isset($_POST['film_ekle'])) {
    $film_adi = $_POST['film_adi'];
    $film_suresi = $_POST['film_suresi'];
    $film_fiyat = $_POST['film_fiyat'];

    if (empty($film_adi) || empty($film_suresi) || empty($film_fiyat)) {
        echo "<div style='color: red; background: white; padding: 10px; margin: 10px auto; width: 300px;'>Tüm alanları doldurun!</div>";
    } else {
        $sql = "INSERT INTO filmler (film_adi, film_suresi, film_fiyat) VALUES ('$film_adi', '$film_suresi', '$film_fiyat')";
        if (mysqli_query($conn, $sql)) {
            echo "<div style='color: green; background: white; padding: 10px; margin: 10px auto; width: 300px;'>Film başarıyla eklendi!</div>";
        } else {
            echo "<div style='color: red; background: white; padding: 10px; margin: 10px auto; width: 300px;'>Hata: " . mysqli_error($conn) . "</div>";
        }
    }
}

// Seans ekleme
if (isset($_POST['seans_ekle'])) {
    $film_id = $_POST['film_id'];
    $salon_id = $_POST['salon_id'];
    $seans_saati = $_POST['seans_saati'];

    if (empty($film_id) || empty($salon_id) || empty($seans_saati)) {
        echo "<div style='color: red; background: white; padding: 10px; margin: 10px auto; width: 300px;'>Tüm alanları doldurun!</div>";
    } else {
        $sql = "INSERT INTO seanslar (film_id, salon_id, saat) VALUES ('$film_id', '$salon_id', '$seans_saati')";
        if (mysqli_query($conn, $sql)) {
            echo "<div style='color: green; background: white; padding: 10px; margin: 10px auto; width: 300px;'>Seans başarıyla eklendi!</div>";
        } else {
            echo "<div style='color: red; background: white; padding: 10px; margin: 10px auto; width: 300px;'>Hata: " . mysqli_error($conn) . "</div>";
        }
    }
}

// Filmleri getir
$filmler = mysqli_query($conn, "SELECT * FROM filmler");

// Salonları getir
$salonlar = mysqli_query($conn, "SELECT * FROM salonlar");

// Seansları getir
$seanslar = mysqli_query($conn, "SELECT seanslar.*, filmler.film_adi, salonlar.salon_no 
                                FROM seanslar 
                                JOIN filmler ON seanslar.film_id = filmler.id 
                                JOIN salonlar ON seanslar.salon_id = salonlar.id");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yönetim Paneli - Sinema Bilet Sistemi</title>
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

        table {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            color: black;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <div class="menu">
        <a href="index.php">Anasayfa</a>
        <a href="iptal.php">Bilet İptal</a>
        <a href="admin.php">Yönetim Paneli</a>
    </div>

    <h1>Yönetim Paneli</h1>

    <div class="form-kutu">
        <h2>Film Ekle</h2>
        <form method="POST">
            <input type="text" name="film_adi" placeholder="Film Adı" required>
            <input type="text" name="film_suresi" placeholder="Film Süresi" required>
            <input type="number" name="film_fiyat" placeholder="Film Fiyatı" required>
            <button type="submit" name="film_ekle">Film Ekle</button>
        </form>
    </div>

    <div class="form-kutu">
        <h2>Seans Ekle</h2>
        <form method="POST">
            <select name="film_id" required>
                <option value="">Film Seçin</option>
                <?php while($film = mysqli_fetch_assoc($filmler)) { ?>
                    <option value="<?php echo $film['id']; ?>">
                        <?php echo $film['film_adi']; ?>
                    </option>
                <?php } ?>
            </select>

            <select name="salon_id" required>
                <option value="">Salon Seçin</option>
                <?php while($salon = mysqli_fetch_assoc($salonlar)) { ?>
                    <option value="<?php echo $salon['id']; ?>">
                        Salon <?php echo $salon['salon_no']; ?>
                    </option>
                <?php } ?>
            </select>

            <input type="time" name="seans_saati" required>
            <button type="submit" name="seans_ekle">Seans Ekle</button>
        </form>
    </div>

    <h2>Mevcut Seanslar</h2>
    <table>
        <tr>
            <th>Film</th>
            <th>Salon</th>
            <th>Seans Saati</th>
        </tr>
        <?php while($seans = mysqli_fetch_assoc($seanslar)) { ?>
            <tr>
                <td><?php echo $seans['film_adi']; ?></td>
                <td>Salon <?php echo $seans['salon_no']; ?></td>
                <td><?php echo isset($seans['saat']) ? $seans['saat'] : 'Belirtilmemiş'; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html> 