-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 05, 2016 at 02:21 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

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
  `acc_id` int(11) NOT NULL,
  `accemail` varchar(128) NOT NULL,
  `password` varchar(200) NOT NULL,
  `accname` varchar(200) NOT NULL,
  `company` varchar(200) NOT NULL,
  `url` varchar(1024) NOT NULL,
  `flow` int(11) NOT NULL,
  `adminlist` text NOT NULL,
  `registertime` date NOT NULL,
  `lastentrytime` datetime NOT NULL,
  `lastentryip` varchar(32) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`accemail`),
  UNIQUE KEY `accmail` (`accemail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `accinfo`
--

INSERT INTO `accinfo` (`acc_id`, `accemail`, `password`, `accname`, `company`, `url`, `flow`, `adminlist`, `registertime`, `lastentrytime`, `lastentryip`, `status`) VALUES
(1, 'test@test.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', '', 0, '', '2014-11-06', '2016-02-05 13:49:29', '127.0.0.1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `accpidmap`
--

CREATE TABLE IF NOT EXISTS `accpidmap` (
  `pid` int(11) NOT NULL,
  `pid_name` int(11) NOT NULL,
  `acc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `accpidmap`
--

INSERT INTO `accpidmap` (`pid`, `pid_name`, `acc_id`) VALUES
(0, 58, 1);

-- --------------------------------------------------------

--
-- Table structure for table `captcha`
--

CREATE TABLE IF NOT EXISTS `captcha` (
  `captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,
  `captcha_time` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `word` varchar(20) NOT NULL,
  PRIMARY KEY (`captcha_id`),
  KEY `word` (`word`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `invoice_id` int(11) NOT NULL,
  `acc_id` int(11) NOT NULL,
  `invoice_type` int(11) NOT NULL,
  `invoice_date` date NOT NULL,
  `income` float NOT NULL,
  `tax` float NOT NULL,
  `income_tax` float NOT NULL,
  `pay_time` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `slotlist`
--

CREATE TABLE IF NOT EXISTS `slotlist` (
  `slot_id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `acc_id` int(11) NOT NULL,
  `slot_name` varchar(100) COLLATE utf8_bin NOT NULL,
  `type` varchar(30) COLLATE utf8_bin NOT NULL,
  `position` varchar(30) COLLATE utf8_bin NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `keywords_blacklist` text COLLATE utf8_bin NOT NULL,
  `url_blacklist` text COLLATE utf8_bin NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`slot_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `slotlist`
--

INSERT INTO `slotlist` (`slot_id`, `pid`, `acc_id`, `slot_name`, `type`, `position`, `width`, `height`, `keywords_blacklist`, `url_blacklist`, `status`) VALUES
(1, 0, 1, 'aaa', 'float', 'couplet', 120, 270, '0', '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stat`
--

CREATE TABLE IF NOT EXISTS `stat` (
  `acc_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `slot_id` int(11) NOT NULL,
  `pv` int(11) NOT NULL,
  `click` int(11) NOT NULL,
  `income` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
