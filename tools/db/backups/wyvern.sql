-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 17, 2015 at 05:51 PM
-- Server version: 5.5.41
-- PHP Version: 5.4.4-14+deb7u5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `doctr`
--

-- --------------------------------------------------------

--
-- Table structure for table `wyvern_entities`
--

CREATE TABLE IF NOT EXISTS `wyvern_entities` (
  `id` tinyint(22) NOT NULL AUTO_INCREMENT,
  `entity_name` varchar(255) NOT NULL,
  `entity_slug` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `wyvern_entities`
--

INSERT INTO `wyvern_entities` (`id`, `entity_name`, `entity_slug`) VALUES
(1, 'Booking', 'booking'),
(2, 'Doctor', 'doctor'),
(3, 'Patient', 'patient');

-- --------------------------------------------------------

--
-- Table structure for table `wyvern_entity_fields`
--

CREATE TABLE IF NOT EXISTS `wyvern_entity_fields` (
  `id` tinyint(22) NOT NULL AUTO_INCREMENT,
  `parent_id` tinyint(22) NOT NULL,
  `entity_field_name` varchar(220) NOT NULL,
  `entity_field_slug` varchar(220) NOT NULL,
  `entity_field_desc` tinyblob NOT NULL,
  `entity_value_type` varchar(220) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `wyvern_entity_fields`
--

INSERT INTO `wyvern_entity_fields` (`id`, `parent_id`, `entity_field_name`, `entity_field_slug`, `entity_field_desc`, `entity_value_type`) VALUES
(1, 1, 'Id', 'id', '', 'integer'),
(2, 1, 'Doctor', 'doctor', '', 'integer'),
(3, 1, 'Patient', 'patient', '', 'integer'),
(4, 1, 'Date', 'date', '', 'date'),
(5, 2, 'Id', 'id', '', 'integer'),
(6, 2, 'Name', 'name', '', 'string'),
(7, 2, 'Date Of Birth', 'date_of_birth', '', 'date'),
(8, 2, 'Listed Address', 'listed_address', '', 'string'),
(9, 2, 'Clinic Address', 'clinic_address', '', 'string'),
(10, 2, 'Specialty', 'specialty', '', 'string'),
(11, 3, 'Id', 'id', '', 'integer'),
(12, 3, 'Name', 'name', '', 'string'),
(13, 3, 'Date Of Birth', 'date_of_birth', '', 'date');

-- --------------------------------------------------------

--
-- Table structure for table `wyvern_entity_values`
--

CREATE TABLE IF NOT EXISTS `wyvern_entity_values` (
  `entity_field_id` tinyint(22) NOT NULL,
  `id` tinyint(22) NOT NULL AUTO_INCREMENT,
  `value` blob NOT NULL,
  `parent_entity_id` tinyint(22) NOT NULL,
  `unique_id` tinyint(22) NOT NULL COMMENT 'This collates the Entity',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wyvern_model`
--

CREATE TABLE IF NOT EXISTS `wyvern_model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
