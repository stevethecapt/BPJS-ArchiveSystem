-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2025 at 04:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arsip_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `arsip`
--

CREATE TABLE `arsip` (
  `id` int(11) NOT NULL,
  `nomor_berkas` int(100) NOT NULL,
  `judul_berkas` varchar(255) NOT NULL,
  `nomor_item_berkas` varchar(50) NOT NULL,
  `kode_klasifikasi` varchar(50) NOT NULL,
  `uraian_isi` text NOT NULL,
  `kurun_tanggal` date NOT NULL,
  `kurun_tahun` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `tingkat_perkembangan` varchar(100) NOT NULL,
  `jadwal_aktif` date NOT NULL,
  `jadwal_inaktif` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `lokasi_rak` varchar(50) NOT NULL,
  `lokasi_shelf` varchar(50) NOT NULL,
  `lokasi_boks` varchar(50) NOT NULL,
  `klasifikasi_keamanan` varchar(100) NOT NULL,
  `hak_akses` varchar(100) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `bidang` enum('SDM Umum dan Komunikasi','Perencanaan dan Keuangan','Kepesertaan dan Mutu Layanan','Jaminan Pelayanan Kesehatan') NOT NULL,
  `tanggal_pemusnahan` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `arsip`
--

INSERT INTO `arsip` (`id`, `nomor_berkas`, `judul_berkas`, `nomor_item_berkas`, `kode_klasifikasi`, `uraian_isi`, `kurun_tanggal`, `kurun_tahun`, `jumlah`, `satuan`, `tingkat_perkembangan`, `jadwal_aktif`, `jadwal_inaktif`, `keterangan`, `lokasi_rak`, `lokasi_shelf`, `lokasi_boks`, `klasifikasi_keamanan`, `hak_akses`, `upload_date`, `bidang`, `tanggal_pemusnahan`) VALUES
(97, 2, 'qwertyabcd', '2', 'abc12345', 'qwerty123', '2025-03-18', 2025, 1, 'BOKS', 'asli', '2025-03-18', '2026-03-18', 'abcdefg', '1', '2', '3', 'terbatas', 'asdep bidang', '2025-03-18 05:55:01', 'Perencanaan dan Keuangan', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arsip`
--
ALTER TABLE `arsip`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arsip`
--
ALTER TABLE `arsip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
