-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2023 at 12:17 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bukberramadhan`
--

-- --------------------------------------------------------

--
-- Table structure for table `kode_kupon`
--

CREATE TABLE `kode_kupon` (
  `id` int(11) UNSIGNED NOT NULL,
  `kode` varchar(20) NOT NULL,
  `digunakan` tinyint(1) DEFAULT 0,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kupon`
--

CREATE TABLE `kupon` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `kode_kupon` varchar(15) NOT NULL,
  `qrcode` longblob DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('kupon belum di tukarkan','digunakan') NOT NULL DEFAULT 'kupon belum di tukarkan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kupontelahdireedem`
--

CREATE TABLE `kupontelahdireedem` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `kode_kupon` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kupontelahdireedem`
--

-- INSERT INTO `kupontelahdireedem` (`id`, `nama`, `no_hp`, `kode_kupon`) VALUES
-- (6, 'hilmy', '081259621505', 'R4U1PeBpF6wXUpR'),
-- (7, 'indira', '0811311465', '9QGfzCUEnKuOMb9'),
-- (8, 'susi', '0811311465', 'ojl4Xr4PlGKCTXv'),
-- (9, 'heri', '082244110088', '9q0P6QGiV3c41aa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kode_kupon`
--
ALTER TABLE `kode_kupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kupon`
--
ALTER TABLE `kupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kupontelahdireedem`
--
ALTER TABLE `kupontelahdireedem`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kode_kupon`
--
ALTER TABLE `kode_kupon`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kupon`
--
ALTER TABLE `kupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `kupontelahdireedem`
--
ALTER TABLE `kupontelahdireedem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
