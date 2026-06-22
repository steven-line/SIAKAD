-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2026 at 08:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siakad`
--

-- --------------------------------------------------------

--
-- Table structure for table `biodata`
--

CREATE TABLE `biodata` (
  `nrp` varchar(8) NOT NULL,
  `nama` varchar(50) NOT NULL DEFAULT '',
  `nik` char(16) NOT NULL,
  `tempat_lahir` varchar(25) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `sex` char(1) NOT NULL DEFAULT '',
  `tinggi` int(11) NOT NULL DEFAULT 0,
  `berat` int(11) NOT NULL DEFAULT 0,
  `alamat` varchar(100) NOT NULL DEFAULT '',
  `kecamatan` varchar(20) NOT NULL,
  `kelurahan` varchar(50) NOT NULL,
  `kota` varchar(25) NOT NULL DEFAULT '',
  `kodepos` varchar(5) NOT NULL DEFAULT '',
  `no_telp` varchar(13) NOT NULL DEFAULT '',
  `handphone` varchar(13) NOT NULL DEFAULT '',
  `hobby` varchar(30) NOT NULL,
  `agama` varchar(15) NOT NULL DEFAULT '',
  `warganegara` char(15) NOT NULL DEFAULT '',
  `status_kawin` varchar(15) NOT NULL DEFAULT '',
  `gol_darah` varchar(10) NOT NULL DEFAULT '',
  `anak_ke` int(11) NOT NULL DEFAULT 0,
  `jml_saudara` int(11) NOT NULL DEFAULT 0,
  `jml_saudara_tanggungan` int(11) NOT NULL DEFAULT 0,
  `sumber_biaya` varchar(25) NOT NULL DEFAULT '',
  `jenis_rmh` varchar(20) NOT NULL DEFAULT '',
  `asal_smu` varchar(50) NOT NULL DEFAULT '',
  `lulus_smu` varchar(4) NOT NULL DEFAULT '',
  `transportasi` varchar(25) NOT NULL DEFAULT '',
  `nama_ayah` varchar(50) NOT NULL DEFAULT '',
  `alamat_ayah` varchar(100) NOT NULL DEFAULT '',
  `no_telp_ayah` varchar(13) NOT NULL DEFAULT '',
  `kota_ayah` varchar(25) NOT NULL DEFAULT '',
  `kodepos_ayah` varchar(5) NOT NULL DEFAULT '',
  `handphone_ayah` varchar(12) NOT NULL DEFAULT '',
  `agama_ayah` varchar(15) NOT NULL DEFAULT '',
  `pekerjaan_ayah` varchar(50) NOT NULL DEFAULT '',
  `pendidikan_ayah` varchar(25) NOT NULL DEFAULT '',
  `warganegara_ayah` varchar(20) NOT NULL DEFAULT '',
  `nama_ibu` varchar(50) NOT NULL DEFAULT '',
  `alamat_ibu` varchar(100) NOT NULL DEFAULT '',
  `kota_ibu` varchar(25) NOT NULL DEFAULT '',
  `kodepos_ibu` varchar(5) NOT NULL DEFAULT '',
  `no_telp_ibu` varchar(13) NOT NULL DEFAULT '',
  `handphone_ibu` varchar(12) NOT NULL DEFAULT '',
  `agama_ibu` varchar(15) NOT NULL DEFAULT '',
  `pekerjaan_ibu` varchar(50) NOT NULL DEFAULT '',
  `pendidikan_ibu` varchar(25) NOT NULL DEFAULT '',
  `warganegara_ibu` varchar(20) NOT NULL DEFAULT '',
  `nama_wali` varchar(50) NOT NULL DEFAULT '',
  `alamat_wali` varchar(100) NOT NULL DEFAULT '',
  `kota_wali` varchar(25) NOT NULL DEFAULT '',
  `kodepos_wali` varchar(5) NOT NULL DEFAULT '',
  `no_telp_wali` varchar(13) NOT NULL DEFAULT '',
  `handphone_wali` varchar(12) NOT NULL DEFAULT '',
  `agama_wali` varchar(15) NOT NULL DEFAULT '',
  `pekerjaan_wali` varchar(50) NOT NULL DEFAULT '',
  `pendidikan_wali` varchar(25) NOT NULL DEFAULT '',
  `warganegara_wali` varchar(20) NOT NULL DEFAULT '',
  `special_need` char(4) NOT NULL,
  `kps` int(11) NOT NULL,
  `status_pendidikan` varchar(1) NOT NULL,
  `kebutuhan_ayah` char(4) NOT NULL,
  `kebutuhan_ibu` char(4) NOT NULL,
  `last_update` date NOT NULL,
  `pataum` varchar(1) NOT NULL,
  `email` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(12) NOT NULL,
  `nisn` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `biodata`
--

INSERT INTO `biodata` (`nrp`, `nama`, `nik`, `tempat_lahir`, `tanggal_lahir`, `sex`, `tinggi`, `berat`, `alamat`, `kecamatan`, `kelurahan`, `kota`, `kodepos`, `no_telp`, `handphone`, `hobby`, `agama`, `warganegara`, `status_kawin`, `gol_darah`, `anak_ke`, `jml_saudara`, `jml_saudara_tanggungan`, `sumber_biaya`, `jenis_rmh`, `asal_smu`, `lulus_smu`, `transportasi`, `nama_ayah`, `alamat_ayah`, `no_telp_ayah`, `kota_ayah`, `kodepos_ayah`, `handphone_ayah`, `agama_ayah`, `pekerjaan_ayah`, `pendidikan_ayah`, `warganegara_ayah`, `nama_ibu`, `alamat_ibu`, `kota_ibu`, `kodepos_ibu`, `no_telp_ibu`, `handphone_ibu`, `agama_ibu`, `pekerjaan_ibu`, `pendidikan_ibu`, `warganegara_ibu`, `nama_wali`, `alamat_wali`, `kota_wali`, `kodepos_wali`, `no_telp_wali`, `handphone_wali`, `agama_wali`, `pekerjaan_wali`, `pendidikan_wali`, `warganegara_wali`, `special_need`, `kps`, `status_pendidikan`, `kebutuhan_ayah`, `kebutuhan_ibu`, `last_update`, `pataum`, `email`, `jenis_kelamin`, `nisn`) VALUES
('31127777', 'Siti Rahma', '3201010101010003', 'Depok', '2000-08-20', 'P', 160, 50, 'Jl. Anggrek', 'Cimahi', 'Cibeureum', 'Cimahi', '40511', '0226666666', '081666666666', 'Menulis', 'Islam', 'Indonesia', 'Belum', 'B', 1, 1, 1, 'Orang Tua', 'Rumah', 'SMAN 3 Cimahi', '2018', 'Jalan Kaki', 'Rahmat', 'Cimahi', '0227777777', 'Cimahi', '40511', '081777777777', 'Islam', 'Buruh', 'SMA', 'Indonesia', 'Nina', 'Cimahi', 'Cimahi', '40511', '0228888888', '082888888888', 'Islam', 'Ibu Rumah Tangga', 'SMA', 'Indonesia', 'Tidak Ada', '-', '-', '00000', '-', '-', '-', '-', '-', '-', '1', 0, 'A', '0', '0', '2026-06-18', 'P', 'siti@example.com', 'Perempuan', '1234567892');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(191) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:27:{i:0;a:4:{s:1:\"a\";i:87;s:1:\"b\";s:11:\"user.manage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:27;}}i:1;a:4:{s:1:\"a\";i:88;s:1:\"b\";s:16:\"kurikulum.manage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:27;}}i:2;a:4:{s:1:\"a\";i:89;s:1:\"b\";s:9:\"mk.manage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:27;}}i:3;a:4:{s:1:\"a\";i:90;s:1:\"b\";s:12:\"dosen.manage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:27;}}i:4;a:4:{s:1:\"a\";i:91;s:1:\"b\";s:12:\"prodi.manage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:27;}}i:5;a:4:{s:1:\"a\";i:92;s:1:\"b\";s:15:\"fakultas.manage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:27;}}i:6;a:4:{s:1:\"a\";i:93;s:1:\"b\";s:14:\"biodata.manage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:27;}}i:7;a:4:{s:1:\"a\";i:94;s:1:\"b\";s:11:\"role.manage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:27;}}i:8;a:4:{s:1:\"a\";i:95;s:1:\"b\";s:17:\"permission.manage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:27;}}i:9;a:4:{s:1:\"a\";i:96;s:1:\"b\";s:14:\"penawaran.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:29;}}i:10;a:4:{s:1:\"a\";i:97;s:1:\"b\";s:16:\"penawaran.manage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:30;}}i:11;a:4:{s:1:\"a\";i:98;s:1:\"b\";s:19:\"jadwal.view_sendiri\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:28;i:1;i:30;i:2;i:31;}}i:12;a:4:{s:1:\"a\";i:99;s:1:\"b\";s:16:\"jadwal.view_umum\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:30;}}i:13;a:4:{s:1:\"a\";i:100;s:1:\"b\";s:13:\"jadwal.manage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:30;}}i:14;a:4:{s:1:\"a\";i:101;s:1:\"b\";s:12:\"biodata.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:29;}}i:15;a:4:{s:1:\"a\";i:102;s:1:\"b\";s:8:\"krs.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:29;}}i:16;a:4:{s:1:\"a\";i:103;s:1:\"b\";s:10:\"krs.submit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:29;i:1;i:36;}}i:17;a:4:{s:1:\"a\";i:104;s:1:\"b\";s:14:\"nilai_krs.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:29;i:1;i:36;}}i:18;a:4:{s:1:\"a\";i:105;s:1:\"b\";s:8:\"khs.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:29;}}i:19;a:4:{s:1:\"a\";i:106;s:1:\"b\";s:14:\"transkrip.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:29;}}i:20;a:4:{s:1:\"a\";i:107;s:1:\"b\";s:11:\"nilai.input\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:28;i:1;i:30;i:2;i:31;}}i:21;a:4:{s:1:\"a\";i:108;s:1:\"b\";s:16:\"perwalian.manage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:31;}}i:22;a:4:{s:1:\"a\";i:109;s:1:\"b\";s:14:\"periode.manage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:32;}}i:23;a:4:{s:1:\"a\";i:112;s:1:\"b\";s:16:\"mahasiswa.manage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:27;}}i:24;a:4:{s:1:\"a\";i:113;s:1:\"b\";s:13:\"maling.manage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:27;i:1;i:36;}}i:25;a:4:{s:1:\"a\";i:114;s:1:\"b\";s:14:\"nyolongan.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:27;i:1;i:36;}}i:26;a:4:{s:1:\"a\";i:115;s:1:\"b\";s:11:\"bank.manage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:27;}}}s:5:\"roles\";a:7:{i:0;a:3:{s:1:\"a\";i:27;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:29;s:1:\"b\";s:9:\"mahasiswa\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:30;s:1:\"b\";s:7:\"kaprodi\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:28;s:1:\"b\";s:5:\"dosen\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:31;s:1:\"b\";s:10:\"dosen-wali\";s:1:\"c\";s:3:\"web\";}i:5;a:3:{s:1:\"a\";i:36;s:1:\"b\";s:9:\"malingman\";s:1:\"c\";s:3:\"web\";}i:6;a:3:{s:1:\"a\";i:32;s:1:\"b\";s:10:\"orang utan\";s:1:\"c\";s:3:\"web\";}}}', 1782126462);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `nim_dosen` varchar(15) NOT NULL,
  `nip` varchar(21) DEFAULT NULL,
  `nama` varchar(50) NOT NULL,
  `user_id` varchar(15) DEFAULT NULL,
  `prodi` varchar(15) DEFAULT NULL,
  `jabatan_struktural` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`nim_dosen`, `nip`, `nama`, `user_id`, `prodi`, `jabatan_struktural`) VALUES
('311230038', '31123003', 'Maestro Steven Alberto', '31128888', 'EL', 'Hello World'),
('31123012', '19800101', 'Yonatan Widianto', '31123012', 'IF', 'rektor'),
('aaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '31129999', 'SP', 'aaaaaaaaa'),
('D002', '19800202', 'Darmanto', '31123019', 'ARS', 'dosen biasa');

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

CREATE TABLE `fakultas` (
  `kode_fakultas` varchar(3) NOT NULL,
  `nama_fakultas` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fakultas`
