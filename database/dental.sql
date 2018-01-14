-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2018 at 08:14 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dental`
--

DELIMITER $$
--
-- Procedures
--
CREATE PROCEDURE `avg_time` (IN `dif` INT)  begin
SET @count := (select patient_count from line);
update line set patient_avg = (patient_avg * @count + dif)/(@count+1);
update line set patient_count = patient_count + 1;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `user_name` varchar(50) DEFAULT NULL,
  `pwd` varchar(50) DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `patient_num` int(11) DEFAULT NULL,
  `online` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`user_name`, `pwd`, `last_update`, `patient_num`, `online`) VALUES
('shehan', '123', '2018-01-07 13:31:53', 0, 1),
('shan', '123', '2018-01-05 19:11:14', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `line`
--

CREATE TABLE `line` (
  `no` int(11) DEFAULT NULL,
  `ischange` int(11) DEFAULT NULL,
  `patient_count` int(11) DEFAULT NULL,
  `patient_avg` float DEFAULT NULL,
  `last_patient_time` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `line`
--

INSERT INTO `line` (`no`, `ischange`, `patient_count`, `patient_avg`, `last_patient_time`) VALUES
(10, 10, 27, 4.18519, '2018-01-07 13:35:09');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `no` int(11) DEFAULT NULL,
  `reg` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`no`, `reg`) VALUES
(1, 202),
(2, 521),
(3, 565),
(4, 654),
(5, 546),
(6, 688),
(7, 568),
(8, 986),
(9, 231),
(10, 216),
(11, 1),
(12, 21),
(13, 65),
(14, 54),
(15, 46),
(16, 88),
(17, 168),
(18, 86),
(19, 232),
(20, 226);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
