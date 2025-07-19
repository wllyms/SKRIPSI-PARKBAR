-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 19, 2025 at 08:28 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parkbar`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coba`
--

CREATE TABLE `coba` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `staff_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `denda`
--

CREATE TABLE `denda` (
  `id` bigint UNSIGNED NOT NULL,
  `plat_kendaraan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `parkir_id` bigint UNSIGNED NOT NULL,
  `status` enum('Belum Dibayar','Sudah Dibayar') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Dibayar',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `denda`
--

INSERT INTO `denda` (`id`, `plat_kendaraan`, `tanggal`, `nominal`, `parkir_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'DA 6543', '2025-06-30', 40000.00, 2, 'Belum Dibayar', '2025-06-30 07:01:36', '2025-06-30 07:01:36'),
(2, 'D3132', '2025-07-01', 10000.00, 6, 'Belum Dibayar', '2025-07-01 02:50:52', '2025-07-01 02:50:52');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grupp`
--

CREATE TABLE `grupp` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_grup` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama_jabatan`, `created_at`, `updated_at`) VALUES
(1, 'Dokter', NULL, NULL),
(2, 'Perawat', NULL, NULL),
(3, 'Petugas Keamanan', NULL, NULL),
(4, 'Administrasi', NULL, NULL),
(5, 'Teknisi', NULL, NULL),
(6, 'Cleaning Service', NULL, '2025-07-19 04:07:35');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pegawai`
--

CREATE TABLE `jenis_pegawai` (
  `id` bigint UNSIGNED NOT NULL,
  `jenis_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `created_at`, `updated_at`, `nama_kategori`) VALUES
(1, NULL, NULL, 'Roda 2'),
(2, NULL, NULL, 'Roda 4');

-- --------------------------------------------------------

--
-- Table structure for table `kuesioner_pertanyaan`
--

