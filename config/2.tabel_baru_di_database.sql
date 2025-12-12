-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Des 2025 pada 10.32
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `abdinega_db_raporkm`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `deskripsi_kokurikuler`
--

CREATE TABLE `deskripsi_kokurikuler` (
  `id_deskripsi` int(11) NOT NULL,
  `kriteria` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `contoh` varchar(255) NOT NULL,
  `nilai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `deskripsi_kokurikuler`
--

INSERT INTO `deskripsi_kokurikuler` (`id_deskripsi`, `kriteria`, `keterangan`, `contoh`, `nilai`) VALUES
(1, 'Kurang', 'Kurang', '', 1),
(2, 'Cukup', 'Cukup', '', 2),
(3, 'Baik', 'Baik', '', 3),
(4, 'Sangat Baik', 'Sangat baik', '', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `dimensi_kokurikuler`
--

CREATE TABLE `dimensi_kokurikuler` (
  `id_dimensi` int(11) NOT NULL,
  `dimensi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dimensi_kokurikuler`
--

INSERT INTO `dimensi_kokurikuler` (`id_dimensi`, `dimensi`) VALUES
(1, 'Keimanan dan Ketakwaan terhadap Tuhan Yang Maha Esa'),
(2, 'Kewarganegara'),
(3, 'Penalaran Kritis'),
(4, 'Kreativitas'),
(5, 'Kolaborasi'),
(6, 'Kemandirian'),
(7, 'Kesehatan'),
(8, 'Komunikasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_kokurikuler`
--

CREATE TABLE `nilai_kokurikuler` (
  `id_nilai_kokurikuler` int(11) NOT NULL,
  `id_proyek_kelas` int(11) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `id_proyek_tujuan` int(11) DEFAULT NULL,
  `nilai` int(11) DEFAULT NULL,
  `nama_panggilan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `nilai_kokurikuler`
--

INSERT INTO `nilai_kokurikuler` (`id_nilai_kokurikuler`, `id_proyek_kelas`, `semester`, `tahun`, `id_siswa`, `id_proyek_tujuan`, `nilai`, `nama_panggilan`) VALUES
(9, 31, 1, 2, 258, 2, 4, 'CHOKY'),
(10, 31, 1, 2, 259, 2, 3, 'JEIN'),
(11, 31, 1, 2, 260, 2, 0, 'PUTRI'),
(12, 31, 1, 2, 261, 2, 0, 'RAHMAD'),
(13, 31, 1, 2, 262, 2, 0, 'RENI'),
(14, 31, 1, 2, 263, 2, 0, 'SITI'),
(15, 31, 1, 2, 264, 2, 0, 'TOTOK'),
(16, 31, 1, 2, 265, 2, 0, 'ZASKIA'),
(17, 31, 1, 2, 258, 3, 4, 'CHOKY'),
(18, 31, 1, 2, 259, 3, 4, 'JEIN'),
(19, 31, 1, 2, 260, 3, 0, 'PUTRI'),
(20, 31, 1, 2, 261, 3, 0, 'RAHMAD'),
(21, 31, 1, 2, 262, 3, 0, 'RENI'),
(22, 31, 1, 2, 263, 3, 0, 'SITI'),
(23, 31, 1, 2, 264, 3, 0, 'TOTOK'),
(24, 31, 1, 2, 265, 3, 0, 'ZASKIA');

-- --------------------------------------------------------

--
-- Struktur dari tabel `proyek_tujuan`
--

CREATE TABLE `proyek_tujuan` (
  `id_proyek_tujuan` int(11) NOT NULL,
  `id_proyek_kelas` int(11) DEFAULT NULL,
  `id_dimensi` int(11) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `proyek_tujuan`
--

INSERT INTO `proyek_tujuan` (`id_proyek_tujuan`, `id_proyek_kelas`, `id_dimensi`, `deskripsi`) VALUES
(4, 31, 2, 'Kegiatan Pemilihan Ketua OSIS dan Wakil Ketua OSIS');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `deskripsi_kokurikuler`
--
ALTER TABLE `deskripsi_kokurikuler`
  ADD PRIMARY KEY (`id_deskripsi`);

--
-- Indeks untuk tabel `dimensi_kokurikuler`
--
ALTER TABLE `dimensi_kokurikuler`
  ADD PRIMARY KEY (`id_dimensi`);

--
-- Indeks untuk tabel `nilai_kokurikuler`
--
ALTER TABLE `nilai_kokurikuler`
  ADD PRIMARY KEY (`id_nilai_kokurikuler`);

--
-- Indeks untuk tabel `proyek_tujuan`
--
ALTER TABLE `proyek_tujuan`
  ADD PRIMARY KEY (`id_proyek_tujuan`),
  ADD KEY `id_proyek_kelas` (`id_proyek_kelas`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `deskripsi_kokurikuler`
--
ALTER TABLE `deskripsi_kokurikuler`
  MODIFY `id_deskripsi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `dimensi_kokurikuler`
--
ALTER TABLE `dimensi_kokurikuler`
  MODIFY `id_dimensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `nilai_kokurikuler`
--
ALTER TABLE `nilai_kokurikuler`
  MODIFY `id_nilai_kokurikuler` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `proyek_tujuan`
--
ALTER TABLE `proyek_tujuan`
  MODIFY `id_proyek_tujuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `proyek_tujuan`
--
ALTER TABLE `proyek_tujuan`
  ADD CONSTRAINT `proyek_tujuan_ibfk_1` FOREIGN KEY (`id_proyek_kelas`) REFERENCES `proyek_kelas` (`id_proyek_kelas`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
