-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 04, 2018 at 08:36 PM
-- Server version: 5.6.37
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movie_theater`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `movieMarket`(IN `title` VARCHAR(50))
    NO SQL
BEGIN
	SELECT movie.id, movie.title, (COUNT(*) * movie.price) AS market
    FROM movie JOIN screening ON movie.id = screening.movie_id JOIN seat_reserve ON seat_reserve.scr_id = screening.id
    WHERE movie.title = title
    GROUP BY movie.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `searchFreeTime`(IN `startTime` DATETIME, IN `aud` INT)
    NO SQL
BEGIN
	SELECT * 
    FROM screening 
    WHERE startTime = screening.start_time AND aud = screening.aud_id; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `showOrder`(IN `aud` INT)
    NO SQL
BEGIN
	SELECT reservation.id, user.name, reservation.movie_payment 
    FROM reservation JOIN screening ON reservation.scr_id = screening.id JOIN user_reserve ON user_reserve.reserve_id = reservation.id JOIN user ON user.id = user_reserve.user_id 
    WHERE screening.aud_id = aud AND reservation.paid = 0;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `showUserOrder`(IN `userId` INT)
    NO SQL
BEGIN
	SELECT reservation.id, movie.title, screening.start_time, screening.end_time, reservation.paid 
    FROM user_reserve JOIN reservation ON user_reserve.reserve_id = reservation.id JOIN screening ON reservation.scr_id = screening.id JOIN movie ON screening.movie_id = movie.id 
    WHERE user_reserve.user_id = userId
    ORDER BY screening.start_time DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `topMovie`(IN `num` INT)
    NO SQL
BEGIN
	SELECT movie.id, movie.title, COUNT(*) AS reserve
    FROM movie JOIN screening ON movie.id = screening.movie_id JOIN seat_reserve ON seat_reserve.scr_id = screening.id
    GROUP BY movie.id
    ORDER BY COUNT(*) DESC
    LIMIT num;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `auditorium`
--

CREATE TABLE IF NOT EXISTS `auditorium` (
  `id` int(5) NOT NULL,
  `name` varchar(30) NOT NULL,
  `seats_no` int(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auditorium`
--

INSERT INTO `auditorium` (`id`, `name`, `seats_no`) VALUES
(1, 'Auditorium_A', 70),
(2, 'Auditorium_B', 50),
(3, 'Auditorium_C', 30),
(4, 'Auditorium_D', 30),
(5, 'Auditorium_E', 30);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(5) NOT NULL,
  `name` varchar(15) NOT NULL,
  `password` varchar(10) NOT NULL,
  `aud_id` int(5) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `name`, `password`, `aud_id`) VALUES
(1, 'hay55', 'Aq010101', 2),
(2, 'hye3', 'Aq010101', 1);

-- --------------------------------------------------------

--
-- Table structure for table `merchandise`
--

