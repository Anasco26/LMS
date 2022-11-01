-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2022 at 02:14 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_user` varchar(25) NOT NULL,
  `admin_pass` varchar(50) NOT NULL,
  `admin_nama` varchar(30) NOT NULL,
  `admin_alamat` varchar(250) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_telepon` varchar(15) NOT NULL,
  `admin_ip` varchar(12) NOT NULL,
  `admin_online` int(10) NOT NULL,
  `admin_level_kode` int(3) NOT NULL,
  `admin_status` varchar(100) NOT NULL,
  `admin_created` datetime NOT NULL DEFAULT current_timestamp(),
  `admin_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_user`, `admin_pass`, `admin_nama`, `admin_alamat`, `admin_email`, `admin_telepon`, `admin_ip`, `admin_online`, `admin_level_kode`, `admin_status`, `admin_created`, `admin_updated`) VALUES
('admin', '0192023a7bbd73250516f069df18b500', 'John Doe', 'Here St. Over There, Anywhere, 2306', 'admin@mail.com', '9564897544', '', 0, 1, 'A', '2019-02-01 22:19:14', '2022-06-30 11:41:37'),
('staff1', 'ab4c31c66f9fe6485aefd34c3c9c88a1', 'Staff 101', 'Sample Address', '', '4569872', '', 0, 2, 'A', '2022-06-13 09:34:04', '2022-06-30 11:41:59'),
('staff2', '2bf4351232ec393d2a436d73dcb69dcf', 'Staff 102', 'Sample Address', '', '7864321', '', 0, 3, 'A', '2022-06-13 09:34:26', '2022-06-30 11:42:35');

-- --------------------------------------------------------

--
-- Table structure for table `admin_level`
--

CREATE TABLE `admin_level` (
  `admin_level_kode` int(3) NOT NULL,
  `admin_level_nama` varchar(30) NOT NULL,
  `admin_level_status` char(1) NOT NULL,
  `admin_level_created` datetime NOT NULL DEFAULT current_timestamp(),
  `admin_level_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_level`
--

INSERT INTO `admin_level` (`admin_level_kode`, `admin_level_nama`, `admin_level_status`, `admin_level_created`, `admin_level_updated`) VALUES
(1, 'Administrator', 'A', '2018-07-26 22:31:41', '2018-07-26 22:31:41'),
(2, 'Staff Supplier', 'A', '2018-07-26 22:31:41', '2018-08-17 16:45:27'),
(3, 'Staff Customer', 'A', '2018-08-17 16:45:45', '2018-08-17 16:45:45');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(11) NOT NULL,
  `nama_customer` varchar(100) NOT NULL,
  `alamat_customer` varchar(100) NOT NULL,
  `notelp_customer` varchar(12) NOT NULL,
  `customer_created` datetime NOT NULL DEFAULT current_timestamp(),
  `customer_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id_customer`, `nama_customer`, `alamat_customer`, `notelp_customer`, `customer_created`, `customer_updated`) VALUES
(11, 'Faith Amos', 'Okene', '09034562346', '2022-10-17 00:17:00', '2022-10-17 00:17:00');

-- --------------------------------------------------------

--
-- Table structure for table `damaged_barang`
--

