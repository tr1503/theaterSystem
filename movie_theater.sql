-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 27, 2018 at 11:20 PM
-- Server version: 5.7.11-log
-- PHP Version: 5.6.30

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `movie_theater`
--

CREATE DATABASE IF NOT EXISTS movie_theater;

-- --------------------------------------------------------

--
-- Table structure for table `auditorium`
--

CREATE TABLE IF NOT EXISTS `auditorium` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `seats_no` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `password` varchar(10) NOT NULL,
  `aud_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aud_id` (`aud_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `merchandise`
--

CREATE TABLE IF NOT EXISTS `merchandise` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `price` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `merchandise_reserve`
--

CREATE TABLE IF NOT EXISTS `merchandise_reserve` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `merchandise_id` int(2) DEFAULT NULL,
  `reserve_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `merchandise_id` (`merchandise_id`),
  KEY `reserve_id` (`reserve_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE IF NOT EXISTS `movie` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `director` varchar(20) NOT NULL,
  `rating` double NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `scr_id` int(5) NOT NULL,
  `movie_payment` double NOT NULL,
  `merchandise_payment` double DEFAULT NULL,
  `total_payment` double NOT NULL,
  `paid` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `scr_id` (`scr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `screening`
--

CREATE TABLE IF NOT EXISTS `screening` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `movie_id` int(5) DEFAULT NULL,
  `aud_id` int(5) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `movie_id` (`movie_id`),
  KEY `aud_id` (`aud_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `seat`
--

CREATE TABLE IF NOT EXISTS `seat` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `row` int(2) NOT NULL,
  `number` int(2) NOT NULL,
  `aud_id` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `aud_id` (`aud_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `seat_reserve`
--

CREATE TABLE IF NOT EXISTS `seat_reserve` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `reserve_id` int(5) NOT NULL,
  `seat_id` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reserve_id` (`reserve_id`),
  KEY `seat_id` (`seat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `password` varchar(10) NOT NULL,
  `phone` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_reserve`
--

CREATE TABLE IF NOT EXISTS `user_reserve` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `user_id` int(5) DEFAULT NULL,
  `reserve_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `reserve_id` (`reserve_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`aud_id`) REFERENCES `auditorium` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `merchandise_reserve`
--
ALTER TABLE `merchandise_reserve`
  ADD CONSTRAINT `merchandise_reserve_ibfk_1` FOREIGN KEY (`merchandise_id`) REFERENCES `merchandise` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `merchandise_reserve_ibfk_2` FOREIGN KEY (`reserve_id`) REFERENCES `reservation` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`scr_id`) REFERENCES `screening` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `screening`
--
ALTER TABLE `screening`
  ADD CONSTRAINT `screening_ibfk_3` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `screening_ibfk_4` FOREIGN KEY (`aud_id`) REFERENCES `auditorium` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `seat`
--
ALTER TABLE `seat`
  ADD CONSTRAINT `seat_ibfk_1` FOREIGN KEY (`aud_id`) REFERENCES `auditorium` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seat_reserve`
--
ALTER TABLE `seat_reserve`
  ADD CONSTRAINT `seat_reserve_ibfk_1` FOREIGN KEY (`reserve_id`) REFERENCES `reservation` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `seat_reserve_ibfk_2` FOREIGN KEY (`seat_id`) REFERENCES `seat` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_reserve`
--
ALTER TABLE `user_reserve`
  ADD CONSTRAINT `user_reserve_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_reserve_ibfk_6` FOREIGN KEY (`reserve_id`) REFERENCES `reservation` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