--

INSERT INTO `fakultas` (`kode_fakultas`, `nama_fakultas`) VALUES
('FEB', 'Fakultas Ekonomi dan Bisnis'),
('FHU', 'Fakultas Hukum'),
('FIS', 'Fakultas Ilmu Sosial'),
('FKM', 'Fakultas Kesehatan Masyarakat'),
('FKP', 'Fakultas Keguruan dan Pendidikan'),
('FSP', 'Fakultas Sains dan Pertanian'),
('FTE', 'Fakultas Teknik'),
('FTI', 'Fakultas Teknologi Informasi');

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `kode_jurusan` varchar(3) NOT NULL,
  `nama_jurusan` varchar(50) DEFAULT NULL,
  `program_pendidikan` varchar(50) NOT NULL,
  `status_prodi` varchar(50) NOT NULL,
  `sk_ban` varchar(50) NOT NULL,
  `kaprodi` varchar(15) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `fakultas` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `krs`
--

CREATE TABLE `krs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nrp` varchar(8) NOT NULL,
  `kode` varchar(8) NOT NULL,
  `bu` char(1) DEFAULT NULL,
  `ttt1` decimal(5,2) DEFAULT NULL,
  `ttt2` decimal(5,2) DEFAULT NULL,
  `ttt3` decimal(5,2) DEFAULT NULL,
  `lain` decimal(5,2) DEFAULT NULL,
  `uts` decimal(5,2) DEFAULT NULL,
  `uas` decimal(5,2) DEFAULT NULL,
  `na` varchar(2) DEFAULT NULL,
  `sks` decimal(2,0) DEFAULT NULL,
  `periode` varchar(8) DEFAULT NULL,
  `kelas` char(1) NOT NULL,
  `survey` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Belum, 1 = Sudah'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `krs`