CREATE TABLE `damaged_barang` (
  `id_damaged` int(11) NOT NULL,
  `jumlah` int(50) DEFAULT NULL,
  `tanggal_damaged` timestamp NULL DEFAULT current_timestamp(),
  `damaged_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status_pergerakan` char(1) NOT NULL COMMENT 'dead = 1 sick = 2',
  `reason` varchar(255) NOT NULL,
  `returned` int(50) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `comment_returned` varchar(255) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `admin_user` varchar(119) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `damaged_barang`
--

INSERT INTO `damaged_barang` (`id_damaged`, `jumlah`, `tanggal_damaged`, `damaged_updated`, `status_pergerakan`, `reason`, `returned`, `comment`, `comment_returned`, `id_barang`, `admin_user`) VALUES
(2, 2, '2022-10-29 20:53:41', '2022-10-29 21:53:41', '1', 'Foot and Mouth Disease ', 0, 'Vaccinate others', '', 21, 'admin'),
(5, 6, '2022-10-29 21:08:36', '2022-10-29 22:08:36', '1', '1', 0, 'Test', '', 21, 'admin'),
(9, 2, '2022-10-29 22:22:22', '2022-10-31 18:15:04', '2', 'Sick', 2, 'To observe the condition', 'Ok', 21, 'admin'),
(8, 5, '2022-10-29 21:14:48', '2022-10-29 22:14:48', '1', 'jn', 0, 'n.k', '', 21, 'admin'),
(10, 1, '2022-10-31 16:59:20', '2022-10-31 18:01:52', '2', 'Sick', 2, 'Actions should be taken', '', 20, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `feeding_barang`
--

CREATE TABLE `feeding_barang` (
  `id_feeding` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `feeding_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `feeding_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_barang` int(11) NOT NULL,
  `admin_user` varchar(119) NOT NULL,
  `id_feeds` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feeding_barang`
--

INSERT INTO `feeding_barang` (`id_feeding`, `jumlah`, `feeding_created`, `feeding_updated`, `id_barang`, `admin_user`, `id_feeds`) VALUES
(1, 6, '2022-11-01 00:03:43', '2022-11-01 01:03:43', 21, 'admin', 2);

-- --------------------------------------------------------

--
-- Table structure for table `feeds`
--

CREATE TABLE `feeds` (
  `id_feeds` int(11) NOT NULL,
  `nama_feeds` varchar(110) NOT NULL,
  `jumlah` int(50) NOT NULL,
  `feeds_created` datetime DEFAULT current_timestamp(),
  `feeds_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_barang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feeds`
--

INSERT INTO `feeds` (`id_feeds`, `nama_feeds`, `jumlah`, `feeds_created`, `feeds_updated`, `id_barang`) VALUES
(2, 'Mesh', 15, '2022-10-31 22:57:13', '2022-11-01 01:03:43', 21),
(3, 'Hay', 21, '2022-11-01 02:03:36', '2022-11-01 02:03:36', 21);

-- --------------------------------------------------------

--
-- Table structure for table `identitas`
--

CREATE TABLE `identitas` (
  `identitas_id` int(3) NOT NULL,
  `identitas_website` varchar(250) NOT NULL,
  `identitas_deskripsi` text NOT NULL,
  `identitas_keyword` text NOT NULL,
  `identitas_alamat` varchar(250) NOT NULL,
  `identitas_notelp` char(20) NOT NULL,
  `identitas_fb` varchar(100) NOT NULL,
  `identitas_email` varchar(100) NOT NULL,
  `identitas_tw` varchar(100) NOT NULL,
  `identitas_gp` varchar(100) NOT NULL,
  `identitas_yb` varchar(100) NOT NULL,
  `identitas_favicon` varchar(250) NOT NULL,
  `identitas_author` varchar(100) NOT NULL,
  `identitas_created` datetime NOT NULL DEFAULT current_timestamp(),
  `identitas_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `identitas`
--

INSERT INTO `identitas` (`identitas_id`, `identitas_website`, `identitas_deskripsi`, `identitas_keyword`, `identitas_alamat`, `identitas_notelp`, `identitas_fb`, `identitas_email`, `identitas_tw`, `identitas_gp`, `identitas_yb`, `identitas_favicon`, `identitas_author`, `identitas_created`, `identitas_updated`) VALUES
(1, 'WMS', 'Warehouse Management System', 'Warehouse Management System ', '569 Eren Avenue', '08123456789', 'https://www.facebook.com/wms', 'info@admin.com', 'https://twitter.com/wms', 'http://wms.com/', 'https://www.youtube.com/', 'd5bf7e44b3331b3d4b0c0177e3d51f31.png', 'CI PHP - Project', '2019-02-13 22:19:42', '2022-06-30 10:57:16');

-- --------------------------------------------------------

--
-- Table structure for table `limitfeed`
--

CREATE TABLE `limitfeed` (
  `limitfeed_id` int(11) NOT NULL,
  `feeds` int(11) NOT NULL,
  `limitfeed_created` datetime DEFAULT current_timestamp(),
  `limitfeed_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `limitfeed`
--

INSERT INTO `limitfeed` (`limitfeed_id`, `feeds`, `limitfeed_created`, `limitfeed_updated`) VALUES
(1, 10, '2022-11-01 01:41:01', '2022-11-01 01:41:01');

-- --------------------------------------------------------

--
-- Table structure for table `limitstock`
--

CREATE TABLE `limitstock` (
  `limitstock_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `limitstock_created` datetime DEFAULT current_timestamp(),
  `limitstock_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `limitstock`
--

INSERT INTO `limitstock` (`limitstock_id`, `stock`, `limitstock_created`, `limitstock_updated`) VALUES
(1, 50, '2019-02-14 23:33:38', '2022-11-01 02:06:35');

-- --------------------------------------------------------

--
-- Table structure for table `master_barang`
--

CREATE TABLE `master_barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `merek` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `temperature` int(255) NOT NULL,
  `feeds` varchar(255) NOT NULL,
  `barang_created` datetime NOT NULL DEFAULT current_timestamp(),
  `barang_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_barang`
--

INSERT INTO `master_barang` (`id_barang`, `nama_barang`, `merek`, `stock`, `temperature`, `feeds`, `barang_created`, `barang_updated`) VALUES
(20, 'Layers', 'Bird', 47, 20, '', '2022-10-17 00:19:07', '2022-10-31 21:25:50'),
(21, 'Cattle', 'Pen', 47, 29, '', '2022-10-17 00:19:34', '2022-10-31 21:26:28');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('262ed206690c8ffa8c0880853ab67ce2', '0.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36', 1504186814, ''),
('49e9e36170db732c7314cb317b3c899e', '0.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36', 1504187151, ''),
('4b6baa8cbc478d7e38395c0d7a3fc212', '0.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36', 1504186981, 'a:5:{s:9:\"user_data\";s:0:\"\";s:10:\"admin_nama\";s:13:\"Administrator\";s:10:\"admin_user\";s:5:\"admin\";s:11:\"admin_level\";s:1:\"1\";s:9:\"logged_in\";b:1;}'),
('648fe333a5f0d3d2515f2a2711e1751c', '0.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 1532611686, ''),
('8f90fd01811f1c4f981059b36f932233', '0.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36', 1504186981, ''),
('9f4279bb252307cbf1d9f5d87bf88a9c', '0.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36', 1504186691, ''),
('aa0a60fa0dba1e30487cce20443ba358', '0.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 1532679275, ''),
('aa8fa7618237d5f7cb131b5777a1e564', '0.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36', 1504187079, ''),
('e3deff5ffd5e90e5ba3deef2c0681ff4', '0.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36', 1504187005, 'a:2:{s:9:\"user_data\";s:0:\"\";s:10:\"admin_nama\";s:13:\"Administrator\";}'),
('f622232dd0c9c866affa9648415588ab', '0.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36', 1504187039, '');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(100) NOT NULL,
  `alamat_supplier` varchar(100) NOT NULL,
  `notelp_supplier` varchar(12) NOT NULL,
  `supplier_created` datetime NOT NULL DEFAULT current_timestamp(),
  `supplier_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat_supplier`, `notelp_supplier`, `supplier_created`, `supplier_updated`) VALUES
(1, 'Ishaq Umar', 'Adavi Eba, Kogi State', '090876556666', '2022-06-30 11:20:07', '2022-06-30 11:20:07'),
(9, 'Audu Ali', 'Kebbi', '081367897645', '2022-10-17 00:15:43', '2022-10-17 00:15:43');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_barang`
--

CREATE TABLE `transaksi_barang` (
  `id_transaksi` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `tanggal_transaksi` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `transaksi_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status_pergerakan` char(1) NOT NULL COMMENT 'pergerakan barang masuk = 1 atau keluar = 2',
  `id_barang` int(11) NOT NULL,
  `admin_user` varchar(119) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi_barang`
--

INSERT INTO `transaksi_barang` (`id_transaksi`, `jumlah`, `tanggal_transaksi`, `transaksi_updated`, `status_pergerakan`, `id_barang`, `admin_user`, `id_supplier`, `id_customer`) VALUES
(47, 50, '2022-10-16 23:23:48', '2022-10-17 00:23:48', '1', 20, 'admin', 9, 0),
(48, 78, '2022-10-16 23:24:34', '2022-10-17 00:24:34', '1', 21, 'admin', 9, 0),
(49, 5, '2022-10-16 23:26:17', '2022-10-17 00:26:17', '2', 20, 'admin', 0, 11),
(50, 2, '2022-10-29 20:54:38', '2022-10-29 21:54:38', '2', 21, 'admin', 0, 11),
(51, 2, '2022-10-29 21:32:23', '2022-10-29 22:32:23', '2', 20, 'admin', 0, 11),
(52, 10, '2022-10-31 20:25:50', '2022-10-31 21:25:50', '1', 20, 'admin', 9, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_user`),
  ADD KEY `admin_level_kode` (`admin_level_kode`);

--
-- Indexes for table `admin_level`
--
ALTER TABLE `admin_level`
  ADD PRIMARY KEY (`admin_level_kode`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indexes for table `damaged_barang`
--
ALTER TABLE `damaged_barang`
  ADD PRIMARY KEY (`id_damaged`);

--
-- Indexes for table `feeding_barang`
--
ALTER TABLE `feeding_barang`
  ADD PRIMARY KEY (`id_feeding`);

--
-- Indexes for table `feeds`
--
ALTER TABLE `feeds`
  ADD PRIMARY KEY (`id_feeds`);

--
-- Indexes for table `identitas`
--
ALTER TABLE `identitas`
  ADD PRIMARY KEY (`identitas_id`);

--
-- Indexes for table `limitfeed`
--
ALTER TABLE `limitfeed`
  ADD PRIMARY KEY (`limitfeed_id`);

--
-- Indexes for table `limitstock`
--
ALTER TABLE `limitstock`
  ADD PRIMARY KEY (`limitstock_id`);

--
-- Indexes for table `master_barang`
--
ALTER TABLE `master_barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `transaksi_barang`
--
ALTER TABLE `transaksi_barang`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `Tgl_transaksi` (`tanggal_transaksi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_level`
--
ALTER TABLE `admin_level`
  MODIFY `admin_level_kode` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `damaged_barang`
--
ALTER TABLE `damaged_barang`
  MODIFY `id_damaged` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `feeding_barang`
--
ALTER TABLE `feeding_barang`
  MODIFY `id_feeding` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feeds`
--
ALTER TABLE `feeds`
  MODIFY `id_feeds` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `identitas`
--
ALTER TABLE `identitas`
  MODIFY `identitas_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `limitfeed`
--
ALTER TABLE `limitfeed`
  MODIFY `limitfeed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `limitstock`
--
ALTER TABLE `limitstock`
  MODIFY `limitstock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `master_barang`
--
ALTER TABLE `master_barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transaksi_barang`
--
ALTER TABLE `transaksi_barang`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
