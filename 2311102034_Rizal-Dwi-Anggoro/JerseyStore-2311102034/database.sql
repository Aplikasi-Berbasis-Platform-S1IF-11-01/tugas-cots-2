CREATE DATABASE IF NOT EXISTS db_jersey_store
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE db_jersey_store;

-- ============================================================
-- Tabel: jerseys
-- ============================================================
CREATE TABLE IF NOT EXISTS jerseys (
    id          INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode        VARCHAR(20)  NOT NULL UNIQUE,
    nama        VARCHAR(150) NOT NULL,
    klub        VARCHAR(100) NOT NULL,
    liga        VARCHAR(100) NOT NULL,
    musim       VARCHAR(20)  NOT NULL,
    ukuran      ENUM('S','M','L','XL','XXL') NOT NULL DEFAULT 'M',
    jenis       ENUM('Home','Away','Third','GK','Training') NOT NULL DEFAULT 'Home',
    harga       DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    stok        INT(5) UNSIGNED NOT NULL DEFAULT 0,
    deskripsi   TEXT,
    gambar      VARCHAR(255) DEFAULT NULL,
    status      ENUM('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Data Contoh
-- ============================================================
INSERT INTO jerseys (kode, nama, klub, liga, musim, ukuran, jenis, harga, stok, deskripsi, status) VALUES
('JRS-001', 'Real Madrid Home 2024/25',       'Real Madrid',          'La Liga',        '2024/2025', 'L',   'Home',     450000, 15, 'Jersey home Real Madrid musim 2024/2025 bahan premium breathable', 'Aktif'),
('JRS-002', 'Manchester City Away 2024/25',   'Manchester City',      'Premier League', '2024/2025', 'M',   'Away',     480000, 10, 'Jersey away Manchester City warna biru muda elegan', 'Aktif'),
('JRS-003', 'Barcelona Third 2024/25',        'Barcelona',            'La Liga',        '2024/2025', 'XL',  'Third',    500000,  8, 'Jersey third Barcelona edisi spesial', 'Aktif'),
('JRS-004', 'Arsenal Home 2024/25',           'Arsenal',              'Premier League', '2024/2025', 'S',   'Home',     430000, 20, 'Jersey home Arsenal merah klasik', 'Aktif'),
('JRS-005', 'PSG Away 2024/25',               'Paris Saint-Germain',  'Ligue 1',        '2024/2025', 'L',   'Away',     520000,  5, 'Jersey away PSG dengan detail emas', 'Aktif'),
('JRS-006', 'Bayern Munich Home 2024/25',     'Bayern Munich',        'Bundesliga',     '2024/2025', 'M',   'Home',     470000, 12, 'Jersey home Bayern Munich merah tradisional', 'Aktif'),
('JRS-007', 'Juventus Third 2023/24',         'Juventus',             'Serie A',        '2023/2024', 'L',   'Third',    350000,  3, 'Jersey third Juventus hitam-putih', 'Nonaktif'),
('JRS-008', 'Liverpool Home 2024/25',         'Liverpool',            'Premier League', '2024/2025', 'XXL', 'Home',     460000, 18, 'Jersey home Liverpool merah ikonik Anfield', 'Aktif');
