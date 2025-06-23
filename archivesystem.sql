-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2025 at 04:37 AM
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
-- Database: `archivesystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `arsip`
--

CREATE TABLE `arsip` (
  `id` int(11) NOT NULL,
  `nomor_berkas` varchar(50) DEFAULT NULL,
  `judul_berkas` varchar(255) NOT NULL,
  `nomor_item_berkas` varchar(50) NOT NULL,
  `kode_klasifikasi` varchar(100) NOT NULL,
  `uraian_isi` text DEFAULT NULL,
  `kurun_tanggal` date DEFAULT NULL,
  `kurun_tahun` year(4) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `tingkat_perkembangan` varchar(100) DEFAULT NULL,
  `jadwal_aktif` date DEFAULT NULL,
  `jadwal_inaktif` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `lokasi_rak` varchar(100) DEFAULT NULL,
  `lokasi_shelf` varchar(100) DEFAULT NULL,
  `lokasi_boks` varchar(100) DEFAULT NULL,
  `klasifikasi_keamanan` varchar(100) DEFAULT NULL,
  `hak_akses` varchar(100) DEFAULT NULL,
  `bidang` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `upload_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('aktif','inaktif','dimusnahkan') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `arsip`
--

INSERT INTO `arsip` (`id`, `nomor_berkas`, `judul_berkas`, `nomor_item_berkas`, `kode_klasifikasi`, `uraian_isi`, `kurun_tanggal`, `kurun_tahun`, `jumlah`, `satuan`, `tingkat_perkembangan`, `jadwal_aktif`, `jadwal_inaktif`, `keterangan`, `lokasi_rak`, `lokasi_shelf`, `lokasi_boks`, `klasifikasi_keamanan`, `hak_akses`, `bidang`, `created_at`, `upload_date`, `status`) VALUES
(1, '1', 'abc', '2', '54321abc', 'qwerty', '2025-06-18', '2025', 1, 'BOKS', 'asli', '2025-06-18', '2025-06-19', 'abcdefg', '1', '2', '3', 'terbatas', 'asdep bidang', 'SDM Umum dan Komunikasi', '2025-06-18 08:41:31', '2025-06-22 01:02:47', ''),
(2, '1', 'qwertyabcd', '2', '12', 'qwerty', '2025-06-22', '2025', 1, 'BOKS', 'asli', '2025-06-22', '2025-06-24', 'abcdefg', '1', '2', '3', 'terbatas', 'asdep bidang', 'Perencanaan dan Keuangan', '2025-06-21 17:13:39', '2025-06-22 01:13:39', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(20) DEFAULT NULL,
  `bidang` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `password`, `created_at`, `phone`, `bidang`) VALUES
(1, 'steve kevins', 'stevekevins', 'stevekevins@gmail.com', '$2y$10$vVSGeRDjHHNwHk4gVJWawevJKaZbjVPznvw0Rsofgzt/xUDVYu5Gu', '2025-06-18 06:28:49', NULL, NULL),
(2, 'steve kevin', 'stevekevin', 'stevekevin@gmail.com', '$2y$10$ZJ97cgpbLWJcl0JXvYNxj.fIqmh0z2DD.INnoUODbEr7a7nbdZ3NW', '2025-06-18 06:36:07', NULL, NULL),
(3, 'steve kevin', 'stevekevinss', 'stevekevinss@gmail.com', '$2y$10$FpRCcSWyEtYF.vdIEWlojuEcV2jLl2XgbajMshv3R17nTc87Fe6la', '2025-06-18 08:17:53', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arsip`
--
ALTER TABLE `arsip`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arsip`
--
ALTER TABLE `arsip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
