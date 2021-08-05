-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 01, 2012 at 01:21 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(250) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `gender` enum('male','female') NOT NULL DEFAULT 'male',
  `address` varchar(300) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip` int(11) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(300) NOT NULL,
  `pic` varchar(80) NOT NULL,
  `locked` enum('yes','no') NOT NULL DEFAULT 'no',
  `type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `password`, `first_name`, `last_name`, `gender`, `address`, `city`, `state`, `zip`, `phone`, `email`, `pic`, `locked`, `type`) VALUES
(23, 'final', '123654', 'fa', 'aaa', 'male', 'tea', '', '', 0, '+923333333', 'tauqeer@gmail.com', '', 'no', 'Sales manager'),
(20, 'shoukat', '123', 'Shoukat', 'Hayat', 'male', 'test', '', '', 0, '+923333333', 'shoukat@gmail.com', '', 'no', 'Sales manager'),
(21, 'shoukat', '123', 'Shoukat', 'Hayat', 'male', 'test', '', '', 0, '+923333333', 'shoukat@gmail.com', '', 'no', 'Sales manager');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `order_date` int(11) NOT NULL,
  `order_status` enum('new','pending','delivered','canceled') COLLATE latin1_general_ci NOT NULL DEFAULT 'new',
  `order_type` enum('bill','wish') COLLATE latin1_general_ci NOT NULL DEFAULT 'bill',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=42 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `member_id`, `amount`, `order_date`, `order_status`, `order_type`) VALUES
(30, 6, '9100', 1345871904, 'new', 'bill'),
(10, 5, '77000', 1340192777, 'pending', 'wish'),
(5, 5, '22500', 1340189918, 'pending', 'wish'),
(6, 5, '22500', 1340189919, 'pending', 'wish'),
(7, 5, '22500', 1340189926, 'pending', 'wish'),
(8, 5, '22500', 1340189997, 'pending', 'wish'),
(9, 5, '22500', 1340190011, 'pending', 'wish'),
(36, 1, '33', 1346102605, 'new', 'bill'),
(35, 1, '33', 1346102575, 'new', 'bill'),
(28, 6, '9100', 1345871759, 'new', 'bill'),
(29, 6, '9100', 1345871829, 'new', 'bill'),
(40, 1, '33', 1346103019, 'new', 'bill'),
(37, 1, '33', 1346102665, 'new', 'bill'),
(38, 1, '33', 1346102761, 'new', 'bill'),
(39, 1, '33', 1346102958, 'new', 'bill'),
(31, 6, '9100', 1345871955, 'pending', 'bill'),
(32, 6, '420', 1345874267, 'new', 'wish'),
(33, 6, '420', 1345874271, 'new', 'wish'),
(34, 6, '420', 1345874406, 'new', 'wish');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE IF NOT EXISTS `order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_rate` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=51 ;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `qty`, `unit_rate`) VALUES
(31, 28, 894, 1, '1300'),
(2, 2, 869, 1, '22500'),
(11, 10, 867, 1, '54500'),
(10, 10, 869, 1, '22500'),
(5, 5, 869, 1, '22500'),
(6, 6, 869, 1, '22500'),
(7, 7, 869, 1, '22500'),
(8, 8, 869, 1, '22500'),
(9, 9, 869, 1, '22500'),
(18, 17, 885, 1, '20000'),
(20, 19, 892, 1, '3000'),
(21, 20, 892, 1, '3000'),
(30, 28, 906, 6, '1300'),
(49, 40, 925, 1, '33'),
(44, 35, 925, 1, '33'),
(45, 36, 925, 1, '33'),
(46, 37, 925, 1, '33'),
(47, 38, 925, 1, '33'),
(48, 39, 925, 1, '33'),
(32, 29, 906, 6, '1300'),
(33, 29, 894, 1, '1300'),
(34, 30, 906, 6, '1300'),
(35, 30, 894, 1, '1300'),
(36, 31, 906, 6, '1300'),
(37, 31, 894, 1, '1300'),
(38, 32, 925, 6, '33'),
(39, 32, 926, 1, '222'),
(40, 33, 925, 6, '33'),
(41, 33, 926, 1, '222'),
(42, 34, 925, 6, '33'),
(43, 34, 926, 1, '222');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL DEFAULT '',
  `title` varchar(80) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `section` enum('header','footer','both','link') NOT NULL DEFAULT 'header',
  `locked` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `title`, `description`, `text`, `section`, `locked`) VALUES
