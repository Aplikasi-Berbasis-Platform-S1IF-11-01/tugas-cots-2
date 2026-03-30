-- ============================================
-- DATABASE: inventaris_barang
-- Framework: CodeIgniter 4
-- ============================================

CREATE DATABASE IF NOT EXISTS inventaris_barang
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE inventaris_barang;

CREATE TABLE IF NOT EXISTS barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(100) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    jumlah INT NOT NULL DEFAULT 0,
    harga DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample Data
INSERT INTO barang (nama_barang, kategori, jumlah, harga) VALUES
('Laptop Dell XPS 15', 'Elektronik', 5, 18500000.00),
('Mouse Logitech MX Master', 'Elektronik', 12, 1250000.00),
('Meja Kerja Kayu Jati', 'Furnitur', 3, 3200000.00),
('Kursi Ergonomis Herman Miller', 'Furnitur', 4, 8750000.00),
('Printer Canon PIXMA', 'Elektronik', 2, 2100000.00),
('Whiteboard 120x90cm', 'Peralatan Kantor', 6, 450000.00),
('Proyektor Epson EB-X41', 'Elektronik', 2, 5600000.00),
('Lemari Arsip Besi', 'Furnitur', 5, 1800000.00),
('Kertas A4 80gsm (rim)', 'ATK', 100, 55000.00),
('Tinta Printer Hitam', 'ATK', 24, 95000.00);
