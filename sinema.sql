-- Veritabanını oluştur
CREATE DATABASE IF NOT EXISTS sinema;
USE sinema;

-- filmler tablosunu oluştur
CREATE TABLE filmler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    film_adi VARCHAR(100) NOT NULL
);

-- salonlar tablosunu oluştur
CREATE TABLE salonlar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    salon_no VARCHAR(20) NOT NULL
);

-- seanslar tablosunu oluştur
CREATE TABLE seanslar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    film_id INT NOT NULL,
    saat VARCHAR(5) NOT NULL,
    salon_id INT NOT NULL,
    FOREIGN KEY (film_id) REFERENCES filmler(id),
    FOREIGN KEY (salon_id) REFERENCES salonlar(id)
);

-- biletler tablosunu oluştur
CREATE TABLE biletler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    isim_soyisim VARCHAR(100) NOT NULL,
    koltuk_no VARCHAR(10) NOT NULL,
    seans_id INT NOT NULL,
    film_id INT NOT NULL,
    fiyat DECIMAL(10,2) NOT NULL,
    saat VARCHAR(5) NOT NULL,
    FOREIGN KEY (seans_id) REFERENCES seanslar(id),
    FOREIGN KEY (film_id) REFERENCES filmler(id)
);

-- Örnek film verileri
INSERT INTO filmler (film_adi) VALUES 
('Yüzüklerin Efendisi'),
('Inception'),
('Avatar');

-- Örnek salon verileri
INSERT INTO salonlar (salon_no) VALUES 
('Salon 1'),
('Salon 2'),
('Salon 3');

-- Örnek seans verileri
INSERT INTO seanslar (film_id, saat, salon_id) VALUES 
(1, '14:00', 1),
(1, '17:00', 2),
(2, '20:30', 1);

-- Örnek bilet verileri
INSERT INTO biletler (isim_soyisim, koltuk_no, seans_id, film_id, fiyat, saat) VALUES 
('Ahmet Yılmaz', 'A1', 1, 1, 50.00, '14:00'),
('Ayşe Demir', 'A2', 1, 1, 50.00, '14:00'),
('Mehmet Kaya', 'A3', 2, 1, 60.00, '17:00'); 