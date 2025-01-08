-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2025 at 05:46 AM
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
-- Database: `fineart`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` enum('draft','published','archived') DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `image_url`, `created_at`, `status`) VALUES
(3, 'บทความวิชาการ Archives - ศูนย์ส่งเสริมและพัฒนาการเรียนรู้ทาง1', '1บทความวิชาการ · ทำไมจึงต้องใช้เพชรมาตัดเพชร · superadmin · Rhizopus เชื้อราขนมปัง · superadmin · ภัยอันตราย หากผึ้งเผชิญกับการสูญพันธุ์ · superadmin · เจาะลึกใต้ผิวหนัง ส่องดูส่วนประกอบ', 'uploads/lxmycbbfiyXbFuHk4Xq-o.jpg', '2025-01-08 10:24:07', 'draft'),
(4, '2การเขียนบทความวิชาการและ การเขียนบทความการวิจัย', '2ลักษณะของบทความที่มีคุณภาพ. 1. ถูกต้องตามเกณฑ์มาตรฐานทางวิชาการ. 2. ได้รับการยอมรับเผยแพร่ น าเสนอ หรือตีพิมพ์.', 'uploads/lxmydlr7iVBs7VQ6dmW-o.jpg', '2025-01-08 10:37:17', 'published'),
(5, 'ขั้นตอนการเขียนบทความวิชาการ', '1. คิดเรื่องหรือประเด็นที่สนใจ แล้วไปสืบค้นจากเว็ปไซค์ห้องสมุดของมหาวิทยาลัยรวบรวมแหล่งสืบค้นทางวิชาการได้ดีที่สุดหรือพร้อมครบครันที่สุด ว่ามีบทความในประเด็นนี้บ้างไหม ถ้ามีแล้วเขาเขียนประเด็นอย่างไร', 'uploads/677dfdedac969lxmyeqsjiDMu50iPMus-o.jpg', '2025-01-08 11:24:13', 'published');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
