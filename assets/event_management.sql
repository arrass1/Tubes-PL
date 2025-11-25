-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 25, 2025 at 03:13 AM
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
-- Database: `event_management`
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
(11, 'tes', 'test@gmail.com', '123456', '8000000', 'customer', '2025-11-23 08:49:12'),
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
  `harga_tiket` decimal(10,2) NOT NULL,
  `kapasitas` int NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `status` enum('Aktif','Selesai','Dibatalkan') DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `nama_event`, `deskripsi`, `tanggal_event`, `lokasi`, `harga_tiket`, `kapasitas`, `kategori`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Jazz Festival 2025', 'Festival musik jazz terbesar di Indonesia dengan berbagai artis ternama', '2025-01-15', 'Jakarta Convention Center', '250000.00', 5000, 'Musik', 'Aktif', '2025-11-22 22:10:43', '2025-11-22 22:10:43'),
(2, 'Rock Concert - The Legends', 'Konser rock legendaris dengan band-band terbaik', '2025-02-20', 'Gelora Bung Karno Stadium', '350000.00', 10000, 'Musik', 'Aktif', '2025-11-22 22:10:43', '2025-11-22 22:10:43'),
(3, 'Tech Conference 2025', 'Konferensi teknologi dengan pembicara dari Silicon Valley', '2025-03-10', 'Bali International Convention Center', '500000.00', 2000, 'Konferensi', 'Aktif', '2025-11-22 22:10:43', '2025-11-22 22:10:43'),
(4, 'Food Festival', 'Festival kuliner nusantara dengan 100+ booth makanan', '2025-01-25', 'Senayan City', '50000.00', 8000, 'Festival', 'Aktif', '2025-11-22 22:10:43', '2025-11-22 22:10:43'),
(5, 'Stand Up Comedy Night', 'Malam komedi dengan komedian terkenal', '2025-02-05', 'Taman Ismail Marzuki', '150000.00', 1500, 'Komedi', 'Aktif', '2025-11-22 22:10:43', '2025-11-22 22:10:43'),
(6, 'Classical Music Concert', 'Konser musik klasik oleh Jakarta Symphony Orchestra', '2025-02-14', 'Aula Simfonia Jakarta', '200000.00', 1200, 'Musik', 'Aktif', '2025-11-22 22:10:43', '2025-11-22 22:10:43'),
(7, 'JKT48', 'Konser JKT48', '2025-11-26', 'Jakarta GBK', '1000000.00', 10000, 'Konser', 'Aktif', '2025-11-23 00:13:40', '2025-11-23 00:13:40'),
(8, 'Jazz Festival 2025', 'Festival musik jazz terbesar di Indonesia dengan berbagai artis ternama', '2025-01-15', 'Jakarta Convention Center', '250000.00', 5000, 'Musik', 'Aktif', '2025-11-23 02:27:49', '2025-11-23 02:27:49'),
(9, 'Rock Concert - The Legends', 'Konser rock legendaris dengan band-band terbaik', '2025-02-20', 'Gelora Bung Karno Stadium', '350000.00', 10000, 'Musik', 'Aktif', '2025-11-23 02:27:49', '2025-11-23 02:27:49'),
(10, 'Tech Conference 2025', 'Konferensi teknologi dengan pembicara dari Silicon Valley', '2025-03-10', 'Bali International Convention Center', '500000.00', 2000, 'Konferensi', 'Aktif', '2025-11-23 02:27:49', '2025-11-23 02:27:49'),
(11, 'Food Festival', 'Festival kuliner nusantara dengan 100+ booth makanan', '2025-01-25', 'Senayan City', '50000.00', 8000, 'Festival', 'Aktif', '2025-11-23 02:27:49', '2025-11-23 02:27:49'),
(12, 'Stand Up Comedy Night', 'Malam komedi dengan komedian terkenal', '2025-02-05', 'Taman Ismail Marzuki', '150000.00', 1500, 'Komedi', 'Aktif', '2025-11-23 02:27:49', '2025-11-23 02:27:49'),
(13, 'Classical Music Concert', 'Konser musik klasik oleh Jakarta Symphony Orchestra', '2025-02-14', 'Aula Simfonia Jakarta', '200000.00', 1200, 'Musik', 'Aktif', '2025-11-23 02:27:49', '2025-11-23 02:27:49'),
(14, 'Jazz Festival 2025', 'Festival musik jazz terbesar di Indonesia dengan berbagai artis ternama', '2025-01-15', 'Jakarta Convention Center', '250000.00', 5000, 'Musik', 'Aktif', '2025-11-23 02:28:08', '2025-11-23 02:28:08'),
(15, 'Rock Concert - The Legends', 'Konser rock legendaris dengan band-band terbaik', '2025-02-20', 'Gelora Bung Karno Stadium', '350000.00', 10000, 'Musik', 'Aktif', '2025-11-23 02:28:08', '2025-11-23 02:28:08'),
(16, 'Tech Conference 2025', 'Konferensi teknologi dengan pembicara dari Silicon Valley', '2025-03-10', 'Bali International Convention Center', '500000.00', 2000, 'Konferensi', 'Aktif', '2025-11-23 02:28:08', '2025-11-23 02:28:08'),
(17, 'Food Festival', 'Festival kuliner nusantara dengan 100+ booth makanan', '2025-01-25', 'Senayan City', '50000.00', 8000, 'Festival', 'Aktif', '2025-11-23 02:28:08', '2025-11-23 02:28:08'),
(18, 'Stand Up Comedy Night', 'Malam komedi dengan komedian terkenal', '2025-02-05', 'Taman Ismail Marzuki', '150000.00', 1500, 'Komedi', 'Aktif', '2025-11-23 02:28:08', '2025-11-23 02:28:08'),
(19, 'Classical Music Concert', 'Konser musik klasik oleh Jakarta Symphony Orchestra', '2025-02-14', 'Aula Simfonia Jakarta', '200000.00', 1200, 'Musik', 'Aktif', '2025-11-23 02:28:08', '2025-11-23 02:28:08');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `event_id` int NOT NULL,
  `jumlah_tiket` int NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status` enum('Pending','Disetujui','Ditolak') DEFAULT 'Pending',
  `kode_booking` varchar(50) NOT NULL,
  `tanggal_pemesanan` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `customer_id`, `event_id`, `jumlah_tiket`, `total_harga`, `status`, `kode_booking`, `tanggal_pemesanan`) VALUES
(3, 9, 7, 2, '2000000.00', 'Disetujui', 'BK3027948B', '2025-11-23 02:41:14'),
(5, 12, 7, 1, '1000000.00', 'Disetujui', 'BKF8605362', '2025-11-25 01:41:31');

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
(1, 1, 'VIP', '500000.00', 100, '2025-11-22 22:33:51'),
(2, 1, 'Regular', '250000.00', 1000, '2025-11-22 22:33:51'),
(3, 2, 'Festival Pass', '350000.00', 200, '2025-11-22 22:33:51'),
(4, 1, 'VIP', '500000.00', 100, '2025-11-23 02:28:16'),
(5, 1, 'Regular', '250000.00', 1000, '2025-11-23 02:28:16'),
(6, 2, 'Festival Pass', '350000.00', 200, '2025-11-23 02:28:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','staff') DEFAULT 'staff',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `email`, `role`, `created_at`) VALUES
(1, 'admin', 'admin123', 'Event Administrator', 'admin@eventmanagement.com', 'admin', '2025-11-23 08:37:20');

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
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pemesanan_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tiket`
--
ALTER TABLE `tiket`
  ADD CONSTRAINT `tiket_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
