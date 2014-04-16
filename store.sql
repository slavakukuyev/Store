-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2014 at 10:45 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `store`
--
CREATE DATABASE IF NOT EXISTS `store` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `store`;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `cityid` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `phone1` varchar(50) DEFAULT NULL,
  `phone2` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `street` (`street`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `userid`, `cityid`, `street`, `phone1`, `phone2`) VALUES
(3, 68, 3, 'rrrrrrrrrrrrsd 565656 67 ', '0345678345', '546345654656'),
(8, 6, 1, 'dgfhjfjdfghjdghj', '678567856785678', '567856785678'),
(12, 70, 1, 'dgfhdfghdfgh', '574567456745', '546745674567');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'All-in-One'),
(2, 'PC'),
(3, 'Notebook'),
(4, 'Tablet');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(70) NOT NULL DEFAULT 'Tel Aviv',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`) VALUES
(1, 'Tel Aviv'),
(2, 'Bat Yam'),
(3, 'Ramat Gan'),
(4, 'Petah Tikva'),
(5, 'Herzliya'),
(6, 'Holon');

-- --------------------------------------------------------

--
-- Table structure for table `deposit`
--

CREATE TABLE IF NOT EXISTS `deposit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `deposited` datetime NOT NULL,
  `creditcard` varchar(19) NOT NULL,
  `cvv` varchar(4) NOT NULL,
  `amount` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `deposit`
--

INSERT INTO `deposit` (`id`, `userid`, `deposited`, `creditcard`, `cvv`, `amount`) VALUES
(17, 68, '2014-01-15 14:14:27', '4111111111111111', '111', 4000),
(18, 68, '2014-01-15 14:14:33', '4111111111111111', '111', 4000),
(19, 68, '2014-01-15 14:17:18', '4111111111111111', '111', 12000),
(20, 4, '2014-01-02 00:00:00', '235636245347', '123', 20000),
(21, 4, '2014-01-03 00:00:00', '7865773453745', '234', 20000),
(22, 70, '2014-01-29 15:18:34', '4111111111111111', '111', 5000),
(23, 70, '2014-01-29 15:18:39', '4111111111111111', '111', 5000),
(24, 70, '2014-01-29 15:20:23', '4111111111111111', '111', 5000),
(25, 70, '2014-01-29 15:20:26', '4111111111111111', '111', 5000),
(26, 70, '2014-01-29 15:30:19', '4111111111111111', '111', 5000),
(27, 70, '2014-01-29 15:30:23', '4111111111111111', '111', 5000),
(28, 70, '2014-01-29 15:31:28', '4111111111111111', '111', 5000),
(29, 70, '2014-01-29 15:31:31', '4111111111111111', '111', 5000),
(30, 70, '2014-01-29 15:33:30', '4111111111111111', '111', 5000),
(31, 70, '2014-01-29 15:33:33', '4111111111111111', '111', 5000),
(32, 70, '2014-01-29 15:57:43', '4111111111111111', '111', 5000),
(33, 70, '2014-01-29 15:58:48', '4111111111111111', '111', 1111),
(34, 70, '2014-01-29 16:10:01', '4111111111111111', '111', 513),
(35, 70, '2014-01-29 17:00:44', '4111111111111111', '111', 1111),
(36, 70, '2014-01-29 17:02:04', '4111111111111111', '111', 2222),
(37, 68, '2014-02-09 13:30:25', '4111111111111111', '111', 777);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL,
  `price` text NOT NULL,
  `count` text NOT NULL,
  `userid` int(11) NOT NULL,
  `ordered` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `productid`, `price`, `count`, `userid`, `ordered`, `status`) VALUES
(8, 3, '3935', '1', 68, '2014-01-15 14:16:14', 1),
(9, 2, '11670', '3', 68, '2014-01-15 14:17:48', 1),
(10, 3, '1234', '1', 51, '2014-01-15 14:18:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderstatus`
--

CREATE TABLE IF NOT EXISTS `orderstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `orderstatus`
--

INSERT INTO `orderstatus` (`id`, `status`) VALUES
(1, 'ordered'),
(2, 'on the way'),
(3, 'delivered');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` text NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `price` text NOT NULL,
  `price_opt` int(11) DEFAULT NULL,
  `image` text NOT NULL,
  `categoryid` text NOT NULL,
  `instock` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `brand`, `title`, `description`, `price`, `price_opt`, `image`, `categoryid`, `instock`) VALUES