CREATE TABLE `kuesioner_pertanyaan` (
  `id` bigint UNSIGNED NOT NULL,
  `teks_pertanyaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('fasilitas','petugas') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_jawaban` enum('rating_bintang') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'rating_bintang',
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `urutan` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kuesioner_pertanyaan`
--

INSERT INTO `kuesioner_pertanyaan` (`id`, `teks_pertanyaan`, `kategori`, `tipe_jawaban`, `status`, `urutan`, `created_at`, `updated_at`) VALUES
(1, 'Kebersihan & Kerapian Area Parkir', 'fasilitas', 'rating_bintang', 'aktif', 1, '2025-06-30 06:48:48', '2025-06-30 06:48:48'),
(2, 'Keamanan Area Parkir', 'fasilitas', 'rating_bintang', 'aktif', 2, '2025-06-30 06:49:01', '2025-06-30 06:49:01'),
(3, 'Kemudahan Menemukan Tempat Parkir', 'fasilitas', 'rating_bintang', 'aktif', 3, '2025-06-30 06:49:17', '2025-06-30 06:49:17'),
(4, 'Kecepatan & Efisiensi Pelayanan', 'petugas', 'rating_bintang', 'aktif', 4, '2025-06-30 06:49:30', '2025-06-30 06:49:30'),
(5, 'Keramahan & Kesopanan Petugas', 'petugas', 'rating_bintang', 'aktif', 5, '2025-06-30 06:49:40', '2025-06-30 06:49:40');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_pengunjung`
--

CREATE TABLE `laporan_pengunjung` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_lapor` datetime NOT NULL,
  `no_telp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Diproses','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Diproses',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporan_pengunjung`
--

INSERT INTO `laporan_pengunjung` (`id`, `user_id`, `nama`, `waktu_lapor`, `no_telp`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES
(2, 2, 'Yanto', '2025-07-01 10:51:00', '081348209166', 'kehilangan barang', 'Selesai', '2025-07-01 02:51:57', '2025-07-01 02:52:25'),
(3, 2, 'Yaman', '2025-07-05 11:53:00', '081348209166', 'kehilangan', 'Selesai', '2025-07-05 03:53:51', '2025-07-05 03:54:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2024_12_09_061602_tabel_grupp', 1),
(4, '2024_12_09_194425_tabel_kategori', 1),
(5, '2024_12_11_041326_tabel_tarif', 1),
(6, '2024_12_16_113214_tabel_slot_parkir', 1),
(7, '2024_12_16_130142_tabel_staff', 1),
(8, '2024_12_17_140225_tabel_tuser', 1),
(9, '2024_12_19_161412_tabel_parkir', 1),
(10, '2024_12_30_131024_tabel_jenispegawai', 1),
(11, '2024_12_30_144217_tabel_jabatan', 1),
(12, '2024_12_30_144406_tabel_sub_jabatan', 1),
(13, '2025_01_02_090340_tabel_pegawai', 1),
(14, '2025_01_04_135149_tabel_coba', 1),
(15, '2025_01_14_111106_tabel_parkir_pegawai', 1),
(16, '2025_05_20_013928_create_dendas_table', 1),
(17, '2025_05_25_202626_tabel__laporan_pengunjung', 1),
(18, '2025_06_26_144520_tabel_sub_jabatan', 1),
(19, '2025_06_27_191911_buat_tabel_kuesioner_pertanyaan', 1),
(20, '2025_06_27_192014_buat_tabel_penilaian_kepuasan', 1),
(21, '2025_06_27_192045_buat_tabel_penilaian_jawaban', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parkir`
--

CREATE TABLE `parkir` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_parkir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plat_kendaraan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tarif_id` bigint UNSIGNED NOT NULL,
  `slot_parkir_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `waktu_masuk` datetime NOT NULL,
  `durasi` int DEFAULT NULL,
  `waktu_keluar` datetime DEFAULT NULL,
  `status` enum('Terparkir','Keluar') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Terparkir',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parkir`
--

INSERT INTO `parkir` (`id`, `kode_parkir`, `plat_kendaraan`, `tarif_id`, `slot_parkir_id`, `user_id`, `waktu_masuk`, `durasi`, `waktu_keluar`, `status`, `created_at`, `updated_at`) VALUES
(1, 'KP001', 'Da 5432', 1, 1, 2, '2025-06-30 14:49:59', 7, '2025-06-30 14:57:46', 'Keluar', '2025-06-30 06:49:59', '2025-06-30 06:57:46'),
(2, 'KP002', 'DA 6543', 3, 1, 2, '2025-06-28 14:01:05', 2940, '2025-06-30 15:01:36', 'Keluar', '2025-06-30 06:59:59', '2025-06-30 07:01:36'),
(3, 'KP003', 'DA 9876', 1, 1, 2, '2025-07-01 10:37:01', 1, '2025-07-01 10:39:00', 'Keluar', '2025-07-01 02:37:01', '2025-07-01 02:39:22'),
(4, 'KP004', 'Da 5432', 1, 1, 2, '2025-07-01 10:41:44', 52, '2025-07-01 11:34:42', 'Keluar', '2025-07-01 02:41:44', '2025-07-01 03:34:42'),
(5, 'KP005', 'DA 6767', 1, 1, 2, '2025-07-01 10:41:58', 10, '2025-07-01 10:52:00', 'Keluar', '2025-07-01 02:41:58', '2025-07-01 02:53:00'),
(6, 'KP006', 'D3132', 1, 1, 2, '2025-06-29 09:50:34', 2939, '2025-07-01 10:50:00', 'Keluar', '2025-07-01 02:42:10', '2025-07-01 02:50:52'),
(7, 'KP007', 'da12234', 1, 1, 1, '2025-07-05 11:57:20', 0, '2025-07-05 11:58:00', 'Keluar', '2025-07-05 03:57:20', '2025-07-05 03:58:56'),
(9, 'KP009', 'DA 9876 ADP', 1, 1, 2, '2025-07-19 12:28:24', 3, '2025-07-19 12:32:00', 'Keluar', '2025-07-19 04:28:24', '2025-07-19 04:32:00');

-- --------------------------------------------------------

--
-- Table structure for table `parkir_pegawai`
--

CREATE TABLE `parkir_pegawai` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_member` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plat_kendaraan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_masuk` datetime NOT NULL,
  `waktu_keluar` datetime DEFAULT NULL,
  `pegawai_id` bigint UNSIGNED NOT NULL,
  `status` enum('Terparkir','Keluar') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Terparkir',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parkir_pegawai`
--

INSERT INTO `parkir_pegawai` (`id`, `kode_member`, `plat_kendaraan`, `waktu_masuk`, `waktu_keluar`, `pegawai_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'MBR-001', 'DA 6767', '2025-06-29 20:32:42', '2025-06-29 20:38:21', 1, 'Keluar', '2025-06-29 12:32:42', '2025-06-29 12:38:21'),
(2, 'MBR-001', 'DA 6767', '2025-07-01 11:05:58', '2025-07-01 11:31:44', 1, 'Keluar', '2025-07-01 03:05:58', '2025-07-01 03:31:44'),
(3, 'MBR-001', 'DA 6767', '2025-07-05 12:05:28', '2025-07-19 12:35:23', 1, 'Keluar', '2025-07-05 04:05:28', '2025-07-19 04:35:23'),
(4, 'MBR-002', 'DA 9876', '2025-07-19 12:36:50', '2025-07-19 12:40:58', 2, 'Keluar', '2025-07-19 04:36:50', '2025-07-19 04:40:58');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_member` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plat_kendaraan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merk_kendaraan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan_id` bigint UNSIGNED NOT NULL,
  `sub_jabatan_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `kode_member`, `plat_kendaraan`, `nama`, `no_telp`, `email`, `alamat`, `merk_kendaraan`, `image`, `jabatan_id`, `sub_jabatan_id`, `created_at`, `updated_at`) VALUES
(1, 'MBR-001', 'DA 6767', 'Smith Willyams Tutuarima', '081348209166', 'smith@gmail.com', 'JL.Herlina Perkasa 75', 'Beat Hitam', 'pegawai_images/V9V84Qz9JcztgMj7RzJuqeNIAYrjOtm785ZnHJJm.jpg', 5, 10, '2025-06-29 12:31:56', '2025-07-19 04:31:30'),
(2, 'MBR-002', 'DA 9876', 'Marsha Lenathea', '087634526764', 'admin@gmail.com', 'JL.Herlina Perkasa 54', 'Mazda', 'pegawai_images/1nFhMEi0K3nyQkDoL9nChKS17k0hPz1cLS8fbKti.jpg', 2, 3, '2025-07-01 02:45:24', '2025-07-01 02:45:24');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_sub_jabatan`
--

CREATE TABLE `pegawai_sub_jabatan` (
  `id` bigint UNSIGNED NOT NULL,
  `pegawai_id` bigint UNSIGNED NOT NULL,
  `sub_jabatan_id` bigint UNSIGNED NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pegawai_sub_jabatan`
--

INSERT INTO `pegawai_sub_jabatan` (`id`, `pegawai_id`, `sub_jabatan_id`, `tanggal_mulai`, `tanggal_selesai`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 9, '2025-07-01', '2025-07-30', 'Dipindah Kerjakan', '2025-07-01 02:46:26', '2025-07-01 02:46:26'),
(2, 1, 10, '2025-07-05', '2025-07-30', 'contoh', '2025-07-01 02:47:45', '2025-07-01 02:47:45');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian_jawaban`
--

CREATE TABLE `penilaian_jawaban` (
  `id` bigint UNSIGNED NOT NULL,
  `penilaian_kepuasan_id` bigint UNSIGNED NOT NULL,
  `pertanyaan_id` bigint UNSIGNED NOT NULL,
  `jawaban_rating` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penilaian_jawaban`
--

INSERT INTO `penilaian_jawaban` (`id`, `penilaian_kepuasan_id`, `pertanyaan_id`, `jawaban_rating`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, '2025-07-01 02:54:02', '2025-07-01 02:54:02'),
(2, 1, 2, 5, '2025-07-01 02:54:02', '2025-07-01 02:54:02'),
(3, 1, 3, 5, '2025-07-01 02:54:02', '2025-07-01 02:54:02'),
(4, 1, 4, 5, '2025-07-01 02:54:02', '2025-07-01 02:54:02'),
(5, 1, 5, 5, '2025-07-01 02:54:02', '2025-07-01 02:54:02'),
(6, 2, 1, 4, '2025-07-19 04:33:45', '2025-07-19 04:33:45'),
(7, 2, 2, 3, '2025-07-19 04:33:45', '2025-07-19 04:33:45'),
(8, 2, 3, 5, '2025-07-19 04:33:45', '2025-07-19 04:33:45'),
(9, 2, 4, 5, '2025-07-19 04:33:45', '2025-07-19 04:33:45'),
(10, 2, 5, 5, '2025-07-19 04:33:45', '2025-07-19 04:33:45');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian_kepuasan`
--

CREATE TABLE `penilaian_kepuasan` (
  `id` bigint UNSIGNED NOT NULL,
  `parkir_id` bigint UNSIGNED NOT NULL,
  `tuser_id` bigint UNSIGNED NOT NULL,
  `komentar_fasilitas` text COLLATE utf8mb4_unicode_ci,
  `komentar_petugas` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penilaian_kepuasan`
--

INSERT INTO `penilaian_kepuasan` (`id`, `parkir_id`, `tuser_id`, `komentar_fasilitas`, `komentar_petugas`, `created_at`, `updated_at`) VALUES
(1, 5, 2, 'Pertahankan', 'Bagus', '2025-07-01 02:54:02', '2025-07-01 02:54:02'),
(2, 9, 2, 'Untuk lahan parkir sudah memenuhi ekspetasi', 'Petugas sangat ramah', '2025-07-19 04:33:45', '2025-07-19 04:33:45');

-- --------------------------------------------------------

--
-- Table structure for table `slot_parkir`
--

CREATE TABLE `slot_parkir` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_slot` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kapasitas` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slot_parkir`
--

INSERT INTO `slot_parkir` (`id`, `nama_slot`, `kapasitas`, `created_at`, `updated_at`) VALUES
(1, 'A Motor', 100, '2025-06-30 06:46:39', '2025-06-30 06:46:39'),
(2, 'B Mobil', 50, '2025-06-30 06:46:46', '2025-06-30 06:46:46');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `nama`, `no_telp`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'Smith Willyams', '081348209166', 'Jl. Raya No. 12', NULL, NULL),
(2, 'Hillary Abigail', '081348209166', 'Jl. Raya No. 13', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_jabatan`
--

CREATE TABLE `sub_jabatan` (
  `id` bigint UNSIGNED NOT NULL,
  `jabatan_id` bigint UNSIGNED NOT NULL,
  `nama_sub_jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_jabatan`
--

INSERT INTO `sub_jabatan` (`id`, `jabatan_id`, `nama_sub_jabatan`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dokter Umum', NULL, NULL),
(2, 1, 'Dokter Spesialis', NULL, NULL),
(3, 2, 'Perawat IGD', NULL, NULL),
(4, 2, 'Perawat Rawat Inap', NULL, NULL),
(5, 3, 'Satpam Pintu Utama', NULL, NULL),
(6, 3, 'Satpam Parkiran', NULL, NULL),
(7, 4, 'Admin Pendaftaran', NULL, NULL),
(8, 4, 'Admin Rekam Medis', NULL, NULL),
(9, 5, 'Teknisi Listrik', NULL, NULL),
(10, 5, 'Teknisi Mesin', NULL, '2025-07-19 04:13:44'),
(11, 6, 'Petugas Kebersihan Gedung', NULL, NULL),
(12, 6, 'Petugas Kebersihan Taman', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tarif`
--

CREATE TABLE `tarif` (
  `id` bigint UNSIGNED NOT NULL,
  `jenis_tarif` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tarif` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tarif`
--

INSERT INTO `tarif` (`id`, `jenis_tarif`, `tarif`, `kategori_id`, `created_at`, `updated_at`) VALUES
(1, 'Inap', '4000', 1, '2025-06-30 06:47:26', '2025-06-30 06:47:26'),
(2, 'Non Inap', '2000', 1, '2025-06-30 06:47:41', '2025-06-30 06:47:41'),
(3, 'Inap', '8000', 2, '2025-06-30 06:47:52', '2025-06-30 06:47:52'),
(4, 'Non Inap', '4000', 2, '2025-06-30 06:48:02', '2025-06-30 06:48:02');

-- --------------------------------------------------------

--
-- Table structure for table `tuser`
--

CREATE TABLE `tuser` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `staff_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tuser`
--

INSERT INTO `tuser` (`id`, `username`, `password`, `role`, `staff_id`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$12$88aetUtr59KunUX0lWMrqO411iOlve8Om1s9HhIgecrykgVxGYucG', 'admin', 2, NULL, NULL),
(2, 'superadmin', '$2y$12$CpOpUgl0yBIXZnBygjYEKO5nvMLZWqFgMmMakVrCq5DIkNPfonLeq', 'super_admin', 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `coba`
--
ALTER TABLE `coba`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coba_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `denda`
--
ALTER TABLE `denda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `denda_parkir_id_foreign` (`parkir_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `grupp`
--
ALTER TABLE `grupp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_pegawai`
--
ALTER TABLE `jenis_pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kuesioner_pertanyaan`
--
ALTER TABLE `kuesioner_pertanyaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan_pengunjung`
--
ALTER TABLE `laporan_pengunjung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_pengunjung_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parkir`
--
ALTER TABLE `parkir`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `parkir_kode_parkir_unique` (`kode_parkir`),
  ADD KEY `parkir_tarif_id_foreign` (`tarif_id`),
  ADD KEY `parkir_slot_parkir_id_foreign` (`slot_parkir_id`),
  ADD KEY `parkir_user_id_foreign` (`user_id`);

--
-- Indexes for table `parkir_pegawai`
--
ALTER TABLE `parkir_pegawai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parkir_pegawai_pegawai_id_foreign` (`pegawai_id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pegawai_jabatan_id_foreign` (`jabatan_id`),
  ADD KEY `pegawai_sub_jabatan_id_foreign` (`sub_jabatan_id`);

--
-- Indexes for table `pegawai_sub_jabatan`
--
ALTER TABLE `pegawai_sub_jabatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pegawai_sub_jabatan_pegawai_id_foreign` (`pegawai_id`),
  ADD KEY `pegawai_sub_jabatan_sub_jabatan_id_foreign` (`sub_jabatan_id`);

--
-- Indexes for table `penilaian_jawaban`
--
ALTER TABLE `penilaian_jawaban`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penilaian_jawaban_penilaian_kepuasan_id_foreign` (`penilaian_kepuasan_id`),
  ADD KEY `penilaian_jawaban_pertanyaan_id_foreign` (`pertanyaan_id`);

--
-- Indexes for table `penilaian_kepuasan`
--
ALTER TABLE `penilaian_kepuasan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `penilaian_kepuasan_parkir_id_unique` (`parkir_id`),
  ADD KEY `penilaian_kepuasan_tuser_id_foreign` (`tuser_id`);

--
-- Indexes for table `slot_parkir`
--
ALTER TABLE `slot_parkir`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slot_parkir_nama_slot_unique` (`nama_slot`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_jabatan`
--
ALTER TABLE `sub_jabatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_jabatan_jabatan_id_foreign` (`jabatan_id`);

--
-- Indexes for table `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tarif_kategori_id_foreign` (`kategori_id`);

--
-- Indexes for table `tuser`
--
ALTER TABLE `tuser`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tuser_username_unique` (`username`),
  ADD KEY `tuser_staff_id_foreign` (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coba`
--
ALTER TABLE `coba`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `denda`
--
ALTER TABLE `denda`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grupp`
--
ALTER TABLE `grupp`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jenis_pegawai`
--
ALTER TABLE `jenis_pegawai`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kuesioner_pertanyaan`
--
ALTER TABLE `kuesioner_pertanyaan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `laporan_pengunjung`
--
ALTER TABLE `laporan_pengunjung`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `parkir`
--
ALTER TABLE `parkir`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `parkir_pegawai`
--
ALTER TABLE `parkir_pegawai`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pegawai_sub_jabatan`
--
ALTER TABLE `pegawai_sub_jabatan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `penilaian_jawaban`
--
ALTER TABLE `penilaian_jawaban`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `penilaian_kepuasan`
--
ALTER TABLE `penilaian_kepuasan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `slot_parkir`
--
ALTER TABLE `slot_parkir`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_jabatan`
--
ALTER TABLE `sub_jabatan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tarif`
--
ALTER TABLE `tarif`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tuser`
--
ALTER TABLE `tuser`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coba`
--
ALTER TABLE `coba`
  ADD CONSTRAINT `coba_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `denda`
--
ALTER TABLE `denda`
  ADD CONSTRAINT `denda_parkir_id_foreign` FOREIGN KEY (`parkir_id`) REFERENCES `parkir` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `laporan_pengunjung`
--
ALTER TABLE `laporan_pengunjung`
  ADD CONSTRAINT `laporan_pengunjung_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tuser` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `parkir`
--
ALTER TABLE `parkir`
  ADD CONSTRAINT `parkir_slot_parkir_id_foreign` FOREIGN KEY (`slot_parkir_id`) REFERENCES `slot_parkir` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `parkir_tarif_id_foreign` FOREIGN KEY (`tarif_id`) REFERENCES `tarif` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `parkir_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tuser` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `parkir_pegawai`
--
ALTER TABLE `parkir_pegawai`
  ADD CONSTRAINT `parkir_pegawai_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pegawai_sub_jabatan_id_foreign` FOREIGN KEY (`sub_jabatan_id`) REFERENCES `sub_jabatan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pegawai_sub_jabatan`
--
ALTER TABLE `pegawai_sub_jabatan`
  ADD CONSTRAINT `pegawai_sub_jabatan_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pegawai_sub_jabatan_sub_jabatan_id_foreign` FOREIGN KEY (`sub_jabatan_id`) REFERENCES `sub_jabatan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penilaian_jawaban`
--
ALTER TABLE `penilaian_jawaban`
  ADD CONSTRAINT `penilaian_jawaban_penilaian_kepuasan_id_foreign` FOREIGN KEY (`penilaian_kepuasan_id`) REFERENCES `penilaian_kepuasan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penilaian_jawaban_pertanyaan_id_foreign` FOREIGN KEY (`pertanyaan_id`) REFERENCES `kuesioner_pertanyaan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penilaian_kepuasan`
--
ALTER TABLE `penilaian_kepuasan`
  ADD CONSTRAINT `penilaian_kepuasan_parkir_id_foreign` FOREIGN KEY (`parkir_id`) REFERENCES `parkir` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penilaian_kepuasan_tuser_id_foreign` FOREIGN KEY (`tuser_id`) REFERENCES `tuser` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_jabatan`
--
ALTER TABLE `sub_jabatan`
  ADD CONSTRAINT `sub_jabatan_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tarif`
--
ALTER TABLE `tarif`
  ADD CONSTRAINT `tarif_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tuser`
--
ALTER TABLE `tuser`
  ADD CONSTRAINT `tuser_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
