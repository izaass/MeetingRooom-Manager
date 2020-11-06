-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2020 at 11:21 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qlph`
--

-- --------------------------------------------------------

--
-- Table structure for table `phong_hop`
--

CREATE TABLE `phong_hop` (
  `id` int(11) NOT NULL,
  `ten_phong` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mo_ta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trang_thai` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nguoi_tao` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `phong_hop`
--

INSERT INTO `phong_hop` (`id`, `ten_phong`, `mo_ta`, `trang_thai`, `nguoi_tao`) VALUES
(1, 'M1A', 'M1A ở tầng 1', 'active', '7980'),
(2, 'M1B', 'Phòng M1B ở tầng 1', 'active', '7980'),
(3, 'M2A', 'Phòng M2A ở tầng 2', 'active', '7980'),
(4, 'M2B', 'Phòng M2B ở tầng 2', 'active', '7980'),
(5, 'Không hoạt động', 'Không hoạt động', 'disable', '7980');

-- --------------------------------------------------------

--
-- Table structure for table `su_kien`
--

CREATE TABLE `su_kien` (
  `id` int(11) NOT NULL,
  `noi_dung` text COLLATE utf8_unicode_ci,
  `ten_phong` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `start_time` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `end_time` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `trang_thai` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ma_nhan_vien` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ten_thuong_goi` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ngay_them` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `su_kien`
--

INSERT INTO `su_kien` (`id`, `noi_dung`, `ten_phong`, `start_date`, `start_time`, `end_time`, `trang_thai`, `ma_nhan_vien`, `ten_thuong_goi`, `ngay_them`) VALUES
(1, 'Hùng Cute', 'M2B', '2020-07-23', '01:00', '23:00', '0', '7980', 'Hùng IT', '2020-07-23-01:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `phong_hop`
--
ALTER TABLE `phong_hop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `su_kien`
--
ALTER TABLE `su_kien`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `phong_hop`
--
ALTER TABLE `phong_hop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `su_kien`
--
ALTER TABLE `su_kien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
