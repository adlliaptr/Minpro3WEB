-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2024 at 07:15 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webekspedisi`
--

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_depan` varchar(50) NOT NULL,
  `nama_belakang` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nomor_telepon` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `kota` varchar(50) NOT NULL,
  `provinsi` varchar(50) NOT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `tanggal_daftar` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_depan`, `nama_belakang`, `email`, `nomor_telepon`, `alamat`, `kota`, `provinsi`, `kode_pos`, `tanggal_daftar`) VALUES
(2, 'Chandra', 'Nasution', 'chandraa@email.com', '081298765432', 'Jl. Cendrawasih', 'Depok', 'Jawa Barat', '15414', '2024-04-02 04:01:54'),
(3, 'Sri', 'Yuliani S', 'sri@email.com', '09876543241', 'J. Kasih', 'Tangerang Selatan', 'Banten', '15414', '2024-04-02 07:28:39'),
(5, 'Testing', '123', 'test@email.com', '08787263', 'Jl. Jalan', 'Banyuasin', 'Sumatera Selatan', '15000', '2024-04-02 08:14:29');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `provinsi_pengirim` varchar(255) NOT NULL,
  `kota_pengirim` varchar(255) NOT NULL,
  `kode_pos_pengirim` varchar(10) NOT NULL,
  `alamat_pengirim` text NOT NULL,
  `provinsi_tujuan` varchar(255) NOT NULL,
  `kota_tujuan` varchar(255) NOT NULL,
  `kode_pos_tujuan` varchar(10) NOT NULL,
  `alamat_tujuan` text NOT NULL,
  `berat` int(11) NOT NULL,
  `detail` text DEFAULT NULL,
  `courier` varchar(50) NOT NULL,
  `service` varchar(50) NOT NULL,
  `biaya` decimal(10,2) NOT NULL,
  `status` enum('Menunggu Pembayaran','Diproses','Dikirim','Diterima','Selesai','Batal') NOT NULL,
  `tanggal_pemesanan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `id_pelanggan`, `provinsi_pengirim`, `kota_pengirim`, `kode_pos_pengirim`, `alamat_pengirim`, `provinsi_tujuan`, `kota_tujuan`, `kode_pos_tujuan`, `alamat_tujuan`, `berat`, `detail`, `courier`, `service`, `biaya`, `status`, `tanggal_pemesanan`) VALUES
(3, 3, 'Banten', 'Tangerang Selatan', '15414', 'Bintaro', 'DI Yogyakarta', 'Bantul', '55185', 'Pendowoharjo', 3000, 'Sepatu', 'tiki', 'ECO', 57000.00, 'Diproses', '2024-04-02 11:12:52'),
(4, 2, 'Bali', 'Denpasar', '80111', 'Jl. Tabanan', 'Banten', 'Tangerang', '15122', 'Cipondoh', 3000, 'Sepatu', 'jne', 'OKE', 60000.00, 'Batal', '2024-04-02 12:20:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `created_at`) VALUES
(1, 'Testing', 'Ayo', 'testing@email.com', '$2y$10$A56INEJGGXiJW.2yaOwSxenC.D1kNklGjKKk4ZoNf63S0zg3FgofC', '2024-04-02 03:09:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

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
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
