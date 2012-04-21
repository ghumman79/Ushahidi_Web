-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 21, 2012 at 04:01 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ushahidi`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `locale` varchar(10) NOT NULL DEFAULT 'en_US',
  `category_position` tinyint(4) NOT NULL DEFAULT '0',
  `category_title` varchar(255) DEFAULT NULL,
  `category_description` text,
  `category_color` varchar(20) DEFAULT NULL,
  `category_image` varchar(255) DEFAULT NULL,
  `category_image_thumb` varchar(255) DEFAULT NULL,
  `category_visible` tinyint(4) NOT NULL DEFAULT '1',
  `category_trusted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_visible` (`category_visible`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Holds information about categories defined for a deployment' AUTO_INCREMENT=23 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` VALUES(1, 0, 'en_US', 4, 'Type', 'types of health facilities', '9900CC', NULL, NULL, 1, 0);
INSERT INTO `category` VALUES(2, 0, 'en_US', 2, 'Services', 'Services offered by health facilities', '3300FF', NULL, NULL, 1, 0);
INSERT INTO `category` VALUES(3, 0, 'en_US', 1, 'Region', 'Facilities by location', '663300', NULL, NULL, 1, 0);
INSERT INTO `category` VALUES(4, 0, 'en_US', 3, 'Trusted Reports', 'Reports from trusted reporters', '339900', NULL, NULL, 0, 1);
INSERT INTO `category` VALUES(5, 0, 'en_US', 0, 'NONE', 'Holds orphaned reports', '009887', NULL, NULL, 1, 1);
INSERT INTO `category` VALUES(6, 1, 'en_US', 5, 'Hosipal', 'type of facility', 'bcb9c9', NULL, NULL, 1, 0);
INSERT INTO `category` VALUES(7, 1, 'en_US', 6, 'Personal care Homes', 'type of facility', 'bcb9c9', NULL, NULL, 1, 0);
INSERT INTO `category` VALUES(8, 1, 'en_US', 7, 'Health Centres', 'type of facility', 'bcb9c9', NULL, NULL, 1, 0);
INSERT INTO `category` VALUES(9, 1, 'en_US', 8, 'Rehabilitation Centres', 'type of facility', 'bcb9c9', NULL, NULL, 1, 0);
INSERT INTO `category` VALUES(10, 3, 'en_US', 0, 'Sun Country', 'region', '1c9c5c', NULL, NULL, 1, 0);
INSERT INTO `category` VALUES(11, 3, 'en_US', 0, 'Saskatoon', 'region', '1c9c5c', NULL, NULL, 1, 0);
INSERT INTO `category` VALUES(12, 3, 'en_US', 0, 'Five Hills', 'region', '1c9c5c', NULL, NULL, 1, 0);
INSERT INTO `category` VALUES(13, 3, 'en_US', 0, 'Cypress', 'region', '1c9c5c', NULL, NULL, 1, 0);
INSERT INTO `category` VALUES(14, 3, 'en_US', 0, 'Regina Qu''Appelle', 'region', '1c9c5c', NULL, NULL, 1, 0);
INSERT INTO `category` VALUES(15, 3, 'en_US', 0, 'Sunrise', 'region', '1c9c5c', NULL, NULL, 1, 0);
INSERT INTO `category` VALUES(16, 3, 'en_US', 0, 'Heartland', 'region', '1c9c5c', NULL, NULL, 1, 0);
INSERT INTO `category` VALUES(17, 3, 'en_US', 0, 'Prince Albert Parkland', 'region', '1c9c5c', NULL, NULL, 1, 0);
INSERT INTO `category` VALUES(18, 3, 'en_US', 0, 'Prairie North', 'region', '1c9c5c', NULL, NULL, 1, 0);
INSERT INTO `category` VALUES(19, 3, 'en_US', 0, 'Mamawetan Churchhill River', 'region', '1c9c5c', NULL, NULL, 1, 0);
INSERT INTO `category` VALUES(20, 3, 'en_US', 0, 'Keewatin Yatthe', 'region', '1c9c5c', NULL, NULL, 1, 0);
INSERT INTO `category` VALUES(21, 3, 'en_US', 0, 'Athabasca Health Authority', 'region', '1c9c5c', NULL, NULL, 1, 0);
INSERT INTO `category` VALUES(22, 0, 'en_US', 0, 'Tester', 'testing', '472847', NULL, NULL, 1, 0);
