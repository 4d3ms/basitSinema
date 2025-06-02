-- Veritabanını oluştur
CREATE DATABASE IF NOT EXISTS sinema;
USE sinema;

-- filmler tablosunu oluştur
CREATE TABLE filmler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    film_adi VARCHAR(100) NOT NULL,
    film_suresi VARCHAR(10),
    film_fiyat DECIMAL(10,2)
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
    salon_id INT NOT NULL
);

-- biletler tablosunu oluştur
CREATE TABLE biletler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    isim_soyisim VARCHAR(100) NOT NULL,
    koltuk_no VARCHAR(10) NOT NULL,
    film_id INT NOT NULL,
    salon_id INT NOT NULL,
    fiyat DECIMAL(10,2) NOT NULL,
    saat VARCHAR(5) NOT NULL
);

-- Örnek film verileri
INSERT INTO filmler (film_adi, film_suresi, film_fiyat) VALUES 
('Yüzüklerin Efendisi', '180 dk', 50.00),
('Inception', '148 dk', 45.00),
('Avatar', '162 dk', 55.00);

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
INSERT INTO biletler (isim_soyisim, koltuk_no, film_id, salon_id, fiyat, saat) VALUES 
('Ahmet Yılmaz', 'A1', 1, 1, 50.00, '14:00'),
('Ayşe Demir', 'A2', 1, 1, 50.00, '14:00'),
('Mehmet Kaya', 'A3', 1, 2, 50.00, '17:00'); 