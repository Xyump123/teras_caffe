-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2026 at 05:16 PM
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
-- Database: `teras_caffe`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` int(11) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `nama_menu` varchar(255) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL,
  `level_pedas` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id`, `id_transaksi`, `id_menu`, `nama_menu`, `harga`, `qty`, `subtotal`, `level_pedas`) VALUES
(46, 42, 7, 'Chicken Katsu', 12000, 1, 12000, NULL),
(47, 43, 7, 'Chicken Katsu', 12000, 1, 12000, NULL),
(48, 44, 7, 'Chicken Katsu', 12000, 1, 12000, '2'),
(49, 45, 7, 'Chicken Katsu', 12000, 1, 12000, '2'),
(50, 45, 40, 'Jus Mangga', 10000, 1, 10000, NULL),
(51, 46, 7, 'Chicken Katsu', 12000, 1, 12000, '5'),
(52, 46, 40, 'Jus Mangga', 10000, 2, 20000, NULL),
(53, 47, 40, 'Jus Mangga', 10000, 3, 30000, NULL),
(54, 48, 7, 'Chicken Katsu', 12000, 1, 12000, '4'),
(55, 48, 39, 'Pisang Goreng Coklat', 12000, 1, 12000, NULL),
(56, 48, 40, 'Jus Mangga', 10000, 1, 10000, NULL),
(57, 49, 7, 'Chicken Katsu', 12000, 1, 12000, '5'),
(58, 49, 40, 'Jus Mangga', 10000, 1, 10000, NULL),
(59, 50, 7, 'Chicken Katsu', 12000, 1, 12000, '2'),
(60, 50, 40, 'Jus Mangga', 10000, 1, 10000, NULL),
(61, 51, 7, 'Chicken Katsu', 12000, 2, 24000, '5'),
(62, 52, 7, 'Chicken Katsu', 12000, 1, 12000, '5'),
(63, 53, 7, 'Chicken Katsu', 12000, 1, 12000, '5'),
(64, 53, 30, 'Pisang Keju Coklat', 12000, 1, 12000, NULL),
(65, 53, 40, 'Fresh Milk Mangga', 10000, 1, 10000, NULL),
(66, 53, 63, 'Milo ( HOT )', 5000, 1, 5000, NULL),
(67, 54, 7, 'Chicken Katsu', 12000, 1, 12000, '5'),
(68, 55, 7, 'Chicken Katsu', 12000, 1, 12000, '5'),
(69, 56, 7, 'Chicken Katsu', 12000, 1, 12000, '5'),
(70, 57, 7, 'Chicken Katsu', 12000, 1, 12000, '4'),
(71, 58, 8, 'Fire Wings', 13000, 1, 13000, '4'),
(72, 59, 7, 'Chicken Katsu', 12000, 1, 12000, '4'),
(73, 60, 7, 'Chicken Katsu', 12000, 1, 12000, '5'),
(74, 61, 7, 'Chicken Katsu', 12000, 1, 12000, '5'),
(75, 62, 7, 'Chicken Katsu', 12000, 1, 12000, '5'),
(76, 63, 8, 'Fire Wings', 13000, 1, 13000, '5'),
(77, 63, 9, 'Ceker Saus Korea', 16000, 1, 16000, NULL),
(78, 64, 7, 'Chicken Katsu', 12000, 1, 12000, '5'),
(79, 65, 7, 'Chicken Katsu', 12000, 1, 12000, '2'),
(80, 66, 7, 'Chicken Katsu', 12000, 1, 12000, '5'),
(81, 67, 7, 'Chicken Katsu', 12000, 1, 12000, '5');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `nama_menu` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `meja` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `level_pedas` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id`, `id_menu`, `nama_menu`, `harga`, `qty`, `meja`, `created_at`, `level_pedas`) VALUES
(94, 7, 'Chicken Katsu', 12000, 8, 0, '2026-03-09 09:58:08', NULL),
(109, 40, 'Jus Mangga', 10000, 1, 0, '2026-03-10 07:46:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) DEFAULT 0,
  `kategori` varchar(50) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ada_level` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `nama_menu`, `harga`, `stok`, `kategori`, `gambar`, `created_at`, `ada_level`) VALUES
