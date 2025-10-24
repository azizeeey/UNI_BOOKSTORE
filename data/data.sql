-- data.sql untuk proyek UNI_BOOKSTORE (BNSP)
-- Struktur tabel & data contoh sesuai soal

DROP DATABASE IF EXISTS uni_bookstore;
CREATE DATABASE uni_bookstore CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE uni_bookstore;

-- ==========================
-- TABEL PENERBIT
-- ==========================
CREATE TABLE penerbit (
    id_penerbit CHAR(5) PRIMARY KEY,
    nama_penerbit VARCHAR(100) NOT NULL,
    alamat VARCHAR(200),
    kota VARCHAR(100),
    telepon VARCHAR(30)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data PENERBIT
INSERT INTO penerbit (id_penerbit, nama_penerbit, alamat, kota, telepon) VALUES
('SP01', 'Penerbit Informatika', 'Jl. Buah Batu No. 121', 'Bandung', '0813-2220-1946'),
('SP02', 'Andi Offset', 'Jl. Suryalaya IX No.3', 'Bandung', '0878-3903-0688'),
('SP03', 'Danendra', 'Jl. Moch. Toha 44', 'Bandung', '022-5201215');

-- ==========================
-- TABEL BUKU
-- ==========================
CREATE TABLE buku (
    id_buku CHAR(5) PRIMARY KEY,
    kategori VARCHAR(50),
    nama_buku VARCHAR(150) NOT NULL,
    harga DECIMAL(12,2) DEFAULT 0.00,
    stok INT(11) DEFAULT 0,
    id_penerbit CHAR(5),
    FOREIGN KEY (id_penerbit) REFERENCES penerbit(id_penerbit)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data BUKU
INSERT INTO buku (id_buku, kategori, nama_buku, harga, stok, id_penerbit) VALUES
('K1001', 'Keilmuan', 'Analisis & Perancangan Sistem Informasi', 50000.00, 60, 'SP01'),
('K1002', 'Keilmuan', 'Artifical Intelligence', 45000.00, 60, 'SP01'),
('K2003', 'Keilmuan', 'Autocad 3 Dimensi', 40000.00, 25, 'SP01'),
('B1001', 'Bisnis', 'Bisnis Online', 75000.00, 9, 'SP01'),
('K3004', 'Keilmuan', 'Cloud Computing Technology', 85000.00, 15, 'SP01'),
('B1002', 'Bisnis', 'Etika Bisnis dan Tanggung Jawab Sosial', 67500.00, 20, 'SP01'),
('N1001', 'Novel', 'Cahaya Di Penjuru Hati', 68000.00, 10, 'SP02'),
('N1002', 'Novel', 'Aku Ingin Cerita', 48000.00, 12, 'SP03');
