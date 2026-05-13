-- ============================================================
-- Database: bandarajaya
-- Sistem Manajemen Bandara Raya Jaya
-- ============================================================

CREATE DATABASE IF NOT EXISTS bandarajaya;
USE bandarajaya;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS BAGASI;
DROP TABLE IF EXISTS BOARDINGPASS;
DROP TABLE IF EXISTS CHECKIN;
DROP TABLE IF EXISTS DETAIL_PEMBAYARAN;
DROP TABLE IF EXISTS GATE;
DROP TABLE IF EXISTS KURSI;
DROP TABLE IF EXISTS MASKAPAI;
DROP TABLE IF EXISTS METODE_PEMBAYARAN;
DROP TABLE IF EXISTS PEMBAYARAN;
DROP TABLE IF EXISTS PENERBANGAN;
DROP TABLE IF EXISTS PENUMPANG;
DROP TABLE IF EXISTS PESAWAT;
DROP TABLE IF EXISTS TIKET;

SET FOREIGN_KEY_CHECKS = 1;

/*==============================================================*/
/* Table: MASKAPAI                                              */
/*==============================================================*/
CREATE TABLE MASKAPAI
(
   ID_MASKAPAI          INT NOT NULL AUTO_INCREMENT,
   NAMA_MASKAPAI        VARCHAR(100),
   KODE_MASKAPAI        VARCHAR(50),
   NEGARA_ASAL          VARCHAR(50),
   NO_KONTAK            VARCHAR(20),
   PRIMARY KEY (ID_MASKAPAI)
) ENGINE=InnoDB;

/*==============================================================*/
/* Table: PESAWAT                                               */
/*==============================================================*/
CREATE TABLE PESAWAT
(
   ID_PESAWAT           INT NOT NULL AUTO_INCREMENT,
   ID_MASKAPAI          INT NOT NULL,
   TIPE_PESAWAT         VARCHAR(20),
   KAPASITAS            INT,
   TAHUN_PRODUKSI       INT,
   PRIMARY KEY (ID_PESAWAT)
) ENGINE=InnoDB;

/*==============================================================*/
/* Table: GATE                                                  */
/*==============================================================*/
CREATE TABLE GATE
(
   ID_GATE              INT NOT NULL AUTO_INCREMENT,
   NOMOR_GATE           VARCHAR(10),
   TERMINAL             VARCHAR(10),
   PRIMARY KEY (ID_GATE)
) ENGINE=InnoDB;

/*==============================================================*/
/* Table: PENERBANGAN                                           */
/*==============================================================*/
CREATE TABLE PENERBANGAN
(
   ID_PENERBANGAN       INT NOT NULL AUTO_INCREMENT,
   ID_PESAWAT           INT,
   ID_GATE              INT,
   TANGGAL_BERANGKAT    DATE,
   WAKTU_BERANGKAT      TIME,
   KOTA_ASAL            VARCHAR(100),
   KOTA_TUJUAN          VARCHAR(100),
   PRIMARY KEY (ID_PENERBANGAN)
) ENGINE=InnoDB;

/*==============================================================*/
/* Table: PENUMPANG                                             */
/*==============================================================*/
CREATE TABLE PENUMPANG
(
   ID_PENUMPANG         INT NOT NULL AUTO_INCREMENT,
   NAMA_PENUMPANG       VARCHAR(100),
   NO_IDENTITAS         VARCHAR(100),
   JENIS_KELAMIN        VARCHAR(20),
   TANGGAL_LAHIR        DATE,
   NO_TELP              VARCHAR(20),
   PRIMARY KEY (ID_PENUMPANG)
) ENGINE=InnoDB;

/*==============================================================*/
/* Table: METODE_PEMBAYARAN                                     */
/*==============================================================*/
CREATE TABLE METODE_PEMBAYARAN
(
   ID_METODE            INT NOT NULL AUTO_INCREMENT,
   TIPE_PEMBAYARAN      VARCHAR(50),
   PRIMARY KEY (ID_METODE)
) ENGINE=InnoDB;

/*==============================================================*/
/* Table: PEMBAYARAN                                            */
/*==============================================================*/
CREATE TABLE PEMBAYARAN
(
   ID_PEMBAYARAN        INT NOT NULL AUTO_INCREMENT,
   ID_METODE            INT,
   JUMLAH_TIKET         INT,
   TOTAL_HARGA          FLOAT(10,2),
   PRIMARY KEY (ID_PEMBAYARAN)
) ENGINE=InnoDB;