(7, 'Chicken Katsu', 12000, 22, 'Makanan', '1773138148_1ae21ef378157d3b2f34.jpg', '2026-03-09 06:44:33', 1),
(8, 'Fire Wings', 13000, 28, 'Makanan', '1773138122_bb6b8e19d4a1bb94cd74.jpg', '2026-03-09 06:45:52', 1),
(9, 'Ceker Saus Korea', 16000, 29, 'Makanan', '1773138448_67dfe1b7a6054cbefb81.jpg', '2026-03-09 06:46:25', 0),
(10, 'Nasi Katsu', 17000, 30, 'Makanan', '1773138504_c52b02985901a8f52f0d.jpg', '2026-03-09 06:46:45', 1),
(11, 'Nasi Fire Wings', 18000, 30, 'Makanan', '1773138474_a990063b29b393dc89fa.jpg', '2026-03-09 06:47:04', 1),
(12, 'Nasi Ayam Lada Hitam', 20000, 30, 'Makanan', '1773138532_fdcf2ae2d32bb48110a9.jpg', '2026-03-09 06:47:33', 0),
(13, 'Nasi Sosis Bakar', 10000, 30, 'Makanan', '1773138566_458435f2666cc06101b7.jpg', '2026-03-09 06:48:01', 0),
(14, 'Nasi Gurih + Telor Dadar', 12000, 30, 'Makanan', '1773138787_c45d3c3f32a9788bea44.jpg', '2026-03-09 06:48:36', 0),
(16, 'Katsu + Kentang', 20000, 30, 'Makanan', '1773138798_eaa6f02e81e3d50566f9.jpg', '2026-03-09 06:52:29', 0),
(17, 'Nasi Ayam Spicy', 20000, 30, 'Makanan', '1773138814_732d75883d4385e81345.jpg', '2026-03-09 06:53:00', 0),
(18, 'Tahu Krispi', 6000, 20, 'Makanan', '1773138829_e99921bc22fe1ef98d1e.jpg', '2026-03-09 06:53:29', 0),
(19, 'Tahu Bojot', 7000, 20, 'Makanan', '1773138842_c360f7381284a8417ad7.jpg', '2026-03-09 06:53:46', 1),
(20, 'Tahu Saus BBQ', 8000, 20, 'Makanan', '1773138853_489c8f4fdb2d159294d6.jpg', '2026-03-09 06:54:16', 1),
(21, 'Jamur Krispi', 6000, 20, 'Makanan', '1773139262_4b4cffc5881b522ee164.jpg', '2026-03-09 06:54:33', 0),
(23, 'Kentang Goreng', 8000, 20, 'Makanan', '1773139273_6b1654bbf322a169109f.jpg', '2026-03-09 06:55:33', 0),
(24, 'Sosis Bakar', 5000, 20, 'Makanan', '1773139285_27d5b4f4ccc2b8974969.jpg', '2026-03-09 06:55:55', 0),
(25, 'Kentang + Sosis Bakar', 13000, 20, 'Makanan', '1773139298_9a9fefb33ff9f23dd435.jpg', '2026-03-09 06:56:20', 0),
(26, 'Kentang + Nugget + Sosis', 18000, 20, 'Makanan', '1773139309_8a9a23979a25bff253a3.jpg', '2026-03-09 06:57:02', 0),
(27, 'Otak - Otak', 6000, 20, 'Makanan', '1773139362_3987e0a55f3f242f549c.jpg', '2026-03-09 06:57:29', 0),
(28, 'Otak - Otak Bojot', 7000, 20, 'Makanan', '1773139375_667e86f2c5b89b2cbd24.jpg', '2026-03-09 06:57:49', 1),
(29, 'Cibay Pedas', 5000, 20, 'Makanan', '1773139387_c117c7b92e4f4794565e.jpg', '2026-03-09 06:58:02', 0),
(30, 'Pisang Keju Coklat', 12000, 19, 'Dessert', '1773139397_f4cf29bec0ab7e4b85a3.jpg', '2026-03-09 06:58:23', 0),
(31, 'Pisang Keju Susu', 12000, 20, 'Dessert', '1773141014_698d2105a853df76f3ce.jpg', '2026-03-09 06:58:39', 0),
(32, 'Roti Kukus Coklat', 12000, 20, 'Dessert', '1773141031_7a078ec25cf63149aebb.jpg', '2026-03-09 07:00:04', 0),
(33, 'Roti Kukus Keju', 12000, 20, 'Dessert', '1773141046_140d80d065f6ed52d463.jpg', '2026-03-09 07:00:22', 0),
(34, 'Roti Kukus Tiramisu', 12000, 20, 'Dessert', '1773141059_e118c1cab9bac36ca0b3.jpg', '2026-03-09 07:00:38', 0),
(35, 'Roti Bakar Coklat Keju', 14000, 20, 'Dessert', '1773141076_709636737227c16636a0.jpg', '2026-03-09 07:01:09', 0),
(36, 'Pisang Aroma ', 5000, 20, 'Dessert', '1773141089_2035907c8ebb1bb37394.jpg', '2026-03-09 07:01:32', 0),
(38, 'Pisang Goreng Keju', 12000, 20, 'Dessert', '1773141164_19ad3c6eb6536509cf59.jpg', '2026-03-09 07:02:07', 0),
(39, 'Pisang Goreng Coklat', 12000, 20, 'Dessert', '1773141182_772705f65a362bc715ab.jpg', '2026-03-09 07:02:34', 0),
(40, 'Fresh Milk Mangga', 10000, 14, 'Minuman', '1773141474_3860663bcb9a790a18d5.jpeg', '2026-03-09 10:57:55', 0),
(41, 'Fresh Milk Taro', 10000, 20, 'Minuman', '1773141485_7beb3ce0190d2624a3f4.jpeg', '2026-03-10 09:07:52', 0),
(42, 'Fresh Milk Bubble Gum', 10000, 20, 'Minuman', '1773141497_bc73ef511770747d6aa3.jpeg', '2026-03-10 09:08:15', 0),
(43, 'Fresh Milk Red Velvet', 10000, 20, 'Minuman', '1773141508_c80b590b342db18da1ec.jpeg', '2026-03-10 09:08:40', 0),
(44, 'Fresh Milk Leci', 10000, 20, 'Minuman', '1773141521_2ff9713e5da414871d4f.jpeg', '2026-03-10 09:08:59', 0),
(45, 'Fresh Milk Matcha Coffe', 10000, 20, 'Minuman', '1773141742_b355837bfd8fde80c2fe.jpg', '2026-03-10 09:09:25', 0),
(46, 'Fresh Milk Matcha Choco', 10000, 20, 'Minuman', '1773141535_a2ea96572216825cdb12.jpeg', '2026-03-10 09:09:47', 0),
(47, 'Fresh Milk Yakult Milk Lemon', 12000, 20, 'Minuman', '1773141552_67ecbcadf97fb5a97e37.jpeg', '2026-03-10 09:10:15', 0),
(48, 'Happy Soda', 10000, 20, 'Minuman', '1773142206_6bebed0ee11b339d5880.jpg', '2026-03-10 09:10:39', 0),
(49, 'Mojito', 10000, 20, 'Minuman', '1773142217_84138b8b56e0fb6112f2.jpg', '2026-03-10 09:10:56', 0),
(50, 'Fanta Susu', 10000, 20, 'Minuman', '1773142229_9aad26f6686a5bf32807.jpg', '2026-03-10 09:11:21', 0),
(51, 'Coca Cola Lemon', 10000, 20, 'Minuman', '1773142497_1f4b4c0f6b7ef9f56a4c.jpeg', '2026-03-10 09:11:42', 0),
(52, 'Sprite Susu', 10000, 20, 'Minuman', '1773142522_237c69c15923dea92261.jpeg', '2026-03-10 09:12:05', 0),
(53, 'Teh Poci', 5000, 0, 'Minuman', '1773141867_bf8cef842962361a3c23.jpeg', '2026-03-10 09:12:53', 0),
(54, 'Teh Poci Susu', 8000, 0, 'Minuman', '1773142012_4c2e3c39f98013d7fc92.jpg', '2026-03-10 09:13:10', 0),
(55, 'Lemon Tea', 10000, 0, 'Minuman', '1773141879_43c6dd15d7c10470d42e.jpeg', '2026-03-10 09:13:32', 0),
(56, 'Green Tea', 10000, 20, 'Minuman', '1773141893_443e3524e3babcef3143.jpeg', '2026-03-10 09:13:50', 0),
(57, 'Max Tea Tarik ( ICE )', 10000, 10, 'Minuman', '1773141967_0784289e8ba6af986458.jpg', '2026-03-10 09:14:48', 0),
(58, 'Max Tea Tarik ( HOT )', 5000, 10, 'Minuman', '1773141981_6cba69207d14be831d10.jpg', '2026-03-10 09:15:12', 0),
(59, 'Choco Magnum', 10000, 20, 'Minuman', '1773142840_ca4e4b8648e5cf61e62f.png', '2026-03-10 09:15:42', 0),
(60, 'Choco Delfi ( ICE )', 10000, 10, 'Minuman', '1773142956_b933755c0c0a06ea0822.jpeg', '2026-03-10 09:16:22', 0),
(61, 'Choco Delfi ( HOT )', 5000, 10, 'Minuman', '1773142971_9317e98c1c5aa70a0204.jpeg', '2026-03-10 09:16:40', 0),
(62, 'Milo ( ICE )', 10000, 10, 'Minuman', '1773142987_396bbee42e72b8abb854.jpeg', '2026-03-10 09:17:12', 0),
(63, 'Milo ( HOT )', 5000, 9, 'Minuman', '1773142999_c052d95769b84bb7174a.jpeg', '2026-03-10 09:17:29', 0),
(64, 'Capucino ', 10000, 20, 'Minuman', '1773143012_f357f9bd69283ebdac9c.jpeg', '2026-03-10 09:19:19', 0),
(65, 'Toracino', 10000, 20, 'Minuman', '1773143024_ae3fdb9a06175b7c3104.jpeg', '2026-03-10 09:19:19', 0),
(66, 'Kopi Gula Aren ', 12000, 20, 'Minuman', '1773143161_97db78ae0095092c564f.jpg', '2026-03-10 09:22:26', 0),
(67, 'Kopi Lemon', 12000, 20, 'Minuman', '1773143175_3afd6cb544dcfbc8d997.jpg', '2026-03-10 09:24:46', 0),
(68, 'Kopi Hitam Panas', 5000, 10, 'Minuman', '1773143190_9f5f345d9043627933df.jpg', '2026-03-10 09:25:33', 0),
(69, 'Le Mineral', 5000, 10, 'Minuman', '1773143207_9cf222bef6d41d4efb8b.jpg', '2026-03-10 09:25:53', 0),
(70, 'Teh Manis Panas', 5000, 10, 'Minuman', '1773143222_d39987e8364bccd5d1ab.jpg', '2026-03-10 09:26:16', 0),
(71, 'Teh Tawar Panas', 3000, 10, 'Minuman', '1773143235_c8cc0051e3310ecf19d7.jpg', '2026-03-10 09:26:33', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `meja` int(11) DEFAULT NULL,
  `tipe_pembayaran` varchar(20) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `metode_pembayaran` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `meja`, `tipe_pembayaran`, `total`, `metode_pembayaran`, `created_at`, `status`) VALUES
