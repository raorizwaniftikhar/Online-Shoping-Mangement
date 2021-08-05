-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2015 at 01:27 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


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
  `order_date` date NOT NULL,
  `order_status` enum('new','pending','delivered','canceled') COLLATE latin1_general_ci NOT NULL DEFAULT 'new',
  `order_type` enum('bill','wish') COLLATE latin1_general_ci NOT NULL DEFAULT 'bill',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=58 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `member_id`, `amount`, `order_date`, `order_status`, `order_type`) VALUES
(55, 23, 1500, '2015-10-10', 'new', 'bill'),
(56, 23, 11000, '2015-10-10', 'new', 'bill'),
(57, 23, 16321, '1970-01-01', 'new', 'bill'),
(54, 23, 1500, '2015-10-10', 'new', 'bill');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=78 ;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `qty`, `unit_rate`) VALUES
(60, 49, 932, 1, 1500),
(2, 2, 869, 1, 22500),
(11, 10, 867, 1, 54500),
(10, 10, 869, 1, 22500),
(5, 5, 869, 1, 22500),
(6, 6, 869, 1, 22500),
(7, 7, 869, 1, 22500),
(8, 8, 869, 1, 22500),
(9, 9, 869, 1, 22500),
(18, 17, 885, 1, 20000),
(20, 19, 892, 1, 3000),
(21, 20, 892, 1, 3000),
(59, 48, 937, 1, 2500),
(73, 56, 932, 1, 1500),
(67, 51, 932, 1, 1500),
(58, 48, 932, 1, 1500),
(68, 51, 937, 1, 2500),
(71, 54, 932, 1, 1500),
(72, 55, 932, 1, 1500),
(62, 49, 936, 1, 3000),
(61, 49, 937, 1, 2500),
(64, 50, 937, 1, 2500),
(63, 50, 932, 1, 1500),
(66, 50, 935, 1, 2300),
(65, 50, 936, 1, 3000),
(38, 32, 925, 6, 33),
(39, 32, 926, 1, 222),
(40, 33, 925, 6, 33),
(41, 33, 926, 1, 222),
(42, 34, 925, 6, 33),
(43, 34, 926, 1, 222),
(51, 42, 926, 1, 222),
(52, 43, 926, 1, 222),
(53, 44, 926, 1, 222),
(54, 45, 930, 1, 9500),
(55, 46, 935, 1, 2300),
(56, 47, 935, 1, 2300),
(57, 47, 930, 1, 9500),
(74, 56, 930, 1, 9500),
(75, 57, 932, 1, 1500),
(76, 57, 930, 1, 9500),
(77, 57, 929, 1, 5321);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=938 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `categoryid`, `sub_cat_id`, `title`, `description`, `detail`, `price`, `pic1`, `pic2`, `pic3`, `pic4`, `pic5`, `pic6`, `pic7`, `pic8`, `pic9`, `featured`, `date_created`, `locked`, `newarrival`) VALUES
(930, 18, 163, 'Ladies Pretwear', '', '', 9500, 'Ladies-Pretwear2c8205a9301.jpg', '', '', '', '', '', '', '', '', 'featured', 1440392423, 'no', ''),
(928, 18, 163, 'Emerald Zone Silk Collection', '', 'jhjkjs', 5485, 'Emerald-Zone-Silk-Collection6bdb7579281.jpg', '', '', '', '', '', '', '', '', 'featured', 1440391919, 'no', ''),
(929, 18, 163, 'Silk Formal Pretwear in Beige', '', 'Its a beige color silk stuff', 5321, 'Silk-Formal-Pretwear-in-Beige8e8cb759291.jpg', '', '', '', '', '', '', '', '', 'featured', 1440392308, 'no', 'true'),
(931, 18, 162, 'Burnt Brown Causal Kurti', '', 'Its our new collection', 3385, 'Burnt-Brown-Causal-Kurti070e6069311.jpg', '', '', '', '', '', '', '', '', 'featured', 1440392827, 'no', 'true'),
(932, 18, 164, 'Bloosom pink', '', '', 1500, 'Bloosom-pinkb4e65819321.jpg', 'Bloosom-pink85b532b9322.jpg', 'Bloosom-pink170bf409323.jpg', 'Bloosom-pink78328c49324.jpg', 'Bloosom-pink65597cb9325.jpg', '', '', '', '', 'featured', 1440693284, 'no', ''),
(933, 18, 180, 'Merlin Black', '', '', 2200, 'Merlin-Blackdc302bc9331.jpg', 'Merlin-Blacka546c199332.jpg', 'Merlin-Black8cfb5939333.jpg', 'Merlin-Black045f8c69334.jpg', 'Merlin-Black7c28ce59335.jpg', '', '', '', '', 'featured', 1440725619, 'no', ''),
(934, 18, 180, 'Metro Shoe Black', '', '', 2500, 'Metro-Shoe-Black71b5ec19341.jpg', 'Metro-Shoe-Black292c1589342.jpg', 'Metro-Shoe-Black4c2624f9343.jpg', 'Metro-Shoe-Black7d40c299344.jpg', 'Metro-Shoe-Blackd53139f9345.jpg', '', '', '', '', 'featured', 1440725692, 'no', ''),
(935, 18, 180, 'Metro Shoe White', '', '', 2300, 'Metro-Shoe-Whited6ccac89351.jpg', 'Metro-Shoe-White4ffb41e9352.jpg', 'Metro-Shoe-Whitef353e1e9353.jpg', 'Metro-Shoe-White8b461bd9354.jpg', 'Metro-Shoe-Whited16fc569355.jpg', '', '', '', '', 'featured', 1440725746, 'no', ''),
(936, 18, 162, ' Yellow Viscose Long Sleeve Kurti - Navy', '', '', 3000, '-Yellow-Viscose-Long-Sleeve-Kurti---Navy27e907c9361.jpg', '-Yellow-Viscose-Long-Sleeve-Kurti---Navyc4a58909362.jpg', '-Yellow-Viscose-Long-Sleeve-Kurti---Navy33b3c9f9363.jpg', '-Yellow-Viscose-Long-Sleeve-Kurti---Navy3c02d729364.jpg', '-Yellow-Viscose-Long-Sleeve-Kurti---Navye1cf8699365.jpg', '-Yellow-Viscose-Long-Sleeve-Kurti---Navy364b3d79366.jpg', '-Yellow-Viscose-Long-Sleeve-Kurti---Navyd8f37149367.jpg', '', '', 'featured', 1440796065, 'no', ''),
(937, 18, 162, 'Crepe Silk Kurti - Paste', '', '', 2500, 'Crepe-Silk-Kurti---Paste981af459371.jpg', 'Crepe-Silk-Kurti---Paste3cbf3719372.jpg', 'Crepe-Silk-Kurti---Pastec05246a9373.jpg', 'Crepe-Silk-Kurti---Paste9411d649374.jpg', '', '', '', '', '', 'featured', 1440796252, 'no', '');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE IF NOT EXISTS `product_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `locked` enum('no','yes') COLLATE latin1_general_ci NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=24 ;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `locked`) VALUES
(18, 'Ladies', 'no'),
(17, 'Gents', 'no'),
(16, 'Kids', 'no'),
(20, 'Teens', 'no'),
(21, 'Wedding', 'no'),
(22, 'Accessories', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `product_subcategories`
--

CREATE TABLE IF NOT EXISTS `product_subcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=183 ;

--
-- Dumping data for table `product_subcategories`
--

INSERT INTO `product_subcategories` (`id`, `categoryid`, `name`) VALUES
(162, 18, 'Kurti'),
(163, 18, 'Stiched'),
(164, 18, 'Unstiched'),
(165, 17, 'Kamez Shalwar'),
(166, 17, 'Kurta'),
(167, 17, 'Footwear'),
(168, 16, 'Girls'),
(169, 16, 'Boys'),
(170, 16, 'Infants'),
(172, 20, 'Girls'),
(173, 20, 'Boys'),
(174, 21, 'Sherwani'),
(175, 21, 'Bridal Dresses'),
(176, 22, 'Ladies Trousers'),
(177, 22, 'Teen''s Trousers'),
(178, 22, 'Hand Bag'),
(179, 22, 'Waist Coat'),
(180, 18, 'Footwear');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `slider_images`
--

INSERT INTO `slider_images` (`id`, `name`, `title`, `url`, `description`, `section`) VALUES
(35, '1440407417.png', '', 'http://', '', 'main'),
(31, '1440407331.png', '', '', '', 'main'),
(33, '1440407519.png', '', 'http://', '', 'main');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
