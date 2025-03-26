-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2025 at 10:05 AM
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
(96, 1, 'qwertyabcd', '1', 'abc12345', 'abcdqwerty', '2025-03-17', 2025, 1, 'BOKS', 'asli', '2025-03-17', '2025-03-20', 'abcdefg', '1', '2', '3', 'terbatas', 'asdep bidang', '2025-03-17 03:29:18', 'SDM Umum dan Komunikasi', NULL),
(97, 2, 'qwertyabcd', '2', 'abc12345', 'qwerty123', '2025-03-18', 2025, 1, 'BOKS', 'asli', '2025-03-18', '2026-03-18', 'abcdefg', '1', '2', '3', 'terbatas', 'asdep bidang', '2025-03-18 05:55:01', 'Perencanaan dan Keuangan', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `bidang` enum('SDM Umum dan Komunikasi','Perencanaan dan Keuangan','Kepesertaan dan Mutu Layanan','Jaminan Pelayanan Kesehatan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `phone`, `address`, `email`, `password`, `bidang`) VALUES
(49, 'stevekevins', '', '', '', 'stevekevins@gmail.com', '$2y$10$krFV88fKsjaRon2cWJn7PO2L1tHnsfojL1ELk/zmwdbJXA4wFKF6i', ''),
(50, 'girikanan', '', '', '', 'girikanan@gmail.com', '$2y$10$FmeVK2i9OxwT12YwNzOKOuzG/tnwud69ZomTRC2/3xNS/whyX2pzy', ''),
(51, 'chris', '', '', '', 'chris@gmail.com', '$2y$10$Ia43iaU6frjwdSZJVblg5O2cYgrfcF0WgftS/lXjpg4KS8CIa3qmm', ''),
(52, 'stevenk', '', '', '', 'stvenkvn@gmail.com', '$2y$10$3suJJ2ZIDcKAKnSVPEHHjeZq5rr1gg4t4FTLfof27dRbXhar8mFfa', ''),
(53, 'ken', '', '', '', 'ken@gmail.com', '$2y$10$bsBJrF7w76pMDzJIDYfYpeAPTeUkiSYSZjo5DZMfHn1vkaqe7.lsW', ''),
(54, 'stevekevin', 'steve kevin', '', '', 'steven@gmail.com', '$2y$10$/2UkDZUgBm1y2sdb.vPLKuIB.b7nfeI.xR17V9fZeIwe28i/.ds5.', 'SDM Umum dan Komunikasi');

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arsip`
--
ALTER TABLE `arsip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
