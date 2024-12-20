-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 14, 2024 at 04:03 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_webmohinh`
--
CREATE DATABASE IF NOT EXISTS `db_webmohinh` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_webmohinh`;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE IF NOT EXISTS `tbl_categories` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`id_category`, `name`) VALUES
(28, 'Fairy Tail'),
(29, 'Pokemon'),
(37, 'One Piece');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE IF NOT EXISTS `tbl_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_address` text,
  `customer_phone` varchar(15) DEFAULT NULL,
  `notes` text,
  `total_price` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_details`
--

CREATE TABLE IF NOT EXISTS `tbl_order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `fk_product_orddetail` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `tbl_order_details`
--

INSERT INTO `tbl_order_details` (`id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`, `total`) VALUES
(11, 13, 35, 'luffy2', 1, '250000.00', '250000.00'),
(12, 15, 34, 'luffy1', 1, '250000.00', '250000.00'),
(13, 16, 34, 'luffy1', 2, '250000.00', '500000.00'),
(14, 17, 34, 'luffy1', 3, '250000.00', '750000.00'),
(15, 18, 34, 'luffy1', 2, '250000.00', '500000.00'),
(16, 18, 35, 'luffy2', 2, '250000.00', '500000.00'),
(17, 20, 34, 'luffy1', 3, '250000.00', '750000.00'),
(18, 20, 35, 'luffy2', 1, '250000.00', '250000.00'),
(19, 21, 35, 'luffy2', 1, '250000.00', '250000.00'),
(20, 21, 34, 'luffy1', 1, '250000.00', '250000.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payments`
--

CREATE TABLE IF NOT EXISTS `tbl_payments` (
  `id_payment` int(11) NOT NULL AUTO_INCREMENT,
  `id_order` int(11) NOT NULL,
  `payment_method` enum('Momo','Paypal','VNPay') NOT NULL,
  `id_user` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date_payment` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_payment`),
  KEY `fk_ord` (`id_order`),
  KEY `fk_user_pay` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE IF NOT EXISTS `tbl_products` (
  `id_product` int(11) NOT NULL AUTO_INCREMENT,
  `namepro` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `image` varchar(50) NOT NULL,
  PRIMARY KEY (`id_product`),
  KEY `id_category` (`id_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`id_product`, `namepro`, `description`, `price`, `stock`, `id_category`, `image`) VALUES
(34, 'luffy1', 'Monkey D. Luffy (/?lu?fi/ LOO-fee) (Nh?t: ?????D???? Hepburn: Monk? D? Rufi?, [???i?]), cï¿½n g?i lï¿½ Luffy ', '0.00', 40, 37, 'Luffy.jpeg'),
(35, 'luffy2', 'Monkey D. Luffy (/?lu?fi/ LOO-fee) (Nh?t: ?????D???? Hepburn: Monk? D? Rufi?, [???i?]), cï¿½n g?i lï¿½ Luffy ', '250000.00', 40, 37, 'luffy2.jpeg'),
(40, 'Natsu', 'Natsu Dragneel (????????, Natsu Doraguniru), lï¿½ m?t Phï¿½p S? c?a H?i Fairy Tail vï¿½ lï¿½ thï¿½nh viï¿½n c?a ??i Natsu. Ban ??u, anh ?ï¿½ qua ??i cï¿½ch ?ï¿½y 400 n?m do m?t con R?ng t?n cï¿½ng, nh?ng Natsu ?ï¿½ ???c anh trai c?a mï¿½nh h?i sinh trong thï¿½n ph?n ï¿½c Qu? m?nh nh?t trong s? nh?ng con Qu? c?a Zeref cï¿½ tï¿½n lï¿½ Etherious Natsu Dragneel, g?i t?t lï¿½ E.N.D. (???, ???????, ? Enu D?). Anh c?ng lï¿½ m?t trong n?m Sï¿½t Long Nhï¿½n ???c g?i ??n t??ng lai 400 n?m sau b?ng C?ng Nh?t Th?c qua s? tr? giï¿½p c?a Anna Heartfilia nh?m m?c ?ï¿½ch ?ï¿½nh b?i Acnologia.', '350000.00', 30, 28, 'vn-11134211-7r98o-lziypxz07esh41.jpg'),
(43, 'Pokemon', 'Pocket Monsters vi?t t?t lï¿½ Pokï¿½mon, hay cï¿½n ???c bi?t ??n nh? lï¿½ Pokï¿½mon the Series v?i khï¿½n gi? ph??ng Tï¿½y t? n?m 2013, lï¿½ lo?t anime truy?n hï¿½nh d?a trï¿½n lo?t trï¿½ ch?i ?i?n t? Pokï¿½mon.', '450000.00', 20, 29, 'mo-hinh-prime-figure-mini-mew-funism-pf2056_1.webp');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id_user`, `name`, `email`, `password`, `role`) VALUES
(3, 'vy', 'vy@gmail.com', '123', 'user'),
(4, 'Trí Qu?nh', 'ds@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'admin'),
(5, 'vy', 'ab@gmail.com', '$2y$10$uwODzEUQ2D8FNrwZGGQ3jeKj1VSAJ1SlCinOpc.Gsqy19pyYHv4jG', 'user');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
