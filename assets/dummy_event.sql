-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 16, 2025 at 02:55 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dummy_event`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_telepon` varchar(50) DEFAULT NULL,
  `tanggal_daftar` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `nama`, `email`, `password`, `no_telepon`, `tanggal_daftar`) VALUES
(9, 'Budi Santoso', 'budi@example.com', 'password123', '081234567890', '2025-11-23 02:31:24'),
(12, 'tess', 'tess@gmail.com', '123456', '623', '2025-11-25 01:11:52'),
(13, 'farras', 'farras@gmail.com', '123456', '089553831905', '2025-12-06 07:09:45');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `nama_event` varchar(255) NOT NULL,
  `deskripsi` text,
  `tanggal_event` date NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `status` enum('Aktif','Selesai','Dibatalkan') DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `nama_event`, `deskripsi`, `tanggal_event`, `lokasi`, `kategori`, `status`, `created_at`, `updated_at`, `image`) VALUES
(7, 'JKT48', 'Konser JKT48', '2025-11-26', 'Jakarta GBK', 'Konser', 'Aktif', '2025-11-23 00:13:40', '2025-12-07 13:23:51', 'assets/uploads/events/event_1765113831_69357fe7b03a3.webp'),
(21, 'Hindia', 'Konser musik', '2025-12-07', 'Jakarta GBK', 'Musik', 'Aktif', '2025-12-07 13:21:35', '2025-12-07 13:25:10', 'assets/uploads/events/event_1765113695_69357f5f77400.webp');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int NOT NULL,
  `pemesanan_id` int NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `jumlah_bayar` decimal(10,2) NOT NULL,
  `status_pembayaran` enum('Menunggu','Berhasil','Gagal') DEFAULT 'Menunggu',
  `kode_pembayaran` varchar(50) NOT NULL,
  `tanggal_pembayaran` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_bayar` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `pemesanan_id`, `metode_pembayaran`, `jumlah_bayar`, `status_pembayaran`, `kode_pembayaran`, `tanggal_pembayaran`, `tanggal_bayar`) VALUES
(6, 22, 'OVO', '10000000.00', 'Berhasil', 'PAY3A6EC4C420', '2025-12-07 09:57:11', '2025-12-07 09:57:11'),
(9, 25, 'DANA', '1000000.00', 'Berhasil', 'PAY6853FDB013', '2025-12-07 13:42:57', '2025-12-07 13:42:57'),
(10, 26, 'GoPay', '10000000.00', 'Berhasil', 'PAY8875567F44', '2025-12-07 14:01:49', '2025-12-07 14:01:49'),
(11, 27, 'BRI', '10000000.00', 'Berhasil', 'PAY48C1088168', '2025-12-08 01:59:06', '2025-12-08 01:59:06'),
(12, 28, 'QRIS', '5000000.00', 'Berhasil', 'PAY369F46A246', '2025-12-08 02:02:55', '2025-12-08 02:02:55'),
(13, 29, 'GoPay', '1000000.00', 'Berhasil', 'PAY0A40604DEE', '2025-12-08 02:52:00', '2025-12-08 02:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `tiket_id` int DEFAULT NULL,
  `jumlah_tiket` int NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status` enum('Pending','Disetujui','Ditolak') DEFAULT 'Pending',
  `kode_booking` varchar(50) NOT NULL,
  `tanggal_pemesanan` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `customer_id`, `tiket_id`, `jumlah_tiket`, `total_harga`, `status`, `kode_booking`, `tanggal_pemesanan`) VALUES
(22, 13, 7, 1, '10000000.00', 'Disetujui', 'BK2C1BC74D', '2025-12-07 09:57:04'),
(25, 13, 8, 1, '1000000.00', 'Disetujui', 'BK6C38FAEA', '2025-12-07 13:42:54'),
(26, 13, 8, 10, '10000000.00', 'Disetujui', 'BK160B1412', '2025-12-07 14:01:45'),
(27, 13, 8, 10, '10000000.00', 'Disetujui', 'BKBA4D88CB', '2025-12-08 01:59:03'),
(28, 13, 9, 5, '5000000.00', 'Disetujui', 'BKB12867F2', '2025-12-08 02:02:50'),
(29, 13, 8, 1, '1000000.00', 'Disetujui', 'BK85D787EF', '2025-12-08 02:51:54');

-- --------------------------------------------------------

--
-- Table structure for table `tiket`
--

CREATE TABLE `tiket` (
  `id` int NOT NULL,
  `event_id` int NOT NULL,
  `nama_tiket` varchar(255) NOT NULL,
  `harga` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stok` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tiket`
--

INSERT INTO `tiket` (`id`, `event_id`, `nama_tiket`, `harga`, `stok`, `created_at`) VALUES
(7, 7, 'VIP', '10000000.00', 88, '2025-11-25 07:52:50'),
(8, 21, 'Regular', '1000000.00', 78, '2025-12-07 13:24:29'),
(9, 21, 'VIP', '1000000.00', 95, '2025-12-08 02:01:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_pembayaran` (`kode_pembayaran`),
  ADD KEY `fk_pembayaran_pemesanan` (`pemesanan_id`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_booking` (`kode_booking`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `pemesanan_ibfk_2` (`tiket_id`);

--
-- Indexes for table `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_pembayaran_pemesanan` FOREIGN KEY (`pemesanan_id`) REFERENCES `pemesanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pemesanan_ibfk_2` FOREIGN KEY (`tiket_id`) REFERENCES `tiket` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tiket`
--
ALTER TABLE `tiket`
  ADD CONSTRAINT `tiket_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
