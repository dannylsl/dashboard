-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2014 at 03:10 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `adsdashboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `accinfo`
--

CREATE TABLE IF NOT EXISTS `accinfo` (
  `accemail` varchar(128) NOT NULL,
  `password` varchar(200) NOT NULL,
  `accname` varchar(200) NOT NULL,
  `company` varchar(200) NOT NULL,
  `url` varchar(1024) NOT NULL,
  `flow` int(11) NOT NULL,
  `adminlist` text NOT NULL,
  `registertime` date NOT NULL,
  `lastlentrytime` date NOT NULL,
  `lastentryip` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `accinfo`
--

INSERT INTO `accinfo` (`accemail`, `password`, `accname`, `company`, `url`, `flow`, `adminlist`, `registertime`, `lastlentrytime`, `lastentryip`) VALUES
('58@58.com', '789456', '', '', '', 0, '', '2014-11-06', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `captcha`
--

CREATE TABLE IF NOT EXISTS `captcha` (
`captcha_id` bigint(13) unsigned NOT NULL,
  `captcha_time` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `word` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `captcha`
--

INSERT INTO `captcha` (`captcha_id`, `captcha_time`, `ip_address`, `word`) VALUES
(1, 1415279122, '127.0.0.1', 'JaL3'),
(2, 1415279677, '127.0.0.1', 'S9xX'),
(3, 1415280371, '127.0.0.1', 'D7Gw'),
(4, 1415280695, '127.0.0.1', 'P6nr'),
(5, 1415281567, '127.0.0.1', 'a1hV'),
(6, 1415281576, '127.0.0.1', 'sDU5'),
(7, 1415281827, '127.0.0.1', '411W'),
(8, 1415282348, '127.0.0.1', 'wyoi'),
(9, 1415282387, '127.0.0.1', 'Gzgc'),
(10, 1415282476, '127.0.0.1', 'qmUL'),
(11, 1415282479, '127.0.0.1', 'qyys'),
(12, 1415282505, '127.0.0.1', 'cyQ3'),
(13, 1415282547, '127.0.0.1', '6Ktg'),
(14, 1415282792, '127.0.0.1', 'aqJ6'),
(15, 1415282810, '127.0.0.1', 'rq3E'),
(16, 1415282982, '127.0.0.1', 'ZDnK'),
(17, 1415282983, '127.0.0.1', 'y2L0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accinfo`
--
ALTER TABLE `accinfo`
 ADD PRIMARY KEY (`accemail`), ADD UNIQUE KEY `accmail` (`accemail`);

--
-- Indexes for table `captcha`
--
ALTER TABLE `captcha`
 ADD PRIMARY KEY (`captcha_id`), ADD KEY `word` (`word`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `captcha`
--
ALTER TABLE `captcha`
MODIFY `captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