CREATE TABLE IF NOT EXISTS `merchandise` (
  `id` int(2) NOT NULL,
  `name` varchar(10) NOT NULL,
  `price` int(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `merchandise`
--

INSERT INTO `merchandise` (`id`, `name`, `price`) VALUES
(1, 'Popcorn', 5),
(2, 'Chips', 5),
(3, 'Cola', 2),
(4, 'Water', 1);

-- --------------------------------------------------------

--
-- Table structure for table `merchandise_order`
--

CREATE TABLE IF NOT EXISTS `merchandise_order` (
  `id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `merchandise_id` int(2) DEFAULT NULL,
  `reserve_id` int(5) NOT NULL,
  `amount` int(3) NOT NULL DEFAULT '0',
  `price` double NOT NULL,
  `order_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE IF NOT EXISTS `movie` (
  `id` int(5) NOT NULL,
  `title` varchar(50) NOT NULL,
  `director` varchar(20) NOT NULL,
  `rating` double NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`id`, `title`, `director`, `rating`, `price`) VALUES
(59, 'The Shawshank Redemption', 'Frank Darabont', 9.2, 10),
(60, 'The Godfather', 'Francis Ford Coppola', 9.2, 10),
(61, 'The Godfather: Part II', 'Francis Ford Coppola', 9, 10),
(62, 'The Dark Knight', 'Christopher Nolan', 9, 10),
(63, '12 Angry Men', 'Sidney Lumet', 8.9, 10),
(64, 'Schindler''s List', 'Steven Spielberg', 8.9, 10),
(65, 'The Lord of the Rings: The Return of the King', 'Peter Jackson', 8.9, 10),
(66, 'Pulp Fiction', 'Quentin Tarantino', 8.9, 10),
(67, 'The Good, the Bad and the Ugly', 'Sergio Leone', 8.8, 10),
(68, 'Fight Clu', 'David Fincher', 8.8, 10),
(69, 'The Lord of the Rings: The Fellowship of the Ring', 'Peter Jackson', 8.8, 10),
(70, 'Forrest Gump', 'Robert Zemeckis', 8.7, 10),
(71, 'Star Wars: Episode V - The Empire Strikes Back', 'Irvin Kershner', 8.7, 10),
(72, 'Inception', 'Christopher Nolan', 8.7, 10),
(73, 'The Lord of the Rings: The Two Towers', 'Peter Jackson', 8.7, 10),
(74, 'One Flew Over the Cuckoos Nest', 'Milos Forman', 8.7, 10),
(75, 'Goodfellas', 'Martin Scorsese', 8.7, 10),
(76, 'The Matrix', 'Lana Wachowski', 8.6, 10),
(77, 'Seven Samurai', 'Akira Kurosawa', 8.6, 10),
(78, 'City of God', 'Fernando Meirelles', 8.6, 10),
(79, 'Se7en', 'David Fincher', 8.6, 10),
(80, 'Star Wars: Episode IV - A New Hope', 'George Lucas', 8.6, 10),
(81, 'The Silence of the Lambs', 'Jonathan Demme', 8.6, 10),
(82, 'It''s a Wonderful Life', 'Frank Capra', 8.6, 10),
(83, 'Life Is Beautiful', 'Roberto Benigni', 8.6, 10),
(84, 'The Usual Suspects', 'Bryan Singer', 8.5, 10),
(85, 'Spirited Away', 'Hayao Miyazaki', 8.5, 10),
(86, 'Saving Private Ryan', 'Steven Spielberg', 8.5, 10),
(87, 'Leon: The Professional', 'Luc Besson', 8.5, 10),
(88, 'The Green Mile', 'Frank Darabont', 8.5, 10),
(89, 'Interstellar', 'Christopher Nolan', 8.5, 10),
(90, 'Psycho', 'Alfred Hitchcock', 8.5, 10),
(91, 'American History X', 'Tony Kaye', 8.5, 10),
(92, 'City Lights', 'Charles Chaplin', 8.5, 12),
(93, 'Once Upon a Time in the West', 'Sergio Leone', 8.5, 12),
(94, 'Casablanca', 'Michael Curtiz', 8.5, 12),
(95, 'Modern Times', 'Charles Chaplin', 8.5, 12),
(96, 'The Intouchables', 'Olivier Nakache', 8.5, 12),
(97, 'The Pianist', 'Roman Polanski', 8.5, 12),
(98, 'The Departed', 'Martin Scorsese', 8.5, 12),
(99, 'Terminator 2: Judgment Day', 'James Cameron', 8.5, 12),
(100, 'Back to the Future', 'Robert Zemeckis', 8.5, 12),
(101, 'Whiplash', 'Damien Chazelle', 8.5, 12),
(102, 'Rear Window', 'Alfred Hitchcock', 8.5, 12),
(103, 'Raiders of the Lost Ark', 'Steven Spielberg', 8.5, 12),
(104, 'Gladiator', 'Ridley Scott', 8.5, 12),
(105, 'The Lion King', 'Roger Allers', 8.5, 12),
(106, 'The Prestige', 'Christopher Nolan', 8.5, 12),
(107, 'Apocalypse Now', 'Francis Ford Coppola', 8.4, 12),
(108, 'Memento', 'Christopher Nolan', 8.4, 12),
(109, 'movie1', 'test', 7.1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(5) NOT NULL,
  `scr_id` int(5) NOT NULL,
  `movie_payment` double NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `reserve_time` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `scr_id`, `movie_payment`, `paid`, `reserve_time`) VALUES
(1, 11, 10, 0, '2018-12-03 15:35:03'),
(2, 23, 10, 0, '2018-12-03 15:38:03'),
(3, 20, 20, 0, '2018-12-03 15:40:21'),
(4, 20, 10, 0, '2018-12-03 15:40:39'),
(5, 20, 10, 0, '2018-12-03 15:40:39'),
(6, 20, 10, 0, '2018-12-03 15:43:26'),
(7, 20, 10, 0, '2018-12-03 15:43:26'),
(8, 20, 10, 0, '2018-12-03 15:43:26'),
(9, 20, 10, 0, '2018-12-03 15:47:29'),
(10, 20, 10, 0, '2018-12-03 15:47:29'),
(11, 20, 10, 0, '2018-12-03 15:47:29'),
(12, 20, 30, 0, '2018-12-03 15:51:07'),
(13, 20, 30, 0, '2018-12-03 15:51:07'),
(14, 20, 30, 0, '2018-12-03 15:51:07'),
(15, 20, 30, 0, '2018-12-03 15:55:36'),
(16, 20, 30, 0, '2018-12-03 15:56:52'),
(17, 20, 20, 0, '2018-12-03 15:57:41'),
(18, 1, 10, 1, '2018-12-03 16:01:37'),
(19, 1, 10, 0, '2018-12-03 16:01:45'),
(20, 15, 20, 0, '2018-12-03 21:36:50'),
(21, 9, 10, 0, '2018-12-03 21:45:50'),
(22, 5, 20, 1, '2018-12-03 22:23:27'),
(24, 18, 30, 1, '2018-12-03 22:42:14'),
(25, 14, 20, 1, '2018-12-04 01:55:39'),
(26, 29, 20, 0, '2018-12-04 02:04:27'),
(27, 26, 10, 0, '2018-12-04 14:05:23'),
(28, 11, 30, 0, '2018-12-04 20:03:44');

-- --------------------------------------------------------

--
-- Table structure for table `screening`
--

CREATE TABLE IF NOT EXISTS `screening` (
  `id` int(5) NOT NULL,
  `movie_id` int(5) DEFAULT NULL,
  `aud_id` int(5) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `screening`
--

INSERT INTO `screening` (`id`, `movie_id`, `aud_id`, `start_time`, `end_time`) VALUES
(1, 59, 1, '2018-12-01 09:00:00', '2018-12-01 11:30:00'),
(2, 59, 1, '2018-12-01 14:00:00', '2018-12-01 16:30:00'),
(3, 59, 1, '2018-12-02 09:00:00', '2018-12-02 11:30:00'),
(4, 59, 1, '2018-12-03 09:00:00', '2018-12-03 11:30:00'),
(5, 59, 2, '2018-12-01 09:00:00', '2018-12-01 11:30:00'),
(6, 59, 2, '2018-12-02 09:00:00', '2018-12-02 11:30:00'),
(7, 59, 2, '2018-12-03 09:00:00', '2018-12-03 11:30:00'),
(8, 59, 3, '2018-12-01 09:00:00', '2018-12-01 11:30:00'),
(9, 59, 3, '2018-12-02 09:00:00', '2018-12-02 11:30:00'),
(10, 59, 3, '2018-12-03 09:00:00', '2018-12-03 11:30:00'),
(11, 60, 1, '2018-12-02 18:00:00', '2018-12-02 20:30:00'),
(12, 60, 1, '2018-12-03 18:00:00', '2018-12-03 20:30:00'),
(13, 60, 2, '2018-12-01 18:00:00', '2018-12-01 20:30:00'),
(14, 60, 2, '2018-12-02 18:00:00', '2018-12-02 20:30:00'),
(15, 60, 3, '2018-12-01 18:00:00', '2018-12-01 20:30:00'),
(16, 60, 3, '2018-12-02 18:00:00', '2018-12-02 20:30:00'),
(17, 61, 1, '2018-12-02 21:00:00', '2018-12-02 23:00:00'),
(18, 61, 2, '2018-12-02 21:00:00', '2018-12-02 23:00:00'),
(19, 61, 3, '2018-12-02 21:00:00', '2018-12-02 23:00:00'),
(20, 62, 3, '2018-12-01 21:00:00', '2018-12-01 23:00:00'),
(21, 62, 4, '2018-12-01 21:00:00', '2018-12-01 23:00:00'),
(22, 62, 5, '2018-12-01 21:00:00', '2018-12-01 23:00:00'),
(23, 63, 3, '2018-12-04 21:00:00', '2018-12-04 23:00:00'),
(24, 63, 4, '2018-12-04 21:00:00', '2018-12-04 23:00:00'),
(25, 63, 5, '2018-12-04 21:00:00', '2018-12-04 23:00:00'),
(26, 64, 1, '2018-12-02 14:00:00', '2018-12-02 16:30:00'),
(27, 65, 1, '2018-12-03 14:00:00', '2018-12-03 16:30:00'),
(28, 66, 1, '2018-12-04 14:00:00', '2018-12-04 16:30:00'),
(29, 67, 1, '2018-12-05 14:00:00', '2018-12-05 16:30:00'),
(30, 68, 1, '2018-12-06 09:00:00', '2018-12-06 11:30:00'),
(31, 69, 1, '2018-12-06 14:00:00', '2018-12-06 16:30:00'),
(32, 70, 1, '2018-12-06 21:00:00', '2018-12-06 23:30:00'),
(33, 71, 1, '2018-12-07 09:00:00', '2018-12-07 11:30:00'),
(34, 72, 1, '2018-12-07 14:00:00', '2018-12-07 16:30:00'),
(35, 73, 1, '2018-12-07 21:00:00', '2018-12-07 23:30:00'),
(36, 74, 1, '2018-12-08 09:00:00', '2018-12-08 11:30:00'),
(37, 75, 1, '2018-12-08 14:00:00', '2018-12-08 16:30:00'),
(38, 76, 1, '2018-12-08 21:00:00', '2018-12-08 23:30:00'),
(39, 77, 1, '2018-12-09 09:00:00', '2018-12-09 11:30:00'),
(40, 78, 1, '2018-12-09 14:00:00', '2018-12-09 16:30:00'),
(41, 79, 1, '2018-12-09 21:00:00', '2018-12-09 23:30:00'),
(42, 80, 1, '2018-12-10 09:00:00', '2018-12-10 11:30:00'),
(43, 81, 1, '2018-12-10 14:00:00', '2018-12-10 16:30:00'),
(44, 82, 1, '2018-12-10 21:00:00', '2018-12-10 23:30:00'),
(45, 83, 1, '2018-12-11 09:00:00', '2018-12-11 11:30:00'),
(46, 84, 1, '2018-12-11 14:00:00', '2018-12-11 16:30:00'),
(47, 85, 1, '2018-12-11 21:00:00', '2018-12-11 23:30:00'),
(48, 86, 1, '2018-12-12 09:00:00', '2018-12-12 11:30:00'),
(49, 87, 1, '2018-12-12 14:00:00', '2018-12-12 16:30:00'),
(50, 88, 1, '2018-12-12 21:00:00', '2018-12-12 23:30:00'),
(51, 89, 1, '2018-12-13 09:00:00', '2018-12-13 11:30:00'),
(52, 90, 1, '2018-12-13 14:00:00', '2018-12-13 16:30:00'),
(53, 91, 1, '2018-12-13 21:00:00', '2018-12-13 23:30:00'),
(54, 92, 1, '2018-12-14 09:00:00', '2018-12-14 11:30:00'),
(55, 93, 1, '2018-12-14 14:00:00', '2018-12-14 16:30:00'),
(56, 94, 1, '2018-12-14 21:00:00', '2018-12-14 23:30:00'),
(57, 95, 1, '2018-12-15 09:00:00', '2018-12-15 11:30:00'),
(58, 96, 1, '2018-12-15 14:00:00', '2018-12-15 16:30:00'),
(59, 97, 1, '2018-12-15 21:00:00', '2018-12-15 23:30:00'),
(60, 98, 1, '2018-12-16 09:00:00', '2018-12-16 11:30:00'),
(61, 99, 1, '2018-12-16 14:00:00', '2018-12-16 16:30:00'),
(62, 100, 1, '2018-12-16 21:00:00', '2018-12-16 23:30:00'),
(63, 101, 1, '2018-12-17 14:00:00', '2018-12-17 16:30:00'),
(64, 102, 1, '2018-12-18 14:00:00', '2018-12-18 16:30:00'),
(65, 103, 1, '2018-12-19 14:00:00', '2018-12-19 16:30:00'),
(66, 104, 1, '2018-12-20 14:00:00', '2018-12-20 16:30:00'),
(67, 105, 1, '2018-12-21 14:00:00', '2018-12-21 16:30:00'),
(68, 106, 1, '2018-12-22 14:00:00', '2018-12-22 16:30:00'),
(69, 107, 1, '2018-12-23 14:00:00', '2018-12-23 16:30:00'),
(70, 108, 1, '2018-12-24 14:00:00', '2018-12-24 16:30:00'),
(71, 60, 1, '2018-12-04 09:00:00', '2018-12-04 11:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `seat`
--

CREATE TABLE IF NOT EXISTS `seat` (
  `id` int(5) NOT NULL,
  `row` int(2) NOT NULL,
  `number` int(2) NOT NULL,
  `aud_id` int(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=211 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `seat`
--

INSERT INTO `seat` (`id`, `row`, `number`, `aud_id`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 1, 4, 1),
(5, 1, 5, 1),
(6, 1, 6, 1),
(7, 1, 7, 1),
(8, 1, 8, 1),
(9, 1, 9, 1),
(10, 1, 10, 1),
(11, 2, 1, 1),
(12, 2, 2, 1),
(13, 2, 3, 1),
(14, 2, 4, 1),
(15, 2, 5, 1),
(16, 2, 6, 1),
(17, 2, 7, 1),
(18, 2, 8, 1),
(19, 2, 9, 1),
(20, 2, 10, 1),
(21, 3, 1, 1),
(22, 3, 2, 1),
(23, 3, 3, 1),
(24, 3, 4, 1),
(25, 3, 5, 1),
(26, 3, 6, 1),
(27, 3, 7, 1),
(28, 3, 8, 1),
(29, 3, 9, 1),
(30, 3, 10, 1),
(31, 4, 1, 1),
(32, 4, 2, 1),
(33, 4, 3, 1),
(34, 4, 4, 1),
(35, 4, 5, 1),
(36, 4, 6, 1),
(37, 4, 7, 1),
(38, 4, 8, 1),
(39, 4, 9, 1),
(40, 4, 10, 1),
(41, 5, 1, 1),
(42, 5, 2, 1),
(43, 5, 3, 1),
(44, 5, 4, 1),
(45, 5, 5, 1),
(46, 5, 6, 1),
(47, 5, 7, 1),
(48, 5, 8, 1),
(49, 5, 9, 1),
(50, 5, 10, 1),
(51, 6, 1, 1),
(52, 6, 2, 1),
(53, 6, 3, 1),
(54, 6, 4, 1),
(55, 6, 5, 1),
(56, 6, 6, 1),
(57, 6, 7, 1),
(58, 6, 8, 1),
(59, 6, 9, 1),
(60, 6, 10, 1),
(61, 7, 1, 1),
(62, 7, 2, 1),
(63, 7, 3, 1),
(64, 7, 4, 1),
(65, 7, 5, 1),
(66, 7, 6, 1),
(67, 7, 7, 1),
(68, 7, 8, 1),
(69, 7, 9, 1),
(70, 7, 10, 1),
(71, 1, 1, 2),
(72, 1, 2, 2),
(73, 1, 3, 2),
(74, 1, 4, 2),
(75, 1, 5, 2),
(76, 1, 6, 2),
(77, 1, 7, 2),
(78, 1, 8, 2),
(79, 1, 9, 2),
(80, 1, 10, 2),
(81, 2, 1, 2),
(82, 2, 2, 2),
(83, 2, 3, 2),
(84, 2, 4, 2),
(85, 2, 5, 2),
(86, 2, 6, 2),
(87, 2, 7, 2),
(88, 2, 8, 2),
(89, 2, 9, 2),
(90, 2, 10, 2),
(91, 3, 1, 2),
(92, 3, 2, 2),
(93, 3, 3, 2),
(94, 3, 4, 2),
(95, 3, 5, 2),
(96, 3, 6, 2),
(97, 3, 7, 2),
(98, 3, 8, 2),
(99, 3, 9, 2),
(100, 3, 10, 2),
(101, 4, 1, 2),
(102, 4, 2, 2),
(103, 4, 3, 2),
(104, 4, 4, 2),
(105, 4, 5, 2),
(106, 4, 6, 2),
(107, 4, 7, 2),
(108, 4, 8, 2),
(109, 4, 9, 2),
(110, 4, 10, 2),
(111, 5, 1, 2),
(112, 5, 2, 2),
(113, 5, 3, 2),
(114, 5, 4, 2),
(115, 5, 5, 2),
(116, 5, 6, 2),
(117, 5, 7, 2),
(118, 5, 8, 2),
(119, 5, 9, 2),
(120, 5, 10, 2),
(121, 1, 1, 3),
(122, 1, 2, 3),
(123, 1, 3, 3),
(124, 1, 4, 3),
(125, 1, 5, 3),
(126, 1, 6, 3),
(127, 2, 1, 3),
(128, 2, 2, 3),
(129, 2, 3, 3),
(130, 2, 4, 3),
(131, 2, 5, 3),
(132, 2, 6, 3),
(133, 3, 1, 3),
(134, 3, 2, 3),
(135, 3, 3, 3),
(136, 3, 4, 3),
(137, 3, 5, 3),
(138, 3, 6, 3),
(139, 4, 1, 3),
(140, 4, 2, 3),
(141, 4, 3, 3),
(142, 4, 4, 3),
(143, 4, 5, 3),
(144, 4, 6, 3),
(145, 5, 1, 3),
(146, 5, 2, 3),
(147, 5, 3, 3),
(148, 5, 4, 3),
(149, 5, 5, 3),
(150, 5, 6, 3),
(151, 1, 1, 4),
(152, 1, 2, 4),
(153, 1, 3, 4),
(154, 1, 4, 4),
(155, 1, 5, 4),
(156, 1, 6, 4),
(157, 2, 1, 4),
(158, 2, 2, 4),
(159, 2, 3, 4),
(160, 2, 4, 4),
(161, 2, 5, 4),
(162, 2, 6, 4),
(163, 3, 1, 4),
(164, 3, 2, 4),
(165, 3, 3, 4),
(166, 3, 4, 4),
(167, 3, 5, 4),
(168, 3, 6, 4),
(169, 4, 1, 4),
(170, 4, 2, 4),
(171, 4, 3, 4),
(172, 4, 4, 4),
(173, 4, 5, 4),
(174, 4, 6, 4),
(175, 5, 1, 4),
(176, 5, 2, 4),
(177, 5, 3, 4),
(178, 5, 4, 4),
(179, 5, 5, 4),
(180, 5, 6, 4),
(181, 1, 1, 5),
(182, 1, 2, 5),
(183, 1, 3, 5),
(184, 1, 4, 5),
(185, 1, 5, 5),
(186, 1, 6, 5),
(187, 2, 1, 5),
(188, 2, 2, 5),
(189, 2, 3, 5),
(190, 2, 4, 5),
(191, 2, 5, 5),
(192, 2, 6, 5),
(193, 3, 1, 5),
(194, 3, 2, 5),
(195, 3, 3, 5),
(196, 3, 4, 5),
(197, 3, 5, 5),
(198, 3, 6, 5),
(199, 4, 1, 5),
(200, 4, 2, 5),
(201, 4, 3, 5),
(202, 4, 4, 5),
(203, 4, 5, 5),
(204, 4, 6, 5),
(205, 5, 1, 5),
(206, 5, 2, 5),
(207, 5, 3, 5),
(208, 5, 4, 5),
(209, 5, 5, 5),
(210, 5, 6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `seat_reserve`
--

CREATE TABLE IF NOT EXISTS `seat_reserve` (
  `id` int(5) NOT NULL,
  `reserve_id` int(5) NOT NULL,
  `seat_id` int(5) NOT NULL,
  `scr_id` int(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `seat_reserve`
--

INSERT INTO `seat_reserve` (`id`, `reserve_id`, `seat_id`, `scr_id`) VALUES
(1, 6, 122, 20),
(7, 16, 121, 20),
(9, 16, 123, 20),
(10, 17, 139, 20),
(11, 17, 140, 20),
(12, 18, 1, 1),
(14, 20, 129, 15),
(15, 20, 130, 15),
(16, 21, 141, 9),
(17, 22, 74, 5),
(18, 22, 84, 5),
(19, 24, 95, 18),
(20, 24, 96, 18),
(21, 24, 97, 18),
(22, 25, 105, 14),
(23, 25, 106, 14),
(24, 26, 46, 29),
(25, 26, 47, 29),
(26, 27, 37, 26),
(27, 28, 34, 11),
(28, 28, 35, 11),
(29, 28, 36, 11);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(5) NOT NULL,
  `name` varchar(15) NOT NULL,
  `password` varchar(10) NOT NULL,
  `phone` varchar(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `phone`) VALUES
(1, 'text', '00000', '0000000000'),
(2, 'test1', '000000', ''),
(3, 'test2', 'test2', ''),
(4, 'tr1503', 'Aq010101', '6462438050');

-- --------------------------------------------------------

--
-- Table structure for table `user_reserve`
--

CREATE TABLE IF NOT EXISTS `user_reserve` (
  `id` int(5) NOT NULL,
  `user_id` int(5) DEFAULT NULL,
  `reserve_id` int(5) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_reserve`
--

INSERT INTO `user_reserve` (`id`, `user_id`, `reserve_id`) VALUES
(1, 1, 3),
(2, 1, 4),
(3, 1, 5),
(4, 1, 6),
(5, 1, 7),
(6, 1, 8),
(7, 1, 9),
(8, 1, 10),
(9, 1, 11),
(10, 1, 12),
(11, 1, 13),
(12, 1, 14),
(13, 1, 15),
(14, 1, 16),
(15, 1, 17),
(16, 1, 18),
(17, 1, 19),
(18, 4, 20),
(19, 4, 21),
(20, 4, 22),
(22, 4, 24),
(23, 4, 25),
(24, 4, 26),
(25, 4, 27),
(26, 4, 28);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auditorium`
--
ALTER TABLE `auditorium`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aud_id` (`aud_id`);

--
-- Indexes for table `merchandise`
--
ALTER TABLE `merchandise`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `merchandise_order`
--
ALTER TABLE `merchandise_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merchandise_id` (`merchandise_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `reserve_id` (`reserve_id`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scr_id` (`scr_id`);

--
-- Indexes for table `screening`
--
ALTER TABLE `screening`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `aud_id` (`aud_id`);

--
-- Indexes for table `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aud_id` (`aud_id`);

--
-- Indexes for table `seat_reserve`
--
ALTER TABLE `seat_reserve`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `scr_id_2` (`scr_id`,`seat_id`),
  ADD KEY `reserve_id` (`reserve_id`),
  ADD KEY `seat_id` (`seat_id`),
  ADD KEY `scr_id` (`scr_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_reserve`
--
ALTER TABLE `user_reserve`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `reserve_id` (`reserve_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auditorium`
--
ALTER TABLE `auditorium`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `merchandise`
--
ALTER TABLE `merchandise`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `merchandise_order`
--
ALTER TABLE `merchandise_order`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=110;
--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `screening`
--
ALTER TABLE `screening`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT for table `seat`
--
ALTER TABLE `seat`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=211;
--
-- AUTO_INCREMENT for table `seat_reserve`
--
ALTER TABLE `seat_reserve`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_reserve`
--
ALTER TABLE `user_reserve`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`aud_id`) REFERENCES `auditorium` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `merchandise_order`
--
ALTER TABLE `merchandise_order`
  ADD CONSTRAINT `merchandise_order_ibfk_1` FOREIGN KEY (`merchandise_id`) REFERENCES `merchandise` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `merchandise_order_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `merchandise_order_ibfk_3` FOREIGN KEY (`reserve_id`) REFERENCES `reservation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `seat_reserve_ibfk_2` FOREIGN KEY (`seat_id`) REFERENCES `seat` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `seat_reserve_ibfk_3` FOREIGN KEY (`scr_id`) REFERENCES `screening` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_reserve`
--
ALTER TABLE `user_reserve`
  ADD CONSTRAINT `user_reserve_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_reserve_ibfk_6` FOREIGN KEY (`reserve_id`) REFERENCES `reservation` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
