-- ============================================================
-- Migration: Catalog Jenis Pesawat + Profil Maskapai
-- Sistem Maskapai - Airline Management System
-- ============================================================

USE bandarajaya;

SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
-- 1. Tabel CATALOG_PESAWAT (Template Jenis Pesawat)
-- ============================================================
DROP TABLE IF EXISTS CATALOG_KELAS;
DROP TABLE IF EXISTS CATALOG_PESAWAT;

CREATE TABLE CATALOG_PESAWAT (
    ID_CATALOG       INT NOT NULL AUTO_INCREMENT,
    TIPE_PESAWAT     VARCHAR(50) NOT NULL,
    KODE_TIPE        VARCHAR(20) NOT NULL,
    KATEGORI         VARCHAR(20) NOT NULL DEFAULT 'Narrow-body',
    TOTAL_KAPASITAS  INT NOT NULL DEFAULT 0,
    DESKRIPSI        TEXT,
    PRIMARY KEY (ID_CATALOG)
) ENGINE=InnoDB;

-- ============================================================
-- 2. Tabel CATALOG_KELAS (Konfigurasi Kelas per Catalog)
-- ============================================================
CREATE TABLE CATALOG_KELAS (
    ID_CATALOG_KELAS INT NOT NULL AUTO_INCREMENT,
    ID_CATALOG       INT NOT NULL,
    NAMA_KELAS       VARCHAR(30) NOT NULL,
    LAYOUT_KURSI     VARCHAR(10) NOT NULL,
    BARIS_MULAI      INT NOT NULL,
    BARIS_AKHIR      INT NOT NULL,
    HURUF_KURSI      VARCHAR(20) NOT NULL,
    WARNA_KELAS      VARCHAR(15) DEFAULT '#3b82f6',
    PRIMARY KEY (ID_CATALOG_KELAS),
    FOREIGN KEY (ID_CATALOG) REFERENCES CATALOG_PESAWAT(ID_CATALOG) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- 3. Modifikasi Tabel PESAWAT (Tambah ID_CATALOG)
-- ============================================================
ALTER TABLE PESAWAT ADD COLUMN ID_CATALOG INT NULL AFTER ID_MASKAPAI;
ALTER TABLE PESAWAT ADD COLUMN KODE_PESAWAT VARCHAR(20) NULL AFTER TIPE_PESAWAT;
ALTER TABLE PESAWAT ADD COLUMN STATUS_PESAWAT VARCHAR(20) DEFAULT 'Aktif' AFTER TAHUN_PRODUKSI;

-- ============================================================
-- 4. Modifikasi Tabel KURSI (Tambah STATUS_KURSI jika belum ada)
-- ============================================================
-- Kolom KELAS_PENERBANAN sudah ada, akan digunakan untuk kelas dari catalog
-- Tambah STATUS_KURSI jika belum ada
ALTER TABLE KURSI ADD COLUMN STATUS_KURSI VARCHAR(20) DEFAULT 'Tersedia';

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- 5. Seed Data: Catalog Jenis Pesawat
-- ============================================================

-- Catalog 1: Boeing 737-800 (2 Class - 162 seat)
INSERT INTO CATALOG_PESAWAT (TIPE_PESAWAT, KODE_TIPE, KATEGORI, TOTAL_KAPASITAS, DESKRIPSI) VALUES
('Boeing 737-800 (2 Class)', 'B738-2C', 'Narrow-body', 162, 'Konfigurasi 2 kelas: 8 Business + 154 Economy. Layout 3-3. Umum digunakan Garuda Indonesia.');

INSERT INTO CATALOG_KELAS (ID_CATALOG, NAMA_KELAS, LAYOUT_KURSI, BARIS_MULAI, BARIS_AKHIR, HURUF_KURSI) VALUES
(1, 'Business', '2-2', 1, 2, 'ABCD'),
(1, 'Ekonomi', '3-3', 3, 28, 'ABCDEF');

-- Catalog 2: Boeing 737-800 (All Economy - 189 seat)
INSERT INTO CATALOG_PESAWAT (TIPE_PESAWAT, KODE_TIPE, KATEGORI, TOTAL_KAPASITAS, DESKRIPSI) VALUES
('Boeing 737-800 (All Economy)', 'B738-EC', 'Narrow-body', 189, 'Konfigurasi all economy 189 kursi. Layout 3-3. Umum digunakan Lion Air.');

INSERT INTO CATALOG_KELAS (ID_CATALOG, NAMA_KELAS, LAYOUT_KURSI, BARIS_MULAI, BARIS_AKHIR, HURUF_KURSI) VALUES
(2, 'Ekonomi', '3-3', 1, 32, 'ABCDEF');

-- Catalog 3: Boeing 737-900ER (All Economy - 215 seat)
INSERT INTO CATALOG_PESAWAT (TIPE_PESAWAT, KODE_TIPE, KATEGORI, TOTAL_KAPASITAS, DESKRIPSI) VALUES
('Boeing 737-900ER', 'B739', 'Narrow-body', 215, 'Konfigurasi all economy 215 kursi. Layout 3-3. Digunakan Lion Air.');

INSERT INTO CATALOG_KELAS (ID_CATALOG, NAMA_KELAS, LAYOUT_KURSI, BARIS_MULAI, BARIS_AKHIR, HURUF_KURSI) VALUES
(3, 'Ekonomi', '3-3', 1, 36, 'ABCDEF');

-- Catalog 4: Airbus A320 (2 Class - 156 seat)
INSERT INTO CATALOG_PESAWAT (TIPE_PESAWAT, KODE_TIPE, KATEGORI, TOTAL_KAPASITAS, DESKRIPSI) VALUES
('Airbus A320 (2 Class)', 'A320-2C', 'Narrow-body', 156, 'Konfigurasi 2 kelas: 8 Business + 148 Economy. Layout 3-3. Umum digunakan Batik Air.');

INSERT INTO CATALOG_KELAS (ID_CATALOG, NAMA_KELAS, LAYOUT_KURSI, BARIS_MULAI, BARIS_AKHIR, HURUF_KURSI) VALUES
(4, 'Business', '2-2', 1, 2, 'ABCD'),
(4, 'Ekonomi', '3-3', 3, 27, 'ABCDEF');

-- Catalog 5: Airbus A320 (All Economy - 180 seat)
INSERT INTO CATALOG_PESAWAT (TIPE_PESAWAT, KODE_TIPE, KATEGORI, TOTAL_KAPASITAS, DESKRIPSI) VALUES
('Airbus A320 (All Economy)', 'A320-EC', 'Narrow-body', 180, 'Konfigurasi all economy 180 kursi. Layout 3-3. Citilink, AirAsia.');

INSERT INTO CATALOG_KELAS (ID_CATALOG, NAMA_KELAS, LAYOUT_KURSI, BARIS_MULAI, BARIS_AKHIR, HURUF_KURSI) VALUES
(5, 'Ekonomi', '3-3', 1, 30, 'ABCDEF');

-- Catalog 6: Airbus A330-300 (2 Class - 251 seat)
INSERT INTO CATALOG_PESAWAT (TIPE_PESAWAT, KODE_TIPE, KATEGORI, TOTAL_KAPASITAS, DESKRIPSI) VALUES
('Airbus A330-300 (2 Class)', 'A333-2C', 'Wide-body', 251, 'Konfigurasi 2 kelas: 30 Business (2-2-2) + 221 Economy (2-4-2). Wide-body. Garuda Indonesia.');

INSERT INTO CATALOG_KELAS (ID_CATALOG, NAMA_KELAS, LAYOUT_KURSI, BARIS_MULAI, BARIS_AKHIR, HURUF_KURSI) VALUES
(6, 'Business', '2-2-2', 1, 5, 'ABCDEF'),
(6, 'Ekonomi', '2-4-2', 10, 38, 'ABCDEFGH');

-- Catalog 7: ATR 72-600 (All Economy - 72 seat)
INSERT INTO CATALOG_PESAWAT (TIPE_PESAWAT, KODE_TIPE, KATEGORI, TOTAL_KAPASITAS, DESKRIPSI) VALUES
('ATR 72-600', 'AT76', 'Turboprop', 72, 'Pesawat turboprop regional. Konfigurasi all economy 72 kursi. Layout 2-2. Wings Air.');

INSERT INTO CATALOG_KELAS (ID_CATALOG, NAMA_KELAS, LAYOUT_KURSI, BARIS_MULAI, BARIS_AKHIR, HURUF_KURSI) VALUES
(7, 'Ekonomi', '2-2', 1, 18, 'ABCD');

-- Catalog 8: Boeing 737-500 (All Economy - 120 seat)
INSERT INTO CATALOG_PESAWAT (TIPE_PESAWAT, KODE_TIPE, KATEGORI, TOTAL_KAPASITAS, DESKRIPSI) VALUES
('Boeing 737-500', 'B735', 'Narrow-body', 120, 'Pesawat narrow-body generasi lama. Konfigurasi all economy 120 kursi. Layout 3-3.');

INSERT INTO CATALOG_KELAS (ID_CATALOG, NAMA_KELAS, LAYOUT_KURSI, BARIS_MULAI, BARIS_AKHIR, HURUF_KURSI) VALUES
(8, 'Ekonomi', '3-3', 1, 20, 'ABCDEF');
