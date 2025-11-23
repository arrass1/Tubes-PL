-- Database: event_management

CREATE DATABASE IF NOT EXISTS event_management;
USE event_management;

-- Table: events
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_event VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    tanggal_event DATE NOT NULL,
    lokasi VARCHAR(255) NOT NULL,
    harga_tiket DECIMAL(10,2) NOT NULL,
    kapasitas INT NOT NULL,
    kategori VARCHAR(100) NOT NULL,
    status ENUM('Aktif', 'Selesai', 'Dibatalkan') DEFAULT 'Aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table: tiket_terjual
CREATE TABLE IF NOT EXISTS tiket_terjual (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    nama_pembeli VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    jumlah_tiket INT NOT NULL,
    total_harga DECIMAL(10,2) NOT NULL,
    tanggal_pembelian TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

-- Table: users (untuk admin)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff') DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample events
INSERT INTO events (nama_event, deskripsi, tanggal_event, lokasi, harga_tiket, kapasitas, kategori, status) VALUES
('Jazz Festival 2025', 'Festival musik jazz terbesar di Indonesia dengan berbagai artis ternama', '2025-01-15', 'Jakarta Convention Center', 250000.00, 5000, 'Musik', 'Aktif'),
('Rock Concert - The Legends', 'Konser rock legendaris dengan band-band terbaik', '2025-02-20', 'Gelora Bung Karno Stadium', 350000.00, 10000, 'Musik', 'Aktif'),
('Tech Conference 2025', 'Konferensi teknologi dengan pembicara dari Silicon Valley', '2025-03-10', 'Bali International Convention Center', 500000.00, 2000, 'Konferensi', 'Aktif'),
('Food Festival', 'Festival kuliner nusantara dengan 100+ booth makanan', '2025-01-25', 'Senayan City', 50000.00, 8000, 'Festival', 'Aktif'),
('Stand Up Comedy Night', 'Malam komedi dengan komedian terkenal', '2025-02-05', 'Taman Ismail Marzuki', 150000.00, 1500, 'Komedi', 'Aktif'),
('Classical Music Concert', 'Konser musik klasik oleh Jakarta Symphony Orchestra', '2025-02-14', 'Aula Simfonia Jakarta', 200000.00, 1200, 'Musik', 'Aktif');

-- Insert sample admin user (password: admin123)
INSERT INTO users (username, password, nama_lengkap, email, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Event Administrator', 'admin@eventmanagement.com', 'admin');

-- Insert sample ticket sales
INSERT INTO tiket_terjual (event_id, nama_pembeli, email, jumlah_tiket, total_harga) VALUES
(1, 'John Doe', 'john@example.com', 2, 500000.00),
(1, 'Jane Smith', 'jane@example.com', 3, 750000.00),
(2, 'Bob Wilson', 'bob@example.com', 1, 350000.00),
(3, 'Alice Brown', 'alice@example.com', 2, 1000000.00),
(4, 'Charlie Davis', 'charlie@example.com', 4, 200000.00);

-- Table: customers (end users / customers)
CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    no_telepon VARCHAR(50),
    role ENUM('customer','member') DEFAULT 'customer',
    tanggal_daftar TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: tiket (ticket types for events)
CREATE TABLE IF NOT EXISTS tiket (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    nama_tiket VARCHAR(255) NOT NULL,
    harga DECIMAL(10,2) NOT NULL DEFAULT 0,
    stok INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

-- Sample customers (password tanpa enkripsi/hash)
INSERT INTO customers (nama, email, password, no_telepon, role) VALUES
('Budi Santoso', 'budi@example.com', 'password123', '081234567890', 'customer'),
('Siti Aminah', 'siti@example.com', 'password123', '082345678901', 'member');

-- Sample tiket types
INSERT INTO tiket (event_id, nama_tiket, harga, stok) VALUES
(1, 'VIP', 500000.00, 100),
(1, 'Regular', 250000.00, 1000),
(2, 'Festival Pass', 350000.00, 200);

-- Table: pemesanan (Orders/Bookings)
CREATE TABLE IF NOT EXISTS pemesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    event_id INT NOT NULL,
    jumlah_tiket INT NOT NULL,
    total_harga DECIMAL(10,2) NOT NULL,
    status ENUM('Pending', 'Disetujui', 'Ditolak') DEFAULT 'Pending',
    kode_booking VARCHAR(50) NOT NULL UNIQUE,
    tanggal_pemesanan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

-- Sample pemesanan/orders (optional - for testing)
INSERT INTO pemesanan (customer_id, event_id, jumlah_tiket, total_harga, status, kode_booking) VALUES
(1, 1, 2, 500000.00, 'Pending', 'BK12345ABC'),
(2, 2, 1, 350000.00, 'Disetujui', 'BK67890DEF');