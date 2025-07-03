-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2025 at 01:25 PM
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
-- Database: `db_rc`
--

-- --------------------------------------------------------

--
-- Table structure for table `kostum`
--

CREATE TABLE `kostum` (
  `id` int(11) NOT NULL,
  `nama_kostum` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kostum`
--

INSERT INTO `kostum` (`id`, `nama_kostum`, `harga`, `deskripsi`, `gambar`) VALUES
(7, 'Vergil', 2147483647, 'Orang keren', '686525cca7a2a_Vergil.jpg'),
(8, 'Bocchi', 1000000000, 'Pahlawan Gitar', '68652612a5b00_Bocchi.png'),
(10, 'Kirito', 200000, 'Kirigaya Kazutod', '68652ecd23a84_kiritod.jpeg'),
(11, 'Asuna', 500000, '', '68652eecda918_Asuna.jpg'),
(12, 'Kaneki', 600000, '', '68652f1fb1081_Kaneki.jpg'),
(13, 'Ayanobiji', 5000000, '', '68652f3dbfaa9_Ayanabiji.jpg'),
(14, 'Gigachad', 200000, 'Gw banget', '68653377df809_Gigachad.jpeg'),
(15, 'Teto', 2000000000, '', '68663d2832b93_Teto.avif'),
(16, 'Miku', 2147483647, '', '68663d4891227_Miku.webp');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kostum_id` int(11) NOT NULL,
  `tanggal_sewa` date NOT NULL,
  `durasi` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status` enum('pending','diproses','selesai','dibatalkan') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `bukti_pembayaran` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `user_id`, `kostum_id`, `tanggal_sewa`, `durasi`, `total_harga`, `status`, `created_at`, `bukti_pembayaran`) VALUES
(1, 2, 12, '2025-07-03', 3, 1800000, 'pending', '2025-07-03 09:33:02', NULL),
(2, 2, 8, '2025-07-24', 6, 2147483647, 'pending', '2025-07-03 09:34:04', NULL),
(3, 2, 8, '2025-07-04', 3, 2147483647, 'pending', '2025-07-03 09:35:01', NULL),
(4, 2, 10, '2025-07-10', 1, 200000, 'pending', '2025-07-03 09:35:59', NULL),
(5, 2, 11, '2025-07-04', 4, 2000000, 'pending', '2025-07-03 09:57:04', NULL),
(6, 2, 8, '2025-07-04', 3, 2147483647, 'pending', '2025-07-03 10:05:36', NULL),
(7, 2, 8, '2025-07-04', 3, 2147483647, 'pending', '2025-07-03 10:06:13', NULL),
(8, 2, 8, '2025-07-04', 3, 2147483647, 'pending', '2025-07-03 10:07:26', NULL),
(9, 2, 8, '2025-07-03', 3, 2147483647, 'selesai', '2025-07-03 10:08:07', '68665792cb93d_nota.jpg'),
(10, 3, 10, '2025-07-03', 3, 600000, 'diproses', '2025-07-03 10:37:43', '68665d847e616_dog.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Ligma', 'ligma@gmail.com', '202cb962ac59075b964b07152d234b70', 'admin', '2025-07-02 10:16:00'),
(2, 'Ambawir', 'ambawir69@gmail.com', '862311690b13ae67c123f8e7a922ec19', 'user', '2025-07-02 11:20:51'),
(3, 'John Titor', 'johntor@gmail.com', '202cb962ac59075b964b07152d234b70', 'user', '2025-07-03 10:37:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kostum`
--
ALTER TABLE `kostum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kostum`
--
ALTER TABLE `kostum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