(52, 'Warranty', 'Warranty', '', 'test', 'link', 'no'),
(49, 'About us', 'About us', 'About us', '<p>\r\n<strong><br />\r\n</strong>\r\n</p>\r\n', 'link', 'no'),
(46, 'Privacy', 'Privacy Policy', 'outletpvtltd.com', '', 'both', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE IF NOT EXISTS `preferences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `value` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `preferences`
--

INSERT INTO `preferences` (`id`, `name`, `value`) VALUES
(1, 'customersupport', '0333-6751148...  ');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) NOT NULL,
  `sub_cat_id` int(11) NOT NULL,
  `title` varchar(80) NOT NULL,
  `description` text NOT NULL,
  `detail` text NOT NULL,
  `price` int(11) NOT NULL,
  `pic1` varchar(80) NOT NULL,
  `pic2` varchar(250) NOT NULL,
  `pic3` varchar(250) NOT NULL,
  `pic4` varchar(250) NOT NULL,
  `pic5` varchar(250) NOT NULL,
  `pic6` varchar(250) NOT NULL,
  `pic7` varchar(250) NOT NULL,
  `pic8` varchar(250) NOT NULL,
  `pic9` varchar(250) NOT NULL,
  `featured` enum('featured','normal') NOT NULL DEFAULT 'featured',
  `date_created` int(11) NOT NULL,
  `locked` enum('no','yes') NOT NULL DEFAULT 'no',
  `newarrival` enum('false','true') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=927 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `categoryid`, `sub_cat_id`, `title`, `description`, `detail`, `price`, `pic1`, `pic2`, `pic3`, `pic4`, `pic5`, `pic6`, `pic7`, `pic8`, `pic9`, `featured`, `date_created`, `locked`, `newarrival`) VALUES
(926, 18, 158, 'test', 'test', 'test', 222, 'testea4c9c29261.jpg', '', '', '', '', '', '', '', '', 'featured', 1345874191, 'no', 'true'),
(925, 15, 157, 'Testing Product', 'TEst', 'test', 33, 'Testing-Producte3eaa5c9251.jpg', '', '', '', '', '', '', '', '', 'featured', 1345873987, 'no', '');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE IF NOT EXISTS `product_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `locked` enum('no','yes') COLLATE latin1_general_ci NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `locked`) VALUES
(18, 'Decorations', 'no'),
(17, 'Frames', 'no'),
(16, 'Painting', 'no'),
(15, 'Furniture', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `product_subcategories`
--

CREATE TABLE IF NOT EXISTS `product_subcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=161 ;

--
-- Dumping data for table `product_subcategories`
--

INSERT INTO `product_subcategories` (`id`, `categoryid`, `name`) VALUES
(160, 16, 'Painting Category'),
(159, 17, 'Sub Category'),
(158, 18, 'Test'),
(157, 15, 'Handi Crafts');

-- --------------------------------------------------------

--
-- Table structure for table `slider_images`
--

CREATE TABLE IF NOT EXISTS `slider_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(250) NOT NULL DEFAULT '',
  `url` text NOT NULL,
  `description` text NOT NULL,
  `section` enum('main','featured') NOT NULL DEFAULT 'main',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `slider_images`
--

INSERT INTO `slider_images` (`id`, `name`, `title`, `url`, `description`, `section`) VALUES
(32, '13458745401.JPG', 'Handi Crafts', 'http://google.com', 'test', 'main'),
(31, '13458706931.jpg', 'This is cation', 'http://google.com', 'test', 'main');