(1, 'Samsung\n', 'Samsung ATIV One 5 DP500A2D-K04IL - White', 'Brand:  Samsung‏,  Size:  21.5''''‏,  CPU:  Intel Core i3‏,  Capacity:  1TB‏,  GPU:  Intel‏,  Memory Size:  4GB‏,  Resolution:  1920x1080‏,  Optical Drive:  DVD-RW (Dual Layer)‏,  Connection Ports:  HDMI‏, USB 2.0‏, USB 3.0‏,  Operating System:  Windows 8‏,  Language:  Hebrew‏, English‏, Russian‏,  Features:  Touch Screen‏, Bluetooth‏, Expansion Card‏, Front Camera‏,  Warranty:  3 Years‏, ', '3790', 3200, 'http://img.ksp.co.il/allimg/lrg20619.jpg', '1', '5'),
(2, 'Fujitsu', 'Fujitsu All-in-One X913-0P0001IL', ' Brand:  Fujitsu‏,  Size:  23''''‏,  CPU:  Intel Core i5‏,  Capacity:  750GB‏,  GPU:  Intel‏,  Memory Size:  4GB‏,  Resolution:  1920x1080‏,  Optical Drive:  No Optical Drive‏,  Connection Ports:  DVI‏, USB 2.0‏, USB 3.0‏,  Operating System:  Windows 8‏,  Language:  Hebrew‏, English‏, Arabic‏,  Features:  IPS‏,  Warranty:  3 Years‏, ', '3890', 3300, 'http://img.ksp.co.il/item/17769/m_1.jpg', '1', '1'),
(3, 'HP', 'HP Rove 20 All-in-One 20-K000EJ', ' Brand:  HP‏,  Size:  20''''‏,  CPU:  Intel Core i3‏,  Capacity:  1TB‏,  GPU:  Intel‏,  Memory Size:  4GB‏,  Resolution:  1600x900‏,  Optical Drive:  No Optical Drive‏,  Connection Ports:  USB 2.0‏, USB 3.0‏,  Operating System:  Windows 8‏,  Language:  Hebrew‏, English‏, Russian‏,  Features:  Touch Screen‏, Intel Haswell Proccessor‏, Front Camera‏,  Warranty:  1 Year‏, ', '3935', 3500, 'http://img.zap.co.il/pics/new/15102013162526c.gif', '1', '0'),
(4, 'Fujitsu', 'Fujitsu Esprimo P410-P62F5IL', ' Brand:  Fujitsu‏,  CPU:  Intel Pentium‏,  Capacity:  500GB‏,  GPU:  Intel‏,  Memory Size:  4GB‏,  Chipset:  H61‏,  Watts / Amp:  280W‏,  Connection Ports:  VGA‏, DVI‏, USB 2.0‏, RJ 45‏,  Operating System:  Free Dos‏,  Warranty:  3 Years‏,', '1245', 1000, 'http://img.ksp.co.il/item/20508/m_1.jpg', '2', '1'),
(5, 'Lenovo', 'Lenovo A10 Touch 5938-8565 - Black	', ' Brand:  Lenovo‏,  Size:  10.1''''‏,  CPU:  Cortex‏,  Capacity:  16GB‏,  GPU:  None‏,  Memory Size:  1GB‏,  Resolution:  1366x768‏,  Optical Drive:  No Optical Drive‏,  Color:  Black‏,  Connection Ports:  USB 2.0‏, Micro USB‏,  Operating System:  Android‏,  Language:  Hebrew‏, English‏,  Features:  SSD‏, Touch Screen‏, AntiGlare‏, Bluetooth‏,  Warranty:  1 Year‏, ', '1140', 850, 'http://img.ksp.co.il/item/20827/m_7.jpg', '3', '1'),
(6, 'Asus', 'ASUS N550JV-CM248H', ' Brand:  Asus‏,  Size:  15.6''''‏,  CPU:  Intel Core i7‏,  Capacity:  750GB‏,  GPU:  Nvidia‏,  Memory Size:  8GB‏,  Resolution:  1920x1080‏,  Optical Drive:  Blu-Ray Combo‏,  Color:  Black‏, Gray‏,  Connection Ports:  HDMI‏, Mini DisplayPort‏, USB 2.0‏, USB 3.0‏,  Operating System:  Windows 8‏,  Language:  Hebrew‏, English‏, Russian‏,  Features:  7200RPM‏, Touch Screen‏, Full HD‏, Intel Haswell Proccessor‏, Backlit Keyboard‏, Full Keyboard‏, Bluetooth‏,  Warranty:  3 Years‏, ', '5890', 5000, 'http://img.ksp.co.il/item/19823/m_7.jpg', '3', '1'),
(7, 'Samsung', 'Samsung ATIV Book 2 NP270E5V-K01IL - Mineral Ash Black', ' Brand:  Samsung‏,  Size:  15.6''''‏,  CPU:  Intel Pentium‏,  Capacity:  500GB‏,  GPU:  Intel‏,  Memory Size:  4GB‏,  Resolution:  1366x768‏,  Optical Drive:  DVD-RW (Dual Layer)‏,  Color:  Black‏,  Connection Ports:  VGA‏, HDMI‏, USB 2.0‏,  Operating System:  Free Dos‏,  Features:  5400RPM‏, AntiGlare‏, Full Keyboard‏, Bluetooth‏,  Warranty:  1 Year‏, ', '1690', 1400, 'http://img.ksp.co.il/item/19686/m_1.jpg', '3', '3'),
(8, 'Fujitsu', 'Fujitsu LifeBook AH502-M42C5IL', ' Brand:  Fujitsu‏,  Size:  15.6''''‏,  CPU:  Intel Pentium‏,  Capacity:  500GB‏,  GPU:  Intel‏,  Memory Size:  4GB‏,  Resolution:  1366x768‏,  Optical Drive:  DVD-RW‏,  Color:  Black‏,  Connection Ports:  VGA‏, HDMI‏, USB 2.0‏,  Operating System:  Free Dos‏,  Features:  5400RPM‏, AntiGlare‏, Full Keyboard‏, WiDi‏, Bluetooth‏, 34mm ExpressCard‏,  Warranty:  3 Years‏, ', '1750', 1425, 'http://img.ksp.co.il/item/19412/m_1.jpg', '3', '3'),
(9, 'Apple', 'Apple iPad 2 WiFi', ' Brand:  Apple‏,  Size:  9.7''''‏,  CPU:  Apple A5‏,  Capacity:  16GB‏,  Memory Size:  512MB‏,  Resolution:  1024x768‏,  Color:  Black‏,  Operating System:  iOS‏,  Language:  Hebrew‏, English‏, Russian‏,  Features:  WiFi‏, Front Camera‏, Rear Camera‏,  Warranty:  1 Year‏, ', '1790', 1300, 'http://img.ksp.co.il/item/13548/m_1.jpg', '4', '1'),
(10, 'Lenovo', 'Lenovo IdeaTab A1000-F 16GB 5937-4134', ' Brand:  Lenovo‏,  Size:  7''''‏,  CPU:  MediaTek‏,  Capacity:  16GB‏,  Memory Size:  1GB‏,  Resolution:  1024x600‏,  Color:  White‏,  Connection Ports:  Micro USB‏,  Operating System:  Android‏,  Language:  Hebrew‏, English‏, Russian‏,  Features:  GPS‏, WiFi‏, Expansion Card‏, Front Camera‏,  Warranty:  1 Year‏, ', '655', 500, 'http://img.ksp.co.il/item/20566/m_4.jpg', '4', '4'),
(11, 'Samsung', 'Samsung Galaxy Tab 3 SM-T210 - WiFi', ' Brand:  Samsung‏,  Size:  7''''‏,  CPU:  Cortex‏,  Capacity:  8GB‏,  Memory Size:  1GB‏,  Resolution:  1024x600‏,  Color:  White‏,  Connection Ports:  Micro USB‏,  Operating System:  Android‏,  Language:  Hebrew‏, English‏, Russian‏,  Features:  GPS‏, WiFi‏, Expansion Card‏, Front Camera‏, Rear Camera‏,  Warranty:  3 Years‏, ', '995', 800, 'http://img.ksp.co.il/item/20271/m_2.jpg', '4', '5'),
(12, 'HP', 'HP Slate 7 2801 Tablet - E0P94AA', ' Brand:  HP‏,  Size:  7''''‏,  CPU:  Cortex‏,  Capacity:  8GB‏,  Memory Size:  1GB‏,  Resolution:  1024x600‏,  Color:  Red‏,  Connection Ports:  Micro USB‏,  Operating System:  Android‏,  Language:  Hebrew‏, English‏, Russian‏,  Features:  WiFi‏, Expansion Card‏, Front Camera‏, Rear Camera‏,  Warranty:  1 Year‏, ', '780', 630, 'http://content.etilize.com/Large/1024688669.jpg', '4', '5');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `birthdate` date NOT NULL,
  `registered` datetime NOT NULL,
  `addressid` int(11) DEFAULT NULL,
  `balance` int(30) NOT NULL DEFAULT '0',
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=71 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `firstname`, `lastname`, `birthdate`, `registered`, `addressid`, `balance`, `isadmin`, `enabled`) VALUES
(68, 'slavak@spotoption.com', 'a18a822d3496477712f84944dc2073fb', 'Slava', 'Aaaaaaaa', '1996-01-02', '2014-01-08 08:10:54', 3, 5172, 1, 1),
(69, 'slavak@ption.com', '4b2514b09648e14e8ef7b15f7602f60c', 'fghdfhdfgh', 'dfghdfgh', '1996-01-02', '2014-01-29 10:39:57', NULL, 0, 0, 1),
(70, 'slavak@ption2.com', 'dbd4d76f5d2123a7fcac38ea538b1b67', 'dsfgsdfg', 'sdfgsdfg', '1996-01-01', '2014-01-29 10:40:46', 12, 59957, 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