(36, 1, NULL, 12000, 'cash', '2026-03-03 13:44:54', 'lunas'),
(37, 1, NULL, 12000, 'qris', '2026-03-03 13:56:39', 'lunas'),
(38, 1, NULL, 12000, 'cash', '2026-03-03 15:37:48', 'lunas'),
(39, 1, NULL, 12000, 'qris', '2026-03-04 17:04:28', 'lunas'),
(40, 1, NULL, 12000, 'cash', '2026-03-04 17:13:53', 'lunas'),
(41, 1, NULL, 12, 'cash', '2026-03-08 23:43:04', 'lunas'),
(42, 1, NULL, 12000, 'cash', '2026-03-09 16:59:20', 'lunas'),
(43, 1, NULL, 12000, 'cash', '2026-03-09 17:47:41', 'lunas'),
(44, 1, NULL, 12000, 'cash', '2026-03-09 17:52:42', 'lunas'),
(45, 1, NULL, 22000, 'cash', '2026-03-09 18:59:21', 'lunas'),
(46, 1, NULL, 32000, 'cash', '2026-03-09 19:21:11', 'lunas'),
(47, 1, NULL, 30000, 'cash', '2026-03-09 19:38:23', 'lunas'),
(48, 1, NULL, 34000, 'cash', '2026-03-09 19:53:44', 'lunas'),
(49, 1, NULL, 22000, 'qris', '2026-03-09 19:54:43', 'lunas'),
(50, 1, NULL, 22000, 'cash', '2026-03-10 14:47:42', 'lunas'),
(51, 1, NULL, 24000, 'cash', '2026-03-10 16:41:45', 'lunas'),
(52, 1, NULL, 12000, 'qris', '2026-03-10 17:05:18', 'lunas'),
(53, 1, NULL, 39000, 'cash', '2026-03-10 18:55:18', 'lunas'),
(54, 1, NULL, 12000, 'cash', '2026-03-10 18:56:37', 'lunas'),
(55, 1, NULL, 12000, 'qris', '2026-03-10 19:07:33', 'lunas'),
(56, 1, NULL, 12000, 'qris', '2026-03-10 19:09:02', 'lunas'),
(57, 1, NULL, 12000, 'qris', '2026-03-12 23:15:59', 'lunas'),
(58, 1, NULL, 13000, 'cash', '2026-03-12 23:16:37', 'lunas'),
(59, 1, NULL, 12000, 'qris', '2026-03-12 23:36:44', 'lunas'),
(60, 1, NULL, 12000, 'cash', '2026-03-12 23:47:30', 'lunas'),
(61, 1, NULL, 12000, 'qris', '2026-03-13 21:56:53', 'lunas'),
(62, 1, NULL, 12000, 'qris', '2026-03-13 21:57:23', 'lunas'),
(63, 1, NULL, 29000, 'qris', '2026-03-13 22:38:05', 'lunas'),
(64, 1, NULL, 12000, 'cash', '2026-03-13 22:50:41', 'lunas'),
(65, 1, 'meja', 12000, 'qris', '2026-03-13 22:57:19', 'lunas'),
(66, 1, 'kasir', 12000, 'cash', '2026-03-13 23:04:41', 'lunas'),
(67, 1, 'kasir', 12000, 'cash', '2026-03-13 23:05:54', 'lunas');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `nama` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`, `nama`, `bio`) VALUES
(1, 'Fauzanfr123', 'Fauzanfr123', 'admin', '2026-03-03 01:22:31', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_transaksi` (`id_transaksi`),
  ADD KEY `fk_menu` (`id_menu`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_keranjang_menu` (`id_menu`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id`),
  ADD CONSTRAINT `fk_menu` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `fk_keranjang_menu` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