/*==============================================================*/
/* Table: DETAIL_PEMBAYARAN                                     */
/*==============================================================*/
CREATE TABLE DETAIL_PEMBAYARAN
(
   ID_MEMBAYAR          INT NOT NULL AUTO_INCREMENT,
   ID_PEMBAYARAN        INT,
   ID_TIKET             INT,
   TGL_BAYAR            DATETIME,
   JUMLAH_BAYAR         FLOAT(10,2),
   STATUS_PEMBAYARAN    VARCHAR(20),
   PRIMARY KEY (ID_MEMBAYAR)
) ENGINE=InnoDB;

/*==============================================================*/
/* Table: TIKET                                                 */
/*==============================================================*/
CREATE TABLE TIKET
(
   ID_TIKET             INT NOT NULL AUTO_INCREMENT,
   ID_PENUMPANG         INT,
   ID_MEMBAYAR          INT,
   ID_PENERBANGAN       INT,
   NOMER_TIKET          VARCHAR(30),
   HARGA                DECIMAL(12,2),
   PRIMARY KEY (ID_TIKET)
) ENGINE=InnoDB;

/*==============================================================*/
/* Table: CHECKIN                                               */
/*==============================================================*/
CREATE TABLE CHECKIN
(
   ID_CHECKIN           INT NOT NULL AUTO_INCREMENT,
   ID_TIKET             INT,
   ID_KURSI             INT,
   WAKTU_CHECKIN        DATETIME,
   PRIMARY KEY (ID_CHECKIN)
) ENGINE=InnoDB;

/*==============================================================*/
/* Table: KURSI                                                 */
/*==============================================================*/
CREATE TABLE KURSI
(
   ID_KURSI             INT NOT NULL AUTO_INCREMENT,
   ID_PESAWAT           INT,
   KELAS_PENERBANAN     VARCHAR(20),
   NO_KURSI2            VARCHAR(20),
   PRIMARY KEY (ID_KURSI)
) ENGINE=InnoDB;

/*==============================================================*/
/* Table: BAGASI                                                */
/*==============================================================*/
CREATE TABLE BAGASI
(
   ID_BAGASI            INT NOT NULL AUTO_INCREMENT,
   ID_CHECKIN           INT,
   BERAT_BAGASI         DECIMAL(8,2),
   STATUS_BAGASI        VARCHAR(15),
   PRIMARY KEY (ID_BAGASI)
) ENGINE=InnoDB;

/*==============================================================*/
/* Table: BOARDINGPASS                                          */
/*==============================================================*/
CREATE TABLE BOARDINGPASS
(
   ID_BOARDING          INT NOT NULL AUTO_INCREMENT,
   ID_CHECKIN           INT,
   ID_GATE              INT,
   WAKTU_BOARDING       TIME,
   PRIMARY KEY (ID_BOARDING)
) ENGINE=InnoDB;

/*==============================================================*/
/* Foreign Keys                                                 */
/*==============================================================*/

ALTER TABLE PESAWAT ADD CONSTRAINT FK_MEMILIKI FOREIGN KEY (ID_MASKAPAI)
      REFERENCES MASKAPAI (ID_MASKAPAI) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE PENERBANGAN ADD CONSTRAINT FK_MELAYANI FOREIGN KEY (ID_PESAWAT)
      REFERENCES PESAWAT (ID_PESAWAT) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE PENERBANGAN ADD CONSTRAINT FK_MELEWATI FOREIGN KEY (ID_GATE)
      REFERENCES GATE (ID_GATE) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE PEMBAYARAN ADD CONSTRAINT FK_MEMILIH FOREIGN KEY (ID_METODE)
      REFERENCES METODE_PEMBAYARAN (ID_METODE) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE DETAIL_PEMBAYARAN ADD CONSTRAINT FK_MEMBAYAR FOREIGN KEY (ID_PEMBAYARAN)
      REFERENCES PEMBAYARAN (ID_PEMBAYARAN) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE TIKET ADD CONSTRAINT FK_MEMBELI FOREIGN KEY (ID_PENUMPANG)
      REFERENCES PENUMPANG (ID_PENUMPANG) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE TIKET ADD CONSTRAINT FK_MENJUAL FOREIGN KEY (ID_PENERBANGAN)
      REFERENCES PENERBANGAN (ID_PENERBANGAN) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE CHECKIN ADD CONSTRAINT FK_MEMPROSES2 FOREIGN KEY (ID_TIKET)
      REFERENCES TIKET (ID_TIKET) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE KURSI ADD CONSTRAINT FK_MEMPUNYAI FOREIGN KEY (ID_PESAWAT)
      REFERENCES PESAWAT (ID_PESAWAT) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE BAGASI ADD CONSTRAINT FK_MENDAFTARKAN FOREIGN KEY (ID_CHECKIN)
      REFERENCES CHECKIN (ID_CHECKIN) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE BOARDINGPASS ADD CONSTRAINT FK_MENCETAK FOREIGN KEY (ID_CHECKIN)
      REFERENCES CHECKIN (ID_CHECKIN) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE BOARDINGPASS ADD CONSTRAINT FK_MENEMPATKAN FOREIGN KEY (ID_GATE)
      REFERENCES GATE (ID_GATE) ON DELETE RESTRICT ON UPDATE RESTRICT;

