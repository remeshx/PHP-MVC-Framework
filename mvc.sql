-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2020 at 12:05 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) NOT NULL,
  `title` varchar(191) NOT NULL,
  `body` text NOT NULL,
  `cat_id` int(10) NOT NULL,
  `image` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;





DROP TABLE IF EXISTS `mvc_admin_users`;
CREATE TABLE IF NOT EXISTS `mvc_admin_users` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf8_persian_ci NOT NULL,
  `lName` tinytext COLLATE utf8_persian_ci NOT NULL,
  `codeMeli` tinytext COLLATE utf8_persian_ci NOT NULL,
  `dateRegistered` datetime NOT NULL,
  `tel` tinytext COLLATE utf8_persian_ci NOT NULL,
  `email` tinytext COLLATE utf8_persian_ci NOT NULL,
  `userNam` tinytext COLLATE utf8_persian_ci NOT NULL,
  `passWor` tinytext COLLATE utf8_persian_ci NOT NULL,
  `lastVisit` datetime NOT NULL,
  `loginTime` datetime NOT NULL,
  `tag` tinytext COLLATE utf8_persian_ci NOT NULL,
  `activated` tinyint(4) NOT NULL,
  `SID` tinytext COLLATE utf8_persian_ci NOT NULL,
  `accessPages` tinytext COLLATE utf8_persian_ci NOT NULL,
  `readonly` tinyint(4) NOT NULL,
  `shobe` smallint(6) NOT NULL DEFAULT 999 COMMENT 'شعبه دسترسی',
  `userTempId` bigint(20) NOT NULL,
  `helpDeskActive` tinyint(4) NOT NULL DEFAULT 0,
  `helpDeskAccessUsers` tinytext COLLATE utf8_persian_ci NOT NULL COMMENT 'دسترسی شخص به پیام های سایر کاربران',
  `connectIP` tinytext COLLATE utf8_persian_ci NOT NULL COMMENT 'اتصال از آی پی های خاص',
  `desktopActive` tinyint(11) NOT NULL COMMENT 'قابلیت اتصال با نرم افزار دسکتاپ',
  `cellPhone` varchar(15) COLLATE utf8_persian_ci NOT NULL,
  `adminType` tinyint(4) NOT NULL,
  `accessFactory` smallint(6) NOT NULL DEFAULT 0,
  `telExt` smallint(6) NOT NULL DEFAULT 0,
  `country` int(11) NOT NULL,
  `POSTerminalId` int(11) NOT NULL,
  `accessAllRoutes` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=492 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `mvc_admin_users`
--

INSERT INTO `mvc_admin_users` (`id`, `name`, `lName`, `codeMeli`, `dateRegistered`, `tel`, `email`, `userNam`, `passWor`, `lastVisit`, `loginTime`, `tag`, `activated`, `SID`, `accessPages`, `readonly`, `shobe`, `userTempId`, `helpDeskActive`, `helpDeskAccessUsers`, `connectIP`, `desktopActive`, `cellPhone`, `adminType`, `accessFactory`, `telExt`, `country`, `POSTerminalId`, `accessAllRoutes`) VALUES
(491, 'Reza', 'Meshkat', '', '0000-00-00 00:00:00', '', '', 'RezaMeshkat', '998ed4d621742d0c2d85ed84173db569afa194d4597686cae947324aa58ab4bb', '2020-03-28 01:26:04', '2020-03-27 20:55:51', '', 0, '', '', 0, 999, 0, 0, '', '', 0, '', 0, 0, 0, 0, 0, 0);
COMMIT;