--

INSERT INTO `krs` (`id`, `nrp`, `kode`, `bu`, `ttt1`, `ttt2`, `ttt3`, `lain`, `uts`, `uas`, `na`, `sks`, `periode`, `kelas`, `survey`) VALUES
(1, '31127777', 'TF2026', 'Y', 50.00, 70.00, 80.00, 90.00, 35.00, 20.00, 'A', 3, '20241', 'A', 0);

-- --------------------------------------------------------

--
-- Table structure for table `kurikulum`
--

CREATE TABLE `kurikulum` (
  `kode_kurikulum` varchar(15) NOT NULL,
  `nama_kurikulum` varchar(50) NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 0,
  `deskripsi` text NOT NULL,
  `tahun_mulai_berlaku` year(4) NOT NULL,
  `tahun_selesai_berlaku` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kurikulum`
--

INSERT INTO `kurikulum` (`kode_kurikulum`, `nama_kurikulum`, `aktif`, `deskripsi`, `tahun_mulai_berlaku`, `tahun_selesai_berlaku`) VALUES
('rambotas', 'nobunagas', 1, 'Hello Darkness my old friendaaa', '2026', '2030'),
('TF19', 'Kurikulum 2026', 1, 'Kurikulum Penting untuk kita semua', '2026', '2027');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswas`
--

CREATE TABLE `mahasiswas` (
  `nrp` varchar(191) NOT NULL,
  `dosen_wali` varchar(15) NOT NULL,
  `status_blokir` enum('BELUM_KRS','MENUNGGU_VALIDASI','DISETUJUI','TERKUNCI') NOT NULL DEFAULT 'BELUM_KRS',
  `prodi` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mahasiswas`
--

INSERT INTO `mahasiswas` (`nrp`, `dosen_wali`, `status_blokir`, `prodi`) VALUES
('31127777', '31123012', 'BELUM_KRS', 'MNJ'),
('31128888', '311230038', 'BELUM_KRS', 'ING');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '2026_04_06_072623_update_users_table', 1),
(4, '2026_04_14_022436_create_mahasiswas_table', 1),
(5, '2026_05_06_113532_create_biodata_table', 1),
(6, '2026_05_06_121051_create_jurusan_table', 1),
(7, '2026_05_06_121813_create_mk_table', 1),
(8, '2026_05_06_122501_create_penawaran_table', 1),
(9, '2026_05_06_122510_create_registrasi_table', 1),
(10, '2026_05_06_133206_create_dosen_table', 1),
(11, '2026_05_07_125710_create_fakultas_table', 1),
(12, '2026_05_07_135837_update_mahasiswas_table', 1),
(13, '2026_05_31_052834_update_dosen_table', 1),
(14, '2026_05_31_061112_create_prodi_table', 1),
(15, '2026_06_05_110146_create_permission_tables', 1),
(16, '2026_06_06_115019_update_dosen_table', 1),
(17, '2026_06_08_021440_update_penawaran_table', 1),
(18, '2026_06_08_023111_create_kurikulum_table', 1),
(19, '2026_06_08_023630_update_mk_table', 1),
(20, '2026_06_08_032601_update_kurikulum_table', 1),
(21, '2026_06_08_032801_update_mk_table', 1),
(22, '2026_06_09_033222_update_kurikulum_table', 1),
(23, '2026_06_09_050613_update_prodi_table', 1),
(24, '2026_06_09_055658_update_dosen_table', 1),
(25, '2026_06_11_022538_update_mahasiswas_table', 1),
(26, '2026_06_11_035626_update_biodata_table', 1),
(27, '2026_06_11_055148_update_registrasi_table', 1),
(28, '2026_06_12_023537_update_mahasiswas_table', 1),
(29, '2026_06_15_020449_create_krs_table', 2),
(30, '2026_06_15_024453_update_penawaran_table', 2),
(31, '2026_06_15_031453_update_registrasi_table', 2),
(32, '2026_06_20_050513_update_kurikulum_table', 3),
(34, '2026_06_20_135052_update_biodata_table', 4),
(40, '2026_06_21_113419_update_dosen_table', 5),
(41, '2026_06_21_113603_update_mahasiswas_table', 5),
(42, '2026_06_21_114325_update_mk_table', 5),
(47, '2026_06_21_114956_update_jurusan_table', 6),
(48, '2026_06_21_115815_update_penawaran_table', 7),
(49, '2026_06_21_120011_update_registrasi_table', 7),
(50, '2026_06_21_120850_update_prodi_table', 8),
(51, '2026_06_21_122615_update_krs_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `mk`
--

CREATE TABLE `mk` (
  `kodemk` varchar(8) NOT NULL,
  `nama` varchar(50) NOT NULL DEFAULT '',
  `sks` char(3) NOT NULL DEFAULT '0',
  `nm_jenj_didik` char(2) NOT NULL,
  `kode_prodi_dikti` char(5) NOT NULL,
  `prasyaratsks` varchar(3) NOT NULL DEFAULT '0',
  `prasyarat1` varchar(8) NOT NULL DEFAULT '',
  `prasyarat2` varchar(8) NOT NULL DEFAULT '',
  `prasyarat3` varchar(8) NOT NULL DEFAULT '',
  `prasyarat4` varchar(8) NOT NULL DEFAULT '',
  `prasyarat5` varchar(8) NOT NULL DEFAULT '',
  `prasyarat6` varchar(8) NOT NULL DEFAULT '',
  `prasyarat7` varchar(8) NOT NULL DEFAULT '',
  `prasyarat8` varchar(8) NOT NULL DEFAULT '',
  `prasyarat9` varchar(8) NOT NULL DEFAULT '',
  `prasyarat10` varchar(8) NOT NULL DEFAULT '',
  `prasyaratgrade` char(1) NOT NULL DEFAULT '',
  `kode_kurikulum` varchar(15) NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mk`
--

INSERT INTO `mk` (`kodemk`, `nama`, `sks`, `nm_jenj_didik`, `kode_prodi_dikti`, `prasyaratsks`, `prasyarat1`, `prasyarat2`, `prasyarat3`, `prasyarat4`, `prasyarat5`, `prasyarat6`, `prasyarat7`, `prasyarat8`, `prasyarat9`, `prasyarat10`, `prasyaratgrade`, `kode_kurikulum`, `aktif`) VALUES
('aaaaaaon', '\'aktif\' => [\'boolean\'],', 'aaa', 'aa', 'aa', 'aaa', 'aaa', 'aaaaaaaa', 'aaaaaaaa', 'aaaaaaaa', 'aaaaaaaa', 'aaaaaaaa', 'aaaaaaaa', 'aaaaaaaa', 'aaaaaaaa', 'aaaaaaaa', 'a', 'rambotas', 1),
('Aidaw', 'aaaaaaaaaaaaaaaaaaaa', 'aab', 'ab', 'aaaab', 'aab', 'aaaaaaab', 'aaaaabbb', 'aaabbbbb', 'aaaabbbb', 'aaaabbbb', 'aaaabbbb', 'aaaaaaaa', 'aaaaaaab', 'aaaaaaab', 'aaaaaaab', 'a', 'rambotas', 0),
('asbak', 'Kalkulus 1', '333', 'aa', 'aaaaa', 'aaa', 'aaaaaaaa', 'aaaaaaaa', 'aaaaaaaa', 'aaaaaaaa', 'aaaaaaaa', 'aaaaaaaa', 'aaaaaaaa', 'aaaaaaaa', 'aaaaaaaa', 'aaaaaaaa', 'a', 'rambotas', 1),
('avvmcmc', 'avvmcmc', 'avv', 'av', 'avvmc', 'avv', 'avvmcmc', 'avvmcmc', 'avvmcmc', 'avvmcmc', 'avvmcmc', 'avvmcmc', 'avvmcmc', 'avvmcmc', 'avvmcmc', 'avvmcmc', 'a', 'rambotas', 1),
('TF2026', 'Aljabar Linear Matriks', '3', 'aa', 'aa', '3', '3', '3', '3', '3', '3', '3', '3', '3', '3', '3', 'A', 'TF19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(91, 'App\\Models\\User', 31128888),
(92, 'App\\Models\\User', 31123003),
(92, 'App\\Models\\User', 311230033),
(96, 'App\\Models\\User', 31123003),
(96, 'App\\Models\\User', 31127777),
(96, 'App\\Models\\User', 31128888),
(96, 'App\\Models\\User', 311230033),
(98, 'App\\Models\\User', 31123003),
(98, 'App\\Models\\User', 311230033),
(101, 'App\\Models\\User', 31123003),
(101, 'App\\Models\\User', 31127777),
(101, 'App\\Models\\User', 31128888),
(101, 'App\\Models\\User', 311230033),
(102, 'App\\Models\\User', 31123003),
(102, 'App\\Models\\User', 31127777),
(102, 'App\\Models\\User', 31128888),
(102, 'App\\Models\\User', 311230033),
(103, 'App\\Models\\User', 31123003),
(103, 'App\\Models\\User', 31127777),
(103, 'App\\Models\\User', 31128888),
(103, 'App\\Models\\User', 311230033),
(104, 'App\\Models\\User', 31123003),
(104, 'App\\Models\\User', 31127777),
(104, 'App\\Models\\User', 31128888),
(104, 'App\\Models\\User', 311230033),
(105, 'App\\Models\\User', 31123003),
(105, 'App\\Models\\User', 31127777),
(105, 'App\\Models\\User', 31128888),
(105, 'App\\Models\\User', 311230033),
(106, 'App\\Models\\User', 31123003),
(106, 'App\\Models\\User', 31127777),
(106, 'App\\Models\\User', 31128888),
(106, 'App\\Models\\User', 311230033),
(107, 'App\\Models\\User', 31123003),
(107, 'App\\Models\\User', 311230033),
(108, 'App\\Models\\User', 31123003),
(108, 'App\\Models\\User', 311230033),
(109, 'App\\Models\\User', 31123003),
(109, 'App\\Models\\User', 31123012),
(109, 'App\\Models\\User', 311230033);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(27, 'App\\Models\\User', 31123019),
(29, 'App\\Models\\User', 31127777),
(29, 'App\\Models\\User', 31128888),
(31, 'App\\Models\\User', 31123003),
(31, 'App\\Models\\User', 311230033),
(32, 'App\\Models\\User', 31123012);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penawaran`
--

CREATE TABLE `penawaran` (
  `recno` bigint(20) UNSIGNED NOT NULL,
  `kodemk` varchar(8) NOT NULL DEFAULT '',
  `semester` char(2) NOT NULL DEFAULT '0',
  `periode` varchar(9) NOT NULL DEFAULT '',
  `dosen` varchar(15) NOT NULL,
  `sesi` varchar(5) NOT NULL DEFAULT '',
  `keterangan` varchar(100) NOT NULL DEFAULT '',
  `hari` varchar(6) NOT NULL DEFAULT '',
  `mulaipukul` time NOT NULL,
  `selesaipukul` time NOT NULL,
  `jurusan` varchar(3) NOT NULL DEFAULT '',
  `pagu` varchar(3) NOT NULL DEFAULT '0',
  `pataum` varchar(1) NOT NULL,
  `MBKM` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(87, 'user.manage', 'web', '2026-06-18 20:42:05', '2026-06-18 20:42:05'),
(88, 'kurikulum.manage', 'web', '2026-06-18 20:42:05', '2026-06-18 20:42:05'),
(89, 'mk.manage', 'web', '2026-06-18 20:42:05', '2026-06-18 20:42:05'),
(90, 'dosen.manage', 'web', '2026-06-18 20:42:05', '2026-06-18 20:42:05'),
(91, 'prodi.manage', 'web', '2026-06-18 20:42:05', '2026-06-18 20:42:05'),
(92, 'fakultas.manage', 'web', '2026-06-18 20:42:05', '2026-06-18 20:42:05'),
(93, 'biodata.manage', 'web', '2026-06-18 20:42:05', '2026-06-18 20:42:05'),
(94, 'role.manage', 'web', '2026-06-18 20:42:05', '2026-06-18 20:42:05'),
(95, 'permission.manage', 'web', '2026-06-18 20:42:05', '2026-06-18 20:42:05'),
(96, 'penawaran.view', 'web', '2026-06-18 20:42:05', '2026-06-18 20:42:05'),
(97, 'penawaran.manage', 'web', '2026-06-18 20:42:06', '2026-06-18 20:42:06'),
(98, 'jadwal.view_sendiri', 'web', '2026-06-18 20:42:06', '2026-06-18 20:42:06'),
(99, 'jadwal.view_umum', 'web', '2026-06-18 20:42:06', '2026-06-18 20:42:06'),
(100, 'jadwal.manage', 'web', '2026-06-18 20:42:06', '2026-06-18 20:42:06'),
(101, 'biodata.view', 'web', '2026-06-18 20:42:06', '2026-06-18 20:42:06'),
(102, 'krs.view', 'web', '2026-06-18 20:42:06', '2026-06-18 20:42:06'),
(103, 'krs.submit', 'web', '2026-06-18 20:42:06', '2026-06-18 20:42:06'),
(104, 'nilai_krs.view', 'web', '2026-06-18 20:42:06', '2026-06-18 20:42:06'),
(105, 'khs.view', 'web', '2026-06-18 20:42:06', '2026-06-18 20:42:06'),
(106, 'transkrip.view', 'web', '2026-06-18 20:42:06', '2026-06-18 20:42:06'),
(107, 'nilai.input', 'web', '2026-06-18 20:42:06', '2026-06-18 20:42:06'),
(108, 'perwalian.manage', 'web', '2026-06-18 20:42:06', '2026-06-18 20:42:06'),
(109, 'periode.manage', 'web', '2026-06-19 18:48:05', '2026-06-19 18:48:05'),
(112, 'mahasiswa.manage', 'web', '2026-06-20 23:10:13', '2026-06-20 23:10:13'),
(113, 'maling.manage', 'web', '2026-06-20 23:10:46', '2026-06-20 23:10:46'),
(114, 'nyolongan.view', 'web', '2026-06-21 00:16:58', '2026-06-21 00:16:58'),
(115, 'bank.manage', 'web', '2026-06-21 04:07:34', '2026-06-21 04:07:34');

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `kode_prodi` varchar(15) NOT NULL,
  `nama_prodi` varchar(50) NOT NULL,
  `kode_fakultas` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`kode_prodi`, `nama_prodi`, `kode_fakultas`) VALUES
('aabbbbbbbbbbbbb', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'FTE'),
('ARGONAUT', 'Akuntansi', 'FEB'),
('ARS', 'Teknik Arsitektur', 'FEB'),
('EL', 'Teknik Elektro', 'FTI'),
('IF', 'Teknik Informatika', 'FTI'),
('ING', 'Sastra Inggris', 'FKP'),
('MD', 'Bahasa Mandarin', 'FKP'),
('MNJ', 'Manajemen Bisnis', 'FEB'),
('SP', 'Teknik Sipil', 'FHU');

-- --------------------------------------------------------

--
-- Table structure for table `registrasi`
--

CREATE TABLE `registrasi` (
  `regkrs` bigint(20) UNSIGNED NOT NULL,
  `nrp` varchar(8) NOT NULL DEFAULT '',
  `kodemk` varchar(8) NOT NULL DEFAULT '',
  `periode` varchar(9) NOT NULL DEFAULT '',
  `status` varchar(5) NOT NULL DEFAULT '',
  `sesi` varchar(5) NOT NULL DEFAULT '',
  `tanggal` date NOT NULL,
  `jam` time NOT NULL DEFAULT '00:00:00',
  `validasi` int(11) NOT NULL DEFAULT 0,
  `hari` varchar(6) NOT NULL DEFAULT '',
  `mulaipukul` time NOT NULL DEFAULT '00:00:00',
  `selesaipukul` time NOT NULL DEFAULT '00:00:00',
  `ip_address` varchar(100) NOT NULL DEFAULT '',
  `sks` int(11) NOT NULL DEFAULT 0,
  `pataum` varchar(1) NOT NULL,
  `dosen` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registrasi`
--

INSERT INTO `registrasi` (`regkrs`, `nrp`, `kodemk`, `periode`, `status`, `sesi`, `tanggal`, `jam`, `validasi`, `hari`, `mulaipukul`, `selesaipukul`, `ip_address`, `sks`, `pataum`, `dosen`) VALUES
(1, '31127777', 'TF2026', '2025-2027', 'BARU', '1', '2026-06-18', '05:28:16', 0, 'Senin', '08:00:00', '10:30:00', '127.0.0.1', 3, 'P', '31123012');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(27, 'admin', 'web', '2026-06-18 20:42:05', '2026-06-20 21:30:44'),
(28, 'dosen', 'web', '2026-06-18 20:42:05', '2026-06-18 20:42:05'),
(29, 'mahasiswa', 'web', '2026-06-18 20:42:05', '2026-06-18 20:42:05'),
(30, 'kaprodi', 'web', '2026-06-18 20:42:05', '2026-06-18 20:42:05'),
(31, 'dosen-wali', 'web', '2026-06-18 20:42:05', '2026-06-18 20:42:05'),
(32, 'orang utan', 'web', '2026-06-19 18:48:20', '2026-06-19 18:48:20'),
(36, 'malingman', 'web', '2026-06-21 00:15:57', '2026-06-21 00:15:57');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(87, 27),
(88, 27),
(89, 27),
(90, 27),
(91, 27),
(92, 27),
(93, 27),
(94, 27),
(95, 27),
(96, 29),
(97, 30),
(98, 28),
(98, 30),
(98, 31),
(99, 30),
(100, 30),
(101, 29),
(102, 29),
(103, 29),
(103, 36),
(104, 29),
(104, 36),
(105, 29),
(106, 29),
(107, 28),
(107, 30),
(107, 31),
(108, 31),
(109, 32),
(112, 27),
(113, 27),
(113, 36),
(114, 27),
(114, 36),
(115, 27);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('majv28wcv3EUJ8YCPHg8CqpAazQ0e3DRsyNEu3LE', 31123019, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidWJMNHVvV2tGU0tCb3RpbmNWY2IycjE3YlNlcjY1cVVLdlJCM0o0UyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tYWhhc2lzd2EtYWRtaW4iO3M6NToicm91dGUiO3M6MjE6Im1haGFzaXN3YV9hZG1pbi5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtzOjg6IjMxMTIzMDE5IjtzOjY6InBhdGF1bSI7czoxOiJvIjt9', 1782047179);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(15) NOT NULL,
  `password` varchar(191) NOT NULL,
  `sks` int(11) NOT NULL,
  `firstlogin` datetime NOT NULL,
  `lastlogin` datetime NOT NULL,
  `validasi` int(11) DEFAULT NULL,
  `aksesnilai` int(11) DEFAULT NULL,
  `pataum` varchar(1) DEFAULT NULL,
  `aktif` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `sks`, `firstlogin`, `lastlogin`, `validasi`, `aksesnilai`, `pataum`, `aktif`, `remember_token`) VALUES
('311230033', '$2y$12$jOuQjNkE70ZK.Fsyu/Vweu4iP24GaH2o5WTb.J5si6rLgirj5ekz.', 110, '2026-06-14 01:43:34', '2026-06-14 01:43:34', 1, 0, 'o', 0, NULL),
('31123012', '$2y$12$s2x9ZzkbtmD30mxNsFuajOge54aK5Iearc0cT1GK1XlPf2Y.P5qRa', 110, '2026-06-14 01:43:34', '2026-06-14 01:43:34', 1, 0, 'o', 0, NULL),
('31123019', '$2y$12$qMFjAtx3KWiNDjZZ6CSA.ONLhsi55An0THjhaIr.5mQqvNTQPUWT6', 110, '2026-06-14 01:43:33', '2026-06-14 01:43:33', 1, 0, 'o', 0, NULL),
('31127777', '$2y$12$FBuU8/QQ7owo8CSv05q4JetAu.z6ES5NHytT7Qp9kAIMT8chdr1sS', 2, '2026-06-18 02:34:02', '2026-06-18 02:34:02', NULL, NULL, 'P', NULL, NULL),
('31128888', '$2y$12$d6CaNTSSS7SMXOJMdQxlle8t3/r.oeDcXSQY0TODc2WZRGU6eC6M.', 21, '2026-06-18 02:26:17', '2026-06-18 02:26:17', NULL, NULL, 'P', NULL, NULL),
('31129999', '$2y$12$3YtUb7Sod.PCbdZfz5LSq.QT6/F3kvtpDLQDdOl9rY9YRuhjNkkly', 1, '2026-06-18 02:25:38', '2026-06-18 02:25:38', NULL, NULL, 'P', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `biodata`
--
ALTER TABLE `biodata`
  ADD PRIMARY KEY (`nrp`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`nim_dosen`),
  ADD UNIQUE KEY `dosen_user_id_unique` (`user_id`),
  ADD KEY `dosen_prodi_foreign` (`prodi`);

--
-- Indexes for table `fakultas`
--
ALTER TABLE `fakultas`
  ADD PRIMARY KEY (`kode_fakultas`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`kode_jurusan`),
  ADD KEY `jurusan_fakultas_foreign` (`fakultas`);

--
-- Indexes for table `krs`
--
ALTER TABLE `krs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `krs_nrp_foreign` (`nrp`),
  ADD KEY `krs_kode_foreign` (`kode`);

--
-- Indexes for table `kurikulum`
--
ALTER TABLE `kurikulum`
  ADD PRIMARY KEY (`kode_kurikulum`);

--
-- Indexes for table `mahasiswas`
--
ALTER TABLE `mahasiswas`
  ADD PRIMARY KEY (`nrp`),
  ADD KEY `mahasiswas_dosen_wali_foreign` (`dosen_wali`),
  ADD KEY `mahasiswas_prodi_foreign` (`prodi`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mk`
--
ALTER TABLE `mk`
  ADD PRIMARY KEY (`kodemk`),
  ADD KEY `mk_kode_kurikulum_foreign` (`kode_kurikulum`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `penawaran`
--
ALTER TABLE `penawaran`
  ADD PRIMARY KEY (`recno`),
  ADD KEY `idx_sem_jur` (`semester`,`jurusan`),
  ADD KEY `idx_mk_jur` (`kodemk`,`jurusan`),
  ADD KEY `idx_recno_full` (`recno`,`kodemk`,`semester`,`periode`,`sesi`,`jurusan`),
  ADD KEY `penawaran_sesi_index` (`sesi`),
  ADD KEY `penawaran_dosen_foreign` (`dosen`),
  ADD KEY `penawaran_jurusan_foreign` (`jurusan`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`kode_prodi`),
  ADD KEY `prodi_kode_fakultas_foreign` (`kode_fakultas`);

--
-- Indexes for table `registrasi`
--
ALTER TABLE `registrasi`
  ADD PRIMARY KEY (`regkrs`),
  ADD KEY `periode` (`periode`,`sesi`),
  ADD KEY `kodemk_2` (`kodemk`,`periode`,`sesi`),
  ADD KEY `registrasi_nrp_index` (`nrp`),
  ADD KEY `registrasi_kodemk_index` (`kodemk`),
  ADD KEY `registrasi_periode_index` (`periode`),
  ADD KEY `registrasi_sesi_index` (`sesi`),
  ADD KEY `registrasi_dosen_foreign` (`dosen`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `krs`
--
ALTER TABLE `krs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `penawaran`
--
ALTER TABLE `penawaran`
  MODIFY `recno` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `registrasi`
--
ALTER TABLE `registrasi`
  MODIFY `regkrs` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `biodata`
--
ALTER TABLE `biodata`
  ADD CONSTRAINT `biodata_nrp_foreign` FOREIGN KEY (`nrp`) REFERENCES `mahasiswas` (`nrp`) ON DELETE CASCADE;

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_prodi_foreign` FOREIGN KEY (`prodi`) REFERENCES `prodi` (`kode_prodi`) ON DELETE CASCADE,
  ADD CONSTRAINT `dosen_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD CONSTRAINT `jurusan_fakultas_foreign` FOREIGN KEY (`fakultas`) REFERENCES `fakultas` (`kode_fakultas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `krs`
--
ALTER TABLE `krs`
  ADD CONSTRAINT `krs_kode_foreign` FOREIGN KEY (`kode`) REFERENCES `mk` (`kodemk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `krs_nrp_foreign` FOREIGN KEY (`nrp`) REFERENCES `mahasiswas` (`nrp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mahasiswas`
--
ALTER TABLE `mahasiswas`
  ADD CONSTRAINT `mahasiswas_dosen_wali_foreign` FOREIGN KEY (`dosen_wali`) REFERENCES `dosen` (`nim_dosen`) ON DELETE CASCADE,
  ADD CONSTRAINT `mahasiswas_nrp_foreign` FOREIGN KEY (`nrp`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mahasiswas_prodi_foreign` FOREIGN KEY (`prodi`) REFERENCES `prodi` (`kode_prodi`) ON DELETE CASCADE;

--
-- Constraints for table `mk`
--
ALTER TABLE `mk`
  ADD CONSTRAINT `mk_kode_kurikulum_foreign` FOREIGN KEY (`kode_kurikulum`) REFERENCES `kurikulum` (`kode_kurikulum`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penawaran`
--
ALTER TABLE `penawaran`
  ADD CONSTRAINT `penawaran_dosen_foreign` FOREIGN KEY (`dosen`) REFERENCES `dosen` (`nim_dosen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penawaran_jurusan_foreign` FOREIGN KEY (`jurusan`) REFERENCES `jurusan` (`kode_jurusan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penawaran_kodemk_foreign` FOREIGN KEY (`kodemk`) REFERENCES `mk` (`kodemk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prodi`
--
ALTER TABLE `prodi`
  ADD CONSTRAINT `prodi_kode_fakultas_foreign` FOREIGN KEY (`kode_fakultas`) REFERENCES `fakultas` (`kode_fakultas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `registrasi`
--
ALTER TABLE `registrasi`
  ADD CONSTRAINT `registrasi_dosen_foreign` FOREIGN KEY (`dosen`) REFERENCES `dosen` (`nim_dosen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `registrasi_kodemk_foreign` FOREIGN KEY (`kodemk`) REFERENCES `mk` (`kodemk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `registrasi_nrp_foreign` FOREIGN KEY (`nrp`) REFERENCES `mahasiswas` (`nrp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