/*==============================================================*/
/* Sample Data                                                  */
/*==============================================================*/

-- Maskapai
INSERT INTO MASKAPAI (NAMA_MASKAPAI, KODE_MASKAPAI, NEGARA_ASAL, NO_KONTAK) VALUES
('Garuda Indonesia', 'GA', 'Indonesia', '021-23519999'),
('Lion Air', 'JT', 'Indonesia', '021-63798000'),
('Batik Air', 'ID', 'Indonesia', '021-63798000'),
('Citilink', 'QG', 'Indonesia', '0804-1080808'),
('Sriwijaya Air', 'SJ', 'Indonesia', '021-29279777');

-- Pesawat
INSERT INTO PESAWAT (ID_MASKAPAI, TIPE_PESAWAT, KAPASITAS, TAHUN_PRODUKSI) VALUES
(1, 'Boeing 737-800', 186, 2018),
(1, 'Airbus A330-300', 360, 2019),
(2, 'Boeing 737-900ER', 213, 2017),
(3, 'Airbus A320', 156, 2020),
(4, 'ATR 72-600', 72, 2021),
(5, 'Boeing 737-500', 120, 2015);

-- Gate
INSERT INTO GATE (NOMOR_GATE, TERMINAL) VALUES
('A1', '1'),
('A2', '1'),
('A3', '1'),
('B1', '2'),
('B2', '2'),
('B3', '2'),
('C1', '3'),
('C2', '3');

-- Penerbangan
INSERT INTO PENERBANGAN (ID_PESAWAT, ID_GATE, TANGGAL_BERANGKAT, WAKTU_BERANGKAT, KOTA_ASAL, KOTA_TUJUAN) VALUES
(1, 1, '2026-05-15', '06:30:00', 'Jakarta', 'Surabaya'),
(2, 4, '2026-05-15', '08:00:00', 'Jakarta', 'Bali'),
(3, 2, '2026-05-15', '10:15:00', 'Jakarta', 'Medan'),
(4, 5, '2026-05-16', '07:00:00', 'Jakarta', 'Yogyakarta'),
(5, 7, '2026-05-16', '14:30:00', 'Jakarta', 'Makassar'),
(1, 3, '2026-05-17', '09:00:00', 'Surabaya', 'Jakarta'),
(6, 6, '2026-05-17', '11:00:00', 'Jakarta', 'Palembang');

-- Penumpang
INSERT INTO PENUMPANG (NAMA_PENUMPANG, NO_IDENTITAS, JENIS_KELAMIN, TANGGAL_LAHIR, NO_TELP) VALUES
('Ahmad Fadillah', '3201234567890001', 'Laki-laki', '1990-05-15', '081234567890'),
('Siti Nurhaliza', '3201234567890002', 'Perempuan', '1988-08-22', '085678901234'),
('Budi Santoso', '3201234567890003', 'Laki-laki', '1995-01-10', '087890123456'),
('Dewi Kartika', '3201234567890004', 'Perempuan', '1992-12-05', '089012345678'),
('Rizki Pratama', '3201234567890005', 'Laki-laki', '2000-03-20', '082345678901');

-- Metode Pembayaran
INSERT INTO METODE_PEMBAYARAN (TIPE_PEMBAYARAN) VALUES
('Transfer Bank'),
('Kartu Kredit'),
('E-Wallet'),
('Virtual Account'),
('Tunai');

-- Kursi
INSERT INTO KURSI (ID_PESAWAT, KELAS_PENERBANAN, NO_KURSI2) VALUES
(1, 'Ekonomi', '1A'),
(1, 'Ekonomi', '1B'),
(1, 'Ekonomi', '1C'),
(1, 'Bisnis', '2A'),
(1, 'Bisnis', '2B'),
(2, 'Ekonomi', '1A'),
(2, 'Ekonomi', '1B'),
(2, 'Bisnis', '2A'),
(3, 'Ekonomi', '1A'),
(3, 'Ekonomi', '1B'),
(4, 'Ekonomi', '1A'),
(4, 'Ekonomi', '1B'),
(5, 'Ekonomi', '1A'),
(6, 'Ekonomi', '1A');
