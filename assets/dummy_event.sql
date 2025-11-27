-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 27, 2025 at 01:04 AM
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
  `role` enum('customer','member') DEFAULT 'customer',
  `tanggal_daftar` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `nama`, `email`, `password`, `no_telepon`, `role`, `tanggal_daftar`) VALUES
(9, 'Budi Santoso', 'budi@example.com', 'password123', '081234567890', 'customer', '2025-11-23 02:31:24'),
(10, 'Siti Aminah', 'siti@example.com', 'password123', '082345678901', 'member', '2025-11-23 02:31:24'),
(12, 'tess', 'tess@gmail.com', '123456', '623', 'customer', '2025-11-25 01:11:52');

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
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `nama_event`, `deskripsi`, `tanggal_event`, `lokasi`, `kategori`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Jazz Festival 2025', 'Festival musik jazz terbesar di Indonesia dengan berbagai artis ternama', '2025-01-15', 'Jakarta Convention Center', 'Musik', 'Aktif', '2025-11-22 22:10:43', '2025-11-22 22:10:43'),
(2, 'Rock Concert - The Legends', 'Konser rock legendaris dengan band-band terbaik', '2025-02-20', 'Gelora Bung Karno Stadium', 'Musik', 'Aktif', '2025-11-22 22:10:43', '2025-11-22 22:10:43'),
(3, 'Tech Conference 2025', 'Konferensi teknologi dengan pembicara dari Silicon Valley', '2025-03-10', 'Bali International Convention Center', 'Konferensi', 'Aktif', '2025-11-22 22:10:43', '2025-11-22 22:10:43'),
(5, 'Stand Up Comedy Night', 'Malam komedi dengan komedian terkenal', '2025-02-05', 'Taman Ismail Marzuki', 'Komedi', 'Aktif', '2025-11-22 22:10:43', '2025-11-22 22:10:43'),
(7, 'JKT48', 'Konser JKT48', '2025-11-26', 'Jakarta GBK', 'Konser', 'Aktif', '2025-11-23 00:13:40', '2025-11-23 00:13:40'),
(9, 'Rock Concert - The Legends', 'Konser rock legendaris dengan band-band terbaik', '2025-02-20', 'Gelora Bung Karno Stadium', 'Musik', 'Aktif', '2025-11-23 02:27:49', '2025-11-23 02:27:49'),
(10, 'Tech Conference 2025', 'Konferensi teknologi dengan pembicara dari Silicon Valley', '2025-03-10', 'Bali International Convention Center', 'Konferensi', 'Aktif', '2025-11-23 02:27:49', '2025-11-23 02:27:49'),
(12, 'Stand Up Comedy Night', 'Malam komedi dengan komedian terkenal', '2025-02-05', 'Taman Ismail Marzuki', 'Komedi', 'Aktif', '2025-11-23 02:27:49', '2025-11-23 02:27:49'),
(13, 'Classical Music Concert', 'Konser musik klasik oleh Jakarta Symphony Orchestra', '2025-02-14', 'Aula Simfonia Jakarta', 'Musik', 'Aktif', '2025-11-23 02:27:49', '2025-11-23 02:27:49'),
(16, 'Tech Conference 2025', 'Konferensi teknologi dengan pembicara dari Silicon Valley', '2025-03-10', 'Bali International Convention Center', 'Konferensi', 'Aktif', '2025-11-23 02:28:08', '2025-11-23 02:28:08'),
(19, 'Classical Music Concert', 'Konser musik klasik oleh Jakarta Symphony Orchestra', '2025-02-14', 'Aula Simfonia Jakarta', 'Musik', 'Aktif', '2025-11-23 02:28:08', '2025-11-23 02:28:08');

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
(7, 12, 7, 1, '10000000.00', 'Disetujui', 'BKED9F7F3B', '2025-11-25 07:53:16');

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
(7, 7, 'VIP', '10000000.00', 100, '2025-11-25 07:52:50');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

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
