-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Des 2025 pada 04.19
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Struktur dari tabel `absen`
--

CREATE TABLE `absen` (
  `id_absen` int(10) NOT NULL,
  `absen` text NOT NULL,
  `sort` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `agama`
--

CREATE TABLE `agama` (
  `id_agama` int(10) NOT NULL,
  `agama` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `bulanan`
--

CREATE TABLE `bulanan` (
  `id_bulanan` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `bulanan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `catatan_wali`
--

CREATE TABLE `catatan_wali` (
  `id_catatan` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `deskripsi_rapor`
--

CREATE TABLE `deskripsi_rapor` (
  `id_deskripsi` int(11) NOT NULL,
  `kriteria` varchar(15) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `contoh` text NOT NULL,
  `nilai` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dimensi`
--

CREATE TABLE `dimensi` (
  `id_dimensi` int(10) NOT NULL,
  `dimensi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dimensi_kokurikuler`
--

CREATE TABLE `dimensi_kokurikuler` (
  `id_dimensi` int(11) NOT NULL,
  `dimensi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `elemen`
--

CREATE TABLE `elemen` (
  `id_elemen` int(10) NOT NULL,
  `id_dimensi` int(10) NOT NULL,
  `kode_elemen` text NOT NULL,
  `elemen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `eskul`
--

CREATE TABLE `eskul` (
  `id_eskul` int(10) NOT NULL,
  `kode` varchar(25) NOT NULL,
  `id_sekolah` int(10) NOT NULL,
  `nama_eskul` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `harian`
--

CREATE TABLE `harian` (
  `id_harian` int(10) NOT NULL,
  `harian` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hubungan_keluarga`
--

CREATE TABLE `hubungan_keluarga` (
  `id_hubungan_keluarga` int(10) NOT NULL,
  `hubunga_keluarga` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int(10) NOT NULL,
  `jabatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_kelamin`
--

CREATE TABLE `jenis_kelamin` (
  `id_jenis_kelamin` int(10) NOT NULL,
  `jenis_kelamin` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_keluar`
--

CREATE TABLE `jenis_keluar` (
  `id_jenis_keluar` int(10) NOT NULL,
  `jenis_keluar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_siswa`
--

CREATE TABLE `jenis_siswa` (
  `id_jenis_siswa` int(10) NOT NULL,
  `jenis_siswa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_surat_keluar`
--

CREATE TABLE `jenis_surat_keluar` (
  `id_jenis_surat_keluar` int(10) NOT NULL,
  `jenis_surat_keluar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(10) NOT NULL,
  `id_tingkat` int(10) NOT NULL,
  `id_kompetensi_keahlian` int(10) NOT NULL,
  `nama_kelas` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas_wali`
--

CREATE TABLE `kelas_wali` (
  `id_kelas_wali` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelompok_mapel`
--

CREATE TABLE `kelompok_mapel` (
  `id_kelompok` int(10) NOT NULL,
  `huruf` text NOT NULL,
  `kelompok` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kepala_sekolah`
--

CREATE TABLE `kepala_sekolah` (
  `id_kepala_sekolah` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `nama` text NOT NULL,
  `nip` text NOT NULL,
  `nuptk` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kepegawaian`
--

CREATE TABLE `kepegawaian` (
  `id_kepegawaian` int(10) NOT NULL,
  `kepegawaian` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kompetensi_keahlian`
--

CREATE TABLE `kompetensi_keahlian` (
  `id_kompetensi_keahlian` int(10) NOT NULL,
  `kompetensi_keahlian` text NOT NULL,
  `deskripsi` text NOT NULL,
  `banner` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kurikulum`
--

CREATE TABLE `kurikulum` (
  `id_kurikulum` int(10) NOT NULL,
  `kurikulum` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lager_nilai_mapel`
--

CREATE TABLE `lager_nilai_mapel` (
  `id_lager_nilai_mapel` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_mapel` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `nilai_formatif` char(10) NOT NULL,
  `nilai_sumatif_ph` char(10) NOT NULL,
  `nilai_sumatif_ts` char(10) NOT NULL,
  `nilai_sumatif_as` char(10) NOT NULL,
  `nilai_akhir_mapel` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lager_nilai_mid`
--

CREATE TABLE `lager_nilai_mid` (
  `id_lager_nilai_mapel` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_mapel` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `nilai_formatif` char(10) NOT NULL,
  `nilai_sumatif_ph` char(10) NOT NULL,
  `nilai_sumatif_ts` char(10) NOT NULL,
  `nilai_akhir_ts` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_wa`
--

CREATE TABLE `laporan_wa` (
  `id_laporan` int(11) NOT NULL,
  `kontak` varchar(13) NOT NULL,
  `status_pengiriman` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lulusan`
--

CREATE TABLE `lulusan` (
  `id_lulusan` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `tanggal_lulus` date NOT NULL,
  `tingkat_lanjut` enum('Lanjut Study','Bekerja','Berwirausaha','-') NOT NULL,
  `sekolah_tujuan` text NOT NULL,
  `no_ijazah` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int(10) NOT NULL,
  `id_sekolah` int(10) NOT NULL,
  `id_kelompok` int(10) NOT NULL,
  `nama_mapel` text NOT NULL,
  `s_mapel` text NOT NULL,
  `agama` int(1) DEFAULT NULL,
  `urut` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel_kelas`
--

CREATE TABLE `mapel_kelas` (
  `id_mapel_kelas` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_mapel` int(10) NOT NULL,
  `id_user` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel_proyek`
--

CREATE TABLE `mapel_proyek` (
  `id_mapel_proyek` int(10) NOT NULL,
  `id_proyek_kelas` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_mapel` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel_siswa`
--

CREATE TABLE `mapel_siswa` (
  `id_mapel_siswa` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_tingkat` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_mapel` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `aktif` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mutasi_keluar`
--

CREATE TABLE `mutasi_keluar` (
  `id_mutasi_keluar` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `jenis_keluar` int(10) NOT NULL,
  `alasan` text NOT NULL,
  `sekolah_tujuan` text NOT NULL,
  `no_surat` int(10) NOT NULL,
  `tanggal_keluar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mutasi_masuk`
--

CREATE TABLE `mutasi_masuk` (
  `id_mutasi_masuk` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `sekolah_asal` text NOT NULL,
  `tanggal_masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_assesmen_subelemen`
--

CREATE TABLE `nilai_assesmen_subelemen` (
  `id_nilai_assesmen_subelemen` int(10) NOT NULL,
  `id_proyek_kelas` int(10) NOT NULL,
  `id_dimensi` int(10) NOT NULL,
  `id_elemen` int(10) NOT NULL,
  `id_sub_elemen` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `nilai` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_formatif`
--

CREATE TABLE `nilai_formatif` (
  `id_nilai_formatif` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_mapel` int(10) NOT NULL,
  `id_tujuan` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `nilai` int(10) NOT NULL,
  `middle` int(10) NOT NULL,
  `nas` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_kelas`
--

CREATE TABLE `nilai_kelas` (
  `id_nilai_kelas` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `jumlah` char(10) NOT NULL,
  `nilai` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_kelas_mid`
--

CREATE TABLE `nilai_kelas_mid` (
  `id_nilai_kelas_mid` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `jumlah` char(10) NOT NULL,
  `nilai` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_mapel`
--

CREATE TABLE `nilai_mapel` (
  `id_nilai_mapel` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_mapel` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `nilai` char(10) NOT NULL,
  `deskripsi` text NOT NULL,
  `kktp` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_mapel_mid`
--

CREATE TABLE `nilai_mapel_mid` (
  `id_mapel_mid` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_mapel` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `jumlah` char(10) NOT NULL,
  `nilai` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_mata_pelajaran`
--

CREATE TABLE `nilai_mata_pelajaran` (
  `id_nilai_mata_pelajaran` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_mapel` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `nilai` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_prakerin`
--

CREATE TABLE `nilai_prakerin` (
  `id_nilai_prakerin` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `nilai` float NOT NULL,
  `capaian_kompetensi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_proyek`
--

CREATE TABLE `nilai_proyek` (
  `id_nilai_proyek` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `proyek` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_mapel` int(10) NOT NULL,
  `id_dimensi` int(10) NOT NULL,
  `id_elemen` int(10) NOT NULL,
  `id_sub_elemen` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `nilai` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_sumatif_as`
--

CREATE TABLE `nilai_sumatif_as` (
  `id_nilai_sumatif_as` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_mapel` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `nilai` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_sumatif_ph`
--

CREATE TABLE `nilai_sumatif_ph` (
  `id_nilai_sumatif_ph` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_mapel` int(10) NOT NULL,
  `id_tujuan` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `nilai` int(10) NOT NULL,
  `middle` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_sumatif_ts`
--

CREATE TABLE `nilai_sumatif_ts` (
  `id_nilai_sumatif_ts` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_mapel` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `nilai` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_ujian`
--

CREATE TABLE `nilai_ujian` (
  `id_nilai` int(10) NOT NULL,
  `id_paket_soal` int(10) NOT NULL,
  `id_siswa` int(20) NOT NULL,
  `acak_soal` text NOT NULL,
  `jawaban` text NOT NULL,
  `sisa_waktu` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `jml_benar` int(5) NOT NULL,
  `jml_kosong` int(5) NOT NULL,
  `jml_salah` int(5) NOT NULL,
  `nilai` varchar(5) NOT NULL,
  `status` varchar(100) NOT NULL,
  `size` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembagian_raport`
--

CREATE TABLE `pembagian_raport` (
  `id_pembagian` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `tanggal_mid` date NOT NULL,
  `tanggal_rapor` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembina_eskul`
--

CREATE TABLE `pembina_eskul` (
  `id_pembina_eskul` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_eskul` int(10) NOT NULL,
  `id_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendidikan`
--

CREATE TABLE `pendidikan` (
  `id_pendidikan` int(10) NOT NULL,
  `pendidikan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengingat`
--

CREATE TABLE `pengingat` (
  `id_pengingat` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_pengingat` varchar(30) NOT NULL,
  `waktu_pengingat` varchar(20) NOT NULL,
  `pesan` text NOT NULL,
  `aktif` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `piket_harian`
--

CREATE TABLE `piket_harian` (
  `id_piket_harian` int(10) NOT NULL,
  `id_harian` int(10) NOT NULL,
  `id_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `prakerin`
--

CREATE TABLE `prakerin` (
  `id_prakerin` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `mitra` text NOT NULL,
  `lokasi` text NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `instruktur` varchar(255) NOT NULL,
  `id_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

CREATE TABLE `presensi` (
  `id_presensi` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `bulan` char(10) NOT NULL,
  `tanggal` char(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `id_absen` int(10) NOT NULL,
  `jumlah` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `prestasi`
--

CREATE TABLE `prestasi` (
  `id_prestasi` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `penyelenggara` text NOT NULL,
  `nama_kegiatan` text NOT NULL,
  `tingkat` enum('Internasional','Nasional','Provinsi','Kabupaten','Kecamatan','Sekolah') NOT NULL,
  `tanggal_sertifikat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `proyek_kelas`
--

CREATE TABLE `proyek_kelas` (
  `id_proyek_kelas` int(10) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_tema` int(10) NOT NULL,
  `id_user` int(11) NOT NULL,
  `judul_proyek` text NOT NULL,
  `deskripsi_singkat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `proyek_subelemen`
--

CREATE TABLE `proyek_subelemen` (
  `id_proyek_subelemen` int(10) NOT NULL,
  `id_proyek_kelas` int(10) NOT NULL,
  `id_dimensi` int(10) NOT NULL,
  `id_elemen` int(10) NOT NULL,
  `id_sub_elemen` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `proyek_tema`
--

CREATE TABLE `proyek_tema` (
  `id_tema` int(10) NOT NULL,
  `tema` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `proyek_tujuan`
--

CREATE TABLE `proyek_tujuan` (
  `id_proyek_tujuan` int(11) NOT NULL,
  `id_proyek_kelas` int(11) DEFAULT NULL,
  `id_dimensi` int(11) DEFAULT NULL,
  `deskripsi` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekrutmen`
--

CREATE TABLE `rekrutmen` (
  `id_rekrutmen` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `tanggal_mulai_pendaftaran` date DEFAULT NULL,
  `tanggal_tutup_pendaftaran` date DEFAULT NULL,
  `pengumuman_administrasi` date DEFAULT NULL,
  `pengumuman_hasil` date DEFAULT NULL,
  `cbt_status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sekolah`
--

CREATE TABLE `sekolah` (
  `id_sekolah` int(10) NOT NULL,
  `npsn` text NOT NULL,
  `nama_sekolah` text NOT NULL,
  `id_jenjang` int(10) NOT NULL,
  `bentuk_sekolah` int(10) NOT NULL,
  `yayasan` text NOT NULL,
  `website` text NOT NULL,
  `alamat` text NOT NULL,
  `email` text NOT NULL,
  `kontak` text NOT NULL,
  `desa` text NOT NULL,
  `kecamatan` text NOT NULL,
  `kabupaten` text NOT NULL,
  `provinsi` text NOT NULL,
  `logo_prov` text NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `logo` text NOT NULL,
  `gambar1` text NOT NULL,
  `lokasi` int(10) NOT NULL,
  `visi` text NOT NULL,
  `misi` text NOT NULL,
  `frame_peta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `semester`
--

CREATE TABLE `semester` (
  `id_semester` int(10) NOT NULL,
  `semester` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(10) NOT NULL,
  `nama_siswa` text NOT NULL,
  `nik_pd` varchar(20) DEFAULT NULL,
  `nkk` varchar(20) DEFAULT NULL,
  `nisn` text NOT NULL,
  `nis` text NOT NULL,
  `tempat_lahir` text NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `kelamin` int(10) DEFAULT NULL,
  `agama` int(10) DEFAULT NULL,
  `kontak_siswa` text NOT NULL,
  `hub_keluarga` int(10) DEFAULT NULL,
  `jumlah_saudara` int(10) NOT NULL,
  `anak_ke` int(10) NOT NULL,
  `nama_ayah` text NOT NULL,
  `nik_ayah` varchar(20) DEFAULT NULL,
  `tahun_ayah` int(11) NOT NULL,
  `pendidikan_ayah` varchar(20) NOT NULL,
  `pekerjaan_ayah` varchar(30) NOT NULL,
  `kontak_ayah` varchar(14) NOT NULL,
  `nama_ibu` text NOT NULL,
  `nik_ibu` varchar(20) DEFAULT NULL,
  `tahun_ibu` int(11) NOT NULL,
  `pendidikan_ibu` varchar(20) NOT NULL,
  `pekerjaan_ibu` varchar(30) NOT NULL,
  `kontak_ibu` varchar(14) NOT NULL,
  `alamat` text NOT NULL,
  `alamat_orang_tua` text NOT NULL,
  `nama_wali` text NOT NULL,
  `alamat_wali` text NOT NULL,
  `pekerjaan_wali` text NOT NULL,
  `kontak_wali` text NOT NULL,
  `terima_tingkat` int(10) DEFAULT NULL,
  `jurusan` int(5) NOT NULL,
  `sekolah_asal` text NOT NULL,
  `terima_tanggal` date DEFAULT NULL,
  `terima_kelas` varchar(10) NOT NULL,
  `username` text NOT NULL,
  `pass` text NOT NULL,
  `password` varchar(250) NOT NULL,
  `foto` text NOT NULL,
  `jenis_siswa` int(10) NOT NULL,
  `aktif` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa_eskul`
--

CREATE TABLE `siswa_eskul` (
  `id_siswa_eskul` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_eskul` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `predikat` text NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa_kelas`
--

CREATE TABLE `siswa_kelas` (
  `id_siswa_kelas` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_tingkat` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa_prakerin`
--

CREATE TABLE `siswa_prakerin` (
  `id_siswa_prakerin` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_prakerin` int(10) NOT NULL,
  `id_siswa` int(10) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_elemen`
--

CREATE TABLE `sub_elemen` (
  `id_sub_elemen` int(10) NOT NULL,
  `id_dimensi` int(10) NOT NULL,
  `id_elemen` int(10) NOT NULL,
  `kode` text NOT NULL,
  `sub_elemen` text NOT NULL,
  `capaianE` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_masuk`
--

CREATE TABLE `surat_masuk` (
  `id_surat_masuk` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `perihal` text NOT NULL,
  `asal_instansi_surat` text NOT NULL,
  `isi_surat` text NOT NULL,
  `nomor_surat` text NOT NULL,
  `tanggal_surat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun_pelajaran`
--

CREATE TABLE `tahun_pelajaran` (
  `id_tahun_pelajaran` int(11) NOT NULL,
  `tahun_pelajaran` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tingkat`
--

CREATE TABLE `tingkat` (
  `id_tingkat` int(10) NOT NULL,
  `tingkat` text NOT NULL,
  `fase` varchar(20) NOT NULL,
  `akhir` int(10) NOT NULL,
  `tabjad` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas_tambahan`
--

CREATE TABLE `tugas_tambahan` (
  `id_tugas_tambahan` int(10) NOT NULL,
  `tugas_tambahan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tujuan_pembelajaran`
--

CREATE TABLE `tujuan_pembelajaran` (
  `id_tujuan` int(10) NOT NULL,
  `tahun` int(10) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_tingkat` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_mapel` int(10) NOT NULL,
  `id_user` int(11) NOT NULL,
  `urut` varchar(55) NOT NULL,
  `tujuan` text NOT NULL,
  `kktp` int(11) NOT NULL,
  `middle_formatif` int(10) NOT NULL,
  `middle_ph` int(10) NOT NULL,
  `formatif_as` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(10) NOT NULL,
  `jabatan` int(10) NOT NULL,
  `nama` text NOT NULL,
  `kelamin` int(10) NOT NULL,
  `agama` int(10) NOT NULL,
  `nip` text NOT NULL,
  `nuptk` text NOT NULL,
  `kontak` text NOT NULL,
  `id_kepegawaian` int(10) NOT NULL,
  `ijazah` int(10) NOT NULL,
  `id_tugas_tambahan` int(10) NOT NULL,
  `username` text NOT NULL,
  `pass` text NOT NULL,
  `password` varchar(250) NOT NULL,
  `foto` text NOT NULL,
  `moto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absen`
--
ALTER TABLE `absen`
  ADD PRIMARY KEY (`id_absen`);

--
-- Indeks untuk tabel `agama`
--
ALTER TABLE `agama`
  ADD PRIMARY KEY (`id_agama`);

--
-- Indeks untuk tabel `bulanan`
--
ALTER TABLE `bulanan`
  ADD PRIMARY KEY (`id_bulanan`),
  ADD KEY `semester` (`semester`);

--
-- Indeks untuk tabel `catatan_wali`
--
ALTER TABLE `catatan_wali`
  ADD PRIMARY KEY (`id_catatan`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `deskripsi_kokurikuler`
--
ALTER TABLE `deskripsi_kokurikuler`
  ADD PRIMARY KEY (`id_deskripsi`);

--
-- Indeks untuk tabel `deskripsi_rapor`
--
ALTER TABLE `deskripsi_rapor`
  ADD PRIMARY KEY (`id_deskripsi`);

--
-- Indeks untuk tabel `dimensi`
--
ALTER TABLE `dimensi`
  ADD PRIMARY KEY (`id_dimensi`);

--
-- Indeks untuk tabel `dimensi_kokurikuler`
--
ALTER TABLE `dimensi_kokurikuler`
  ADD PRIMARY KEY (`id_dimensi`);

--
-- Indeks untuk tabel `elemen`
--
ALTER TABLE `elemen`
  ADD PRIMARY KEY (`id_elemen`),
  ADD KEY `id_dimensi` (`id_dimensi`);

--
-- Indeks untuk tabel `eskul`
--
ALTER TABLE `eskul`
  ADD PRIMARY KEY (`id_eskul`),
  ADD KEY `id_sekolah` (`id_sekolah`);

--
-- Indeks untuk tabel `harian`
--
ALTER TABLE `harian`
  ADD PRIMARY KEY (`id_harian`);

--
-- Indeks untuk tabel `hubungan_keluarga`
--
ALTER TABLE `hubungan_keluarga`
  ADD PRIMARY KEY (`id_hubungan_keluarga`);

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indeks untuk tabel `jenis_kelamin`
--
ALTER TABLE `jenis_kelamin`
  ADD PRIMARY KEY (`id_jenis_kelamin`);

--
-- Indeks untuk tabel `jenis_keluar`
--
ALTER TABLE `jenis_keluar`
  ADD PRIMARY KEY (`id_jenis_keluar`);

--
-- Indeks untuk tabel `jenis_siswa`
--
ALTER TABLE `jenis_siswa`
  ADD PRIMARY KEY (`id_jenis_siswa`);

--
-- Indeks untuk tabel `jenis_surat_keluar`
--
ALTER TABLE `jenis_surat_keluar`
  ADD PRIMARY KEY (`id_jenis_surat_keluar`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `id_tingkat` (`id_tingkat`),
  ADD KEY `id_kompetensi_keahlian` (`id_kompetensi_keahlian`);

--
-- Indeks untuk tabel `kelas_wali`
--
ALTER TABLE `kelas_wali`
  ADD PRIMARY KEY (`id_kelas_wali`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `kelompok_mapel`
--
ALTER TABLE `kelompok_mapel`
  ADD PRIMARY KEY (`id_kelompok`);

--
-- Indeks untuk tabel `kepala_sekolah`
--
ALTER TABLE `kepala_sekolah`
  ADD PRIMARY KEY (`id_kepala_sekolah`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`);

--
-- Indeks untuk tabel `kepegawaian`
--
ALTER TABLE `kepegawaian`
  ADD PRIMARY KEY (`id_kepegawaian`);

--
-- Indeks untuk tabel `kompetensi_keahlian`
--
ALTER TABLE `kompetensi_keahlian`
  ADD PRIMARY KEY (`id_kompetensi_keahlian`);

--
-- Indeks untuk tabel `kurikulum`
--
ALTER TABLE `kurikulum`
  ADD PRIMARY KEY (`id_kurikulum`);

--
-- Indeks untuk tabel `lager_nilai_mapel`
--
ALTER TABLE `lager_nilai_mapel`
  ADD PRIMARY KEY (`id_lager_nilai_mapel`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `lager_nilai_mid`
--
ALTER TABLE `lager_nilai_mid`
  ADD PRIMARY KEY (`id_lager_nilai_mapel`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `laporan_wa`
--
ALTER TABLE `laporan_wa`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indeks untuk tabel `lulusan`
--
ALTER TABLE `lulusan`
  ADD PRIMARY KEY (`id_lulusan`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indeks untuk tabel `mapel_kelas`
--
ALTER TABLE `mapel_kelas`
  ADD PRIMARY KEY (`id_mapel_kelas`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `mapel_proyek`
--
ALTER TABLE `mapel_proyek`
  ADD PRIMARY KEY (`id_mapel_proyek`);

--
-- Indeks untuk tabel `mapel_siswa`
--
ALTER TABLE `mapel_siswa`
  ADD PRIMARY KEY (`id_mapel_siswa`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_tingkat` (`id_tingkat`),
  ADD KEY `semester` (`semester`);

--
-- Indeks untuk tabel `mutasi_keluar`
--
ALTER TABLE `mutasi_keluar`
  ADD PRIMARY KEY (`id_mutasi_keluar`);

--
-- Indeks untuk tabel `mutasi_masuk`
--
ALTER TABLE `mutasi_masuk`
  ADD PRIMARY KEY (`id_mutasi_masuk`);

--
-- Indeks untuk tabel `nilai_assesmen_subelemen`
--
ALTER TABLE `nilai_assesmen_subelemen`
  ADD PRIMARY KEY (`id_nilai_assesmen_subelemen`);

--
-- Indeks untuk tabel `nilai_formatif`
--
ALTER TABLE `nilai_formatif`
  ADD PRIMARY KEY (`id_nilai_formatif`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_tujuan` (`id_tujuan`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `nilai_kelas`
--
ALTER TABLE `nilai_kelas`
  ADD PRIMARY KEY (`id_nilai_kelas`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `nilai_kelas_mid`
--
ALTER TABLE `nilai_kelas_mid`
  ADD PRIMARY KEY (`id_nilai_kelas_mid`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `nilai_mapel`
--
ALTER TABLE `nilai_mapel`
  ADD PRIMARY KEY (`id_nilai_mapel`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `nilai_mapel_mid`
--
ALTER TABLE `nilai_mapel_mid`
  ADD PRIMARY KEY (`id_mapel_mid`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `nilai_mata_pelajaran`
--
ALTER TABLE `nilai_mata_pelajaran`
  ADD PRIMARY KEY (`id_nilai_mata_pelajaran`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `nilai_prakerin`
--
ALTER TABLE `nilai_prakerin`
  ADD PRIMARY KEY (`id_nilai_prakerin`);

--
-- Indeks untuk tabel `nilai_proyek`
--
ALTER TABLE `nilai_proyek`
  ADD PRIMARY KEY (`id_nilai_proyek`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `proyek` (`proyek`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_dimensi` (`id_dimensi`),
  ADD KEY `id_sub_elemen` (`id_sub_elemen`),
  ADD KEY `id_elemen` (`id_elemen`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `nilai_sumatif_as`
--
ALTER TABLE `nilai_sumatif_as`
  ADD PRIMARY KEY (`id_nilai_sumatif_as`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `nilai_sumatif_ph`
--
ALTER TABLE `nilai_sumatif_ph`
  ADD PRIMARY KEY (`id_nilai_sumatif_ph`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_tujuan` (`id_tujuan`);

--
-- Indeks untuk tabel `nilai_sumatif_ts`
--
ALTER TABLE `nilai_sumatif_ts`
  ADD PRIMARY KEY (`id_nilai_sumatif_ts`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `nilai_ujian`
--
ALTER TABLE `nilai_ujian`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indeks untuk tabel `pembagian_raport`
--
ALTER TABLE `pembagian_raport`
  ADD PRIMARY KEY (`id_pembagian`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`);

--
-- Indeks untuk tabel `pembina_eskul`
--
ALTER TABLE `pembina_eskul`
  ADD PRIMARY KEY (`id_pembina_eskul`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_eskul` (`id_eskul`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `pendidikan`
--
ALTER TABLE `pendidikan`
  ADD PRIMARY KEY (`id_pendidikan`);

--
-- Indeks untuk tabel `pengingat`
--
ALTER TABLE `pengingat`
  ADD PRIMARY KEY (`id_pengingat`);

--
-- Indeks untuk tabel `piket_harian`
--
ALTER TABLE `piket_harian`
  ADD PRIMARY KEY (`id_piket_harian`),
  ADD KEY `id_harian` (`id_harian`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `prakerin`
--
ALTER TABLE `prakerin`
  ADD PRIMARY KEY (`id_prakerin`),
  ADD KEY `semester` (`semester`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_absen` (`id_absen`),
  ADD KEY `tahun_2` (`tahun`),
  ADD KEY `semester_2` (`semester`);

--
-- Indeks untuk tabel `prestasi`
--
ALTER TABLE `prestasi`
  ADD PRIMARY KEY (`id_prestasi`);

--
-- Indeks untuk tabel `proyek_kelas`
--
ALTER TABLE `proyek_kelas`
  ADD PRIMARY KEY (`id_proyek_kelas`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_tema` (`id_tema`);

--
-- Indeks untuk tabel `proyek_subelemen`
--
ALTER TABLE `proyek_subelemen`
  ADD PRIMARY KEY (`id_proyek_subelemen`);

--
-- Indeks untuk tabel `proyek_tema`
--
ALTER TABLE `proyek_tema`
  ADD PRIMARY KEY (`id_tema`);

--
-- Indeks untuk tabel `proyek_tujuan`
--
ALTER TABLE `proyek_tujuan`
  ADD PRIMARY KEY (`id_proyek_tujuan`),
  ADD KEY `id_proyek_kelas` (`id_proyek_kelas`);

--
-- Indeks untuk tabel `rekrutmen`
--
ALTER TABLE `rekrutmen`
  ADD PRIMARY KEY (`id_rekrutmen`);

--
-- Indeks untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  ADD PRIMARY KEY (`id_sekolah`);

--
-- Indeks untuk tabel `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id_semester`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `agama` (`agama`),
  ADD KEY `hub_keluarga` (`hub_keluarga`),
  ADD KEY `kelamin` (`kelamin`),
  ADD KEY `jenis_siswa` (`jenis_siswa`),
  ADD KEY `terima_kelas` (`terima_tingkat`);

--
-- Indeks untuk tabel `siswa_eskul`
--
ALTER TABLE `siswa_eskul`
  ADD PRIMARY KEY (`id_siswa_eskul`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_eskul` (`id_eskul`),
  ADD KEY `semester` (`semester`),
  ADD KEY `tahun` (`tahun`);

--
-- Indeks untuk tabel `siswa_kelas`
--
ALTER TABLE `siswa_kelas`
  ADD PRIMARY KEY (`id_siswa_kelas`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_tingkat` (`id_tingkat`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`);

--
-- Indeks untuk tabel `siswa_prakerin`
--
ALTER TABLE `siswa_prakerin`
  ADD PRIMARY KEY (`id_siswa_prakerin`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_prakerin` (`id_prakerin`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`);

--
-- Indeks untuk tabel `sub_elemen`
--
ALTER TABLE `sub_elemen`
  ADD PRIMARY KEY (`id_sub_elemen`);

--
-- Indeks untuk tabel `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD PRIMARY KEY (`id_surat_masuk`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`);

--
-- Indeks untuk tabel `tahun_pelajaran`
--
ALTER TABLE `tahun_pelajaran`
  ADD PRIMARY KEY (`id_tahun_pelajaran`);

--
-- Indeks untuk tabel `tingkat`
--
ALTER TABLE `tingkat`
  ADD PRIMARY KEY (`id_tingkat`);

--
-- Indeks untuk tabel `tugas_tambahan`
--
ALTER TABLE `tugas_tambahan`
  ADD PRIMARY KEY (`id_tugas_tambahan`);

--
-- Indeks untuk tabel `tujuan_pembelajaran`
--
ALTER TABLE `tujuan_pembelajaran`
  ADD PRIMARY KEY (`id_tujuan`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `semester` (`semester`),
  ADD KEY `id_tingkat` (`id_tingkat`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_mapel` (`id_mapel`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `kelamin` (`kelamin`),
  ADD KEY `agama` (`agama`),
  ADD KEY `id_tugas_tambahan` (`id_tugas_tambahan`),
  ADD KEY `id_kepegawaian` (`id_kepegawaian`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absen`
--
ALTER TABLE `absen`
  MODIFY `id_absen` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `agama`
--
ALTER TABLE `agama`
  MODIFY `id_agama` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `bulanan`
--
ALTER TABLE `bulanan`
  MODIFY `id_bulanan` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `catatan_wali`
--
ALTER TABLE `catatan_wali`
  MODIFY `id_catatan` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `deskripsi_kokurikuler`
--
ALTER TABLE `deskripsi_kokurikuler`
  MODIFY `id_deskripsi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `deskripsi_rapor`
--
ALTER TABLE `deskripsi_rapor`
  MODIFY `id_deskripsi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `dimensi`
--
ALTER TABLE `dimensi`
  MODIFY `id_dimensi` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `dimensi_kokurikuler`
--
ALTER TABLE `dimensi_kokurikuler`
  MODIFY `id_dimensi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `elemen`
--
ALTER TABLE `elemen`
  MODIFY `id_elemen` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `eskul`
--
ALTER TABLE `eskul`
  MODIFY `id_eskul` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `harian`
--
ALTER TABLE `harian`
  MODIFY `id_harian` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `hubungan_keluarga`
--
ALTER TABLE `hubungan_keluarga`
  MODIFY `id_hubungan_keluarga` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jenis_kelamin`
--
ALTER TABLE `jenis_kelamin`
  MODIFY `id_jenis_kelamin` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jenis_keluar`
--
ALTER TABLE `jenis_keluar`
  MODIFY `id_jenis_keluar` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jenis_siswa`
--
ALTER TABLE `jenis_siswa`
  MODIFY `id_jenis_siswa` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jenis_surat_keluar`
--
ALTER TABLE `jenis_surat_keluar`
  MODIFY `id_jenis_surat_keluar` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kelas_wali`
--
ALTER TABLE `kelas_wali`
  MODIFY `id_kelas_wali` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kelompok_mapel`
--
ALTER TABLE `kelompok_mapel`
  MODIFY `id_kelompok` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kepala_sekolah`
--
ALTER TABLE `kepala_sekolah`
  MODIFY `id_kepala_sekolah` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kepegawaian`
--
ALTER TABLE `kepegawaian`
  MODIFY `id_kepegawaian` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kompetensi_keahlian`
--
ALTER TABLE `kompetensi_keahlian`
  MODIFY `id_kompetensi_keahlian` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kurikulum`
--
ALTER TABLE `kurikulum`
  MODIFY `id_kurikulum` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lager_nilai_mapel`
--
ALTER TABLE `lager_nilai_mapel`
  MODIFY `id_lager_nilai_mapel` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lager_nilai_mid`
--
ALTER TABLE `lager_nilai_mid`
  MODIFY `id_lager_nilai_mapel` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `laporan_wa`
--
ALTER TABLE `laporan_wa`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lulusan`
--
ALTER TABLE `lulusan`
  MODIFY `id_lulusan` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mapel_kelas`
--
ALTER TABLE `mapel_kelas`
  MODIFY `id_mapel_kelas` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mapel_proyek`
--
ALTER TABLE `mapel_proyek`
  MODIFY `id_mapel_proyek` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mapel_siswa`
--
ALTER TABLE `mapel_siswa`
  MODIFY `id_mapel_siswa` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mutasi_keluar`
--
ALTER TABLE `mutasi_keluar`
  MODIFY `id_mutasi_keluar` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mutasi_masuk`
--
ALTER TABLE `mutasi_masuk`
  MODIFY `id_mutasi_masuk` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `nilai_assesmen_subelemen`
--
ALTER TABLE `nilai_assesmen_subelemen`
  MODIFY `id_nilai_assesmen_subelemen` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `nilai_formatif`
--
ALTER TABLE `nilai_formatif`
  MODIFY `id_nilai_formatif` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `nilai_kelas`
--
ALTER TABLE `nilai_kelas`
  MODIFY `id_nilai_kelas` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `nilai_kelas_mid`
--
ALTER TABLE `nilai_kelas_mid`
  MODIFY `id_nilai_kelas_mid` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `nilai_mapel`
--
ALTER TABLE `nilai_mapel`
  MODIFY `id_nilai_mapel` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `nilai_mapel_mid`
--
ALTER TABLE `nilai_mapel_mid`
  MODIFY `id_mapel_mid` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `nilai_mata_pelajaran`
--
ALTER TABLE `nilai_mata_pelajaran`
  MODIFY `id_nilai_mata_pelajaran` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `nilai_prakerin`
--
ALTER TABLE `nilai_prakerin`
  MODIFY `id_nilai_prakerin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `nilai_proyek`
--
ALTER TABLE `nilai_proyek`
  MODIFY `id_nilai_proyek` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `nilai_sumatif_as`
--
ALTER TABLE `nilai_sumatif_as`
  MODIFY `id_nilai_sumatif_as` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `nilai_sumatif_ph`
--
ALTER TABLE `nilai_sumatif_ph`
  MODIFY `id_nilai_sumatif_ph` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `nilai_sumatif_ts`
--
ALTER TABLE `nilai_sumatif_ts`
  MODIFY `id_nilai_sumatif_ts` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `nilai_ujian`
--
ALTER TABLE `nilai_ujian`
  MODIFY `id_nilai` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pembagian_raport`
--
ALTER TABLE `pembagian_raport`
  MODIFY `id_pembagian` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pembina_eskul`
--
ALTER TABLE `pembina_eskul`
  MODIFY `id_pembina_eskul` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pendidikan`
--
ALTER TABLE `pendidikan`
  MODIFY `id_pendidikan` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengingat`
--
ALTER TABLE `pengingat`
  MODIFY `id_pengingat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `piket_harian`
--
ALTER TABLE `piket_harian`
  MODIFY `id_piket_harian` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `prakerin`
--
ALTER TABLE `prakerin`
  MODIFY `id_prakerin` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id_presensi` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `prestasi`
--
ALTER TABLE `prestasi`
  MODIFY `id_prestasi` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `proyek_kelas`
--
ALTER TABLE `proyek_kelas`
  MODIFY `id_proyek_kelas` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `proyek_subelemen`
--
ALTER TABLE `proyek_subelemen`
  MODIFY `id_proyek_subelemen` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `proyek_tema`
--
ALTER TABLE `proyek_tema`
  MODIFY `id_tema` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `proyek_tujuan`
--
ALTER TABLE `proyek_tujuan`
  MODIFY `id_proyek_tujuan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rekrutmen`
--
ALTER TABLE `rekrutmen`
  MODIFY `id_rekrutmen` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  MODIFY `id_sekolah` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `semester`
--
ALTER TABLE `semester`
  MODIFY `id_semester` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `siswa_eskul`
--
ALTER TABLE `siswa_eskul`
  MODIFY `id_siswa_eskul` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `siswa_kelas`
--
ALTER TABLE `siswa_kelas`
  MODIFY `id_siswa_kelas` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `siswa_prakerin`
--
ALTER TABLE `siswa_prakerin`
  MODIFY `id_siswa_prakerin` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sub_elemen`
--
ALTER TABLE `sub_elemen`
  MODIFY `id_sub_elemen` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `surat_masuk`
--
ALTER TABLE `surat_masuk`
  MODIFY `id_surat_masuk` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tahun_pelajaran`
--
ALTER TABLE `tahun_pelajaran`
  MODIFY `id_tahun_pelajaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tingkat`
--
ALTER TABLE `tingkat`
  MODIFY `id_tingkat` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tugas_tambahan`
--
ALTER TABLE `tugas_tambahan`
  MODIFY `id_tugas_tambahan` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tujuan_pembelajaran`
--
ALTER TABLE `tujuan_pembelajaran`
  MODIFY `id_tujuan` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `catatan_wali`
--
ALTER TABLE `catatan_wali`
  ADD CONSTRAINT `catatan_wali_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON UPDATE CASCADE,
  ADD CONSTRAINT `catatan_wali_ibfk_2` FOREIGN KEY (`tahun`) REFERENCES `tahun_pelajaran` (`id_tahun_pelajaran`) ON UPDATE CASCADE,
  ADD CONSTRAINT `catatan_wali_ibfk_3` FOREIGN KEY (`semester`) REFERENCES `semester` (`id_semester`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mapel_kelas`
--
ALTER TABLE `mapel_kelas`
  ADD CONSTRAINT `mapel_kelas_ibfk_1` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mapel_kelas_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mapel_kelas_ibfk_3` FOREIGN KEY (`tahun`) REFERENCES `tahun_pelajaran` (`id_tahun_pelajaran`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mapel_kelas_ibfk_4` FOREIGN KEY (`semester`) REFERENCES `semester` (`id_semester`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mapel_siswa`
--
ALTER TABLE `mapel_siswa`
  ADD CONSTRAINT `mapel_siswa_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mapel_siswa_ibfk_3` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mapel_siswa_ibfk_4` FOREIGN KEY (`tahun`) REFERENCES `tahun_pelajaran` (`id_tahun_pelajaran`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mapel_siswa_ibfk_5` FOREIGN KEY (`semester`) REFERENCES `semester` (`id_semester`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mapel_siswa_ibfk_6` FOREIGN KEY (`id_tingkat`) REFERENCES `tingkat` (`id_tingkat`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mapel_siswa_ibfk_7` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`);

--
-- Ketidakleluasaan untuk tabel `nilai_formatif`
--
ALTER TABLE `nilai_formatif`
  ADD CONSTRAINT `nilai_formatif_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_formatif_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_formatif_ibfk_3` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_formatif_ibfk_4` FOREIGN KEY (`id_tujuan`) REFERENCES `tujuan_pembelajaran` (`id_tujuan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_formatif_ibfk_5` FOREIGN KEY (`tahun`) REFERENCES `tahun_pelajaran` (`id_tahun_pelajaran`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_formatif_ibfk_6` FOREIGN KEY (`semester`) REFERENCES `semester` (`id_semester`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai_kelas`
--
ALTER TABLE `nilai_kelas`
  ADD CONSTRAINT `nilai_kelas_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_kelas_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_kelas_ibfk_3` FOREIGN KEY (`semester`) REFERENCES `semester` (`id_semester`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_kelas_ibfk_4` FOREIGN KEY (`tahun`) REFERENCES `tahun_pelajaran` (`id_tahun_pelajaran`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai_mapel`
--
ALTER TABLE `nilai_mapel`
  ADD CONSTRAINT `nilai_mapel_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_mapel_ibfk_2` FOREIGN KEY (`tahun`) REFERENCES `tahun_pelajaran` (`id_tahun_pelajaran`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_mapel_ibfk_3` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_mapel_ibfk_4` FOREIGN KEY (`semester`) REFERENCES `semester` (`id_semester`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_mapel_ibfk_5` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai_mapel_mid`
--
ALTER TABLE `nilai_mapel_mid`
  ADD CONSTRAINT `nilai_mapel_mid_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_mapel_mid_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_mapel_mid_ibfk_3` FOREIGN KEY (`tahun`) REFERENCES `tahun_pelajaran` (`id_tahun_pelajaran`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_mapel_mid_ibfk_4` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_mapel_mid_ibfk_5` FOREIGN KEY (`semester`) REFERENCES `semester` (`id_semester`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai_mata_pelajaran`
--
ALTER TABLE `nilai_mata_pelajaran`
  ADD CONSTRAINT `nilai_mata_pelajaran_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_mata_pelajaran_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_mata_pelajaran_ibfk_3` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_mata_pelajaran_ibfk_4` FOREIGN KEY (`tahun`) REFERENCES `tahun_pelajaran` (`id_tahun_pelajaran`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_mata_pelajaran_ibfk_5` FOREIGN KEY (`semester`) REFERENCES `semester` (`id_semester`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai_sumatif_as`
--
ALTER TABLE `nilai_sumatif_as`
  ADD CONSTRAINT `nilai_sumatif_as_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_sumatif_as_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_sumatif_as_ibfk_3` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_sumatif_as_ibfk_4` FOREIGN KEY (`semester`) REFERENCES `semester` (`id_semester`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_sumatif_as_ibfk_5` FOREIGN KEY (`tahun`) REFERENCES `tahun_pelajaran` (`id_tahun_pelajaran`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai_sumatif_ph`
--
ALTER TABLE `nilai_sumatif_ph`
  ADD CONSTRAINT `nilai_sumatif_ph_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_sumatif_ph_ibfk_2` FOREIGN KEY (`tahun`) REFERENCES `tahun_pelajaran` (`id_tahun_pelajaran`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_sumatif_ph_ibfk_3` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_sumatif_ph_ibfk_4` FOREIGN KEY (`semester`) REFERENCES `semester` (`id_semester`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_sumatif_ph_ibfk_5` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_sumatif_ph_ibfk_6` FOREIGN KEY (`id_tujuan`) REFERENCES `tujuan_pembelajaran` (`id_tujuan`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai_sumatif_ts`
--
ALTER TABLE `nilai_sumatif_ts`
  ADD CONSTRAINT `nilai_sumatif_ts_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_sumatif_ts_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_sumatif_ts_ibfk_3` FOREIGN KEY (`tahun`) REFERENCES `tahun_pelajaran` (`id_tahun_pelajaran`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_sumatif_ts_ibfk_4` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_sumatif_ts_ibfk_5` FOREIGN KEY (`semester`) REFERENCES `semester` (`id_semester`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `proyek_tujuan`
--
ALTER TABLE `proyek_tujuan`
  ADD CONSTRAINT `proyek_tujuan_ibfk_1` FOREIGN KEY (`id_proyek_kelas`) REFERENCES `proyek_kelas` (`id_proyek_kelas`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa_eskul`
--
ALTER TABLE `siswa_eskul`
  ADD CONSTRAINT `siswa_eskul_ibfk_1` FOREIGN KEY (`tahun`) REFERENCES `tahun_pelajaran` (`id_tahun_pelajaran`) ON UPDATE CASCADE,
  ADD CONSTRAINT `siswa_eskul_ibfk_2` FOREIGN KEY (`semester`) REFERENCES `semester` (`id_semester`) ON UPDATE CASCADE,
  ADD CONSTRAINT `siswa_eskul_ibfk_3` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `siswa_eskul_ibfk_4` FOREIGN KEY (`id_eskul`) REFERENCES `eskul` (`id_eskul`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa_kelas`
--
ALTER TABLE `siswa_kelas`
  ADD CONSTRAINT `siswa_kelas_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `siswa_kelas_ibfk_2` FOREIGN KEY (`tahun`) REFERENCES `tahun_pelajaran` (`id_tahun_pelajaran`) ON UPDATE CASCADE,
  ADD CONSTRAINT `siswa_kelas_ibfk_3` FOREIGN KEY (`semester`) REFERENCES `semester` (`id_semester`) ON UPDATE CASCADE,
  ADD CONSTRAINT `siswa_kelas_ibfk_4` FOREIGN KEY (`id_tingkat`) REFERENCES `tingkat` (`id_tingkat`) ON UPDATE CASCADE,
  ADD CONSTRAINT `siswa_kelas_ibfk_5` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa_prakerin`
--
ALTER TABLE `siswa_prakerin`
  ADD CONSTRAINT `siswa_prakerin_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `siswa_prakerin_ibfk_2` FOREIGN KEY (`tahun`) REFERENCES `tahun_pelajaran` (`id_tahun_pelajaran`) ON UPDATE CASCADE,
  ADD CONSTRAINT `siswa_prakerin_ibfk_3` FOREIGN KEY (`semester`) REFERENCES `semester` (`id_semester`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tujuan_pembelajaran`
--
ALTER TABLE `tujuan_pembelajaran`
  ADD CONSTRAINT `tujuan_pembelajaran_ibfk_1` FOREIGN KEY (`tahun`) REFERENCES `tahun_pelajaran` (`id_tahun_pelajaran`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tujuan_pembelajaran_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tujuan_pembelajaran_ibfk_3` FOREIGN KEY (`semester`) REFERENCES `semester` (`id_semester`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tujuan_pembelajaran_ibfk_4` FOREIGN KEY (`id_tingkat`) REFERENCES `tingkat` (`id_tingkat`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tujuan_pembelajaran_ibfk_5` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
