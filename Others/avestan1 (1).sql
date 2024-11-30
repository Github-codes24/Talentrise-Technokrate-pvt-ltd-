-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 05, 2022 at 11:31 AM
-- Server version: 8.0.27
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `avestan1`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

DROP TABLE IF EXISTS `contact_us`;
CREATE TABLE IF NOT EXISTS `contact_us` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `sub` varchar(20) NOT NULL,
  `msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`fname`, `email`, `sub`, `msg`) VALUES
('', 'rupal.tale@gmail.com', '', ''),
('rohan', 'rohan@gmail.com', 'maths', 'hiiiii');

-- --------------------------------------------------------

--
-- Table structure for table `hireandroid`
--

DROP TABLE IF EXISTS `hireandroid`;
CREATE TABLE IF NOT EXISTS `hireandroid` (
  `fname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint DEFAULT NULL,
  `e_bd` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `e_msg` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hireandroid`
--

INSERT INTO `hireandroid` (`fname`, `email`, `phno`, `e_bd`, `e_msg`) VALUES
('apple', 'app@dada', 1234567895, '600', 'green apple'),
('apple', 'app@dada', 1234567895, '600', 'green apple'),
('', 'app@dada', 0, '', ''),
('apple', 'app@dada', 1234567895, '600', 'green apple'),
('apple', 'app@dada', 1234567896, '600', 'green apple'),
('Gajendra Shamrao Bansod', 'indianskatingacademy@gmail.com', 2147483647, '77', 'fruhjh'),
('Gajendra Shamrao Bansod', 'indianskatingacademy@gmail.com', 2147483647, '7776', 'fruhjh'),
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 9876545677, '50000', 'hiiiiiii');

-- --------------------------------------------------------

--
-- Table structure for table `hire_ar`
--

DROP TABLE IF EXISTS `hire_ar`;
CREATE TABLE IF NOT EXISTS `hire_ar` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint DEFAULT NULL,
  `e_bd` int DEFAULT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hire_ar`
--

INSERT INTO `hire_ar` (`fname`, `email`, `phno`, `e_bd`, `e_msg`) VALUES
('Sona Babu', 'babu@sona', 1234567892, 2000, 'Bss !'),
('Babu Bhiya', 'bhaiya@babu.com', 2147483647, 2002, 'Nahi');

-- --------------------------------------------------------

--
-- Table structure for table `hire_asp`
--

DROP TABLE IF EXISTS `hire_asp`;
CREATE TABLE IF NOT EXISTS `hire_asp` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint DEFAULT NULL,
  `e_bd` int DEFAULT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hire_asp`
--

INSERT INTO `hire_asp` (`fname`, `email`, `phno`, `e_bd`, `e_msg`) VALUES
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 2147483647, 41242, 'Pese Hi Pese !'),
('Babu Bhiya', 'bhaiya@babu.com', 1234567895, 2000, 'Krooo');

-- --------------------------------------------------------

--
-- Table structure for table `hire_automation`
--

DROP TABLE IF EXISTS `hire_automation`;
CREATE TABLE IF NOT EXISTS `hire_automation` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` int DEFAULT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hire_automation`
--

INSERT INTO `hire_automation` (`fname`, `email`, `phno`, `e_bd`, `e_msg`) VALUES
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 2147483647, 2000, 'me Pagal '),
('Babu Moshai', 'moshai@babu.com', 2147483647, 50000, 'Hence Proved !!!'),
('Babu Moshai', 'moshai@babu.com', 2147483647, 50000, 'Hence Proved !!!'),
('Babu Moshai', 'moshai@babu.com', 2147483647, 50000, 'Hence Proved !!!'),
('Babu Moshai', 'moshai@babu.com', 2147483647, 50000, 'Hence Proved !!!'),
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 2147483647, 123, '');

-- --------------------------------------------------------

--
-- Table structure for table `hire_codeigniter`
--

DROP TABLE IF EXISTS `hire_codeigniter`;
CREATE TABLE IF NOT EXISTS `hire_codeigniter` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hire_codeigniter`
--

INSERT INTO `hire_codeigniter` (`fname`, `email`, `phno`, `e_bd`, `e_msg`) VALUES
('Gajendra Shamrao Bansod', 'indianskatingacademy@gmail.com', 2147483647, '2000', 'Nahi');

-- --------------------------------------------------------

--
-- Table structure for table `hire_django`
--

DROP TABLE IF EXISTS `hire_django`;
CREATE TABLE IF NOT EXISTS `hire_django` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hire_flutter`
--

DROP TABLE IF EXISTS `hire_flutter`;
CREATE TABLE IF NOT EXISTS `hire_flutter` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hire_html5`
--

DROP TABLE IF EXISTS `hire_html5`;
CREATE TABLE IF NOT EXISTS `hire_html5` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hire_ionic`
--

DROP TABLE IF EXISTS `hire_ionic`;
CREATE TABLE IF NOT EXISTS `hire_ionic` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hire_ios`
--

DROP TABLE IF EXISTS `hire_ios`;
CREATE TABLE IF NOT EXISTS `hire_ios` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` int DEFAULT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hire_ios`
--

INSERT INTO `hire_ios` (`fname`, `email`, `phno`, `e_bd`, `e_msg`) VALUES
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 2147483647, 1111, 'this is a show'),
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 2147483647, 1111, 'this is a show'),
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 2147483647, 1111, 'this is a show'),
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 2147483647, 1111, 'this is a show'),
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 2147483647, 1111, 'this is a show'),
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 2147483647, 1111, 'this is a show'),
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 777763985, 1111, 'this is a show'),
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 7658900, 1111, 'this is a show');

-- --------------------------------------------------------

--
-- Table structure for table `hire_java`
--

DROP TABLE IF EXISTS `hire_java`;
CREATE TABLE IF NOT EXISTS `hire_java` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hire_javascript`
--

DROP TABLE IF EXISTS `hire_javascript`;
CREATE TABLE IF NOT EXISTS `hire_javascript` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hire_javascript`
--

INSERT INTO `hire_javascript` (`fname`, `email`, `phno`, `e_bd`, `e_msg`) VALUES
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 2147483647, '23', 'hiii'),
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 8625998582, '23', 'hiii');

-- --------------------------------------------------------

--
-- Table structure for table `hire_kotlin`
--

DROP TABLE IF EXISTS `hire_kotlin`;
CREATE TABLE IF NOT EXISTS `hire_kotlin` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hire_laravel`
--

DROP TABLE IF EXISTS `hire_laravel`;
CREATE TABLE IF NOT EXISTS `hire_laravel` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hire_meteor`
--

DROP TABLE IF EXISTS `hire_meteor`;
CREATE TABLE IF NOT EXISTS `hire_meteor` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hire_meteor`
--

INSERT INTO `hire_meteor` (`fname`, `email`, `phno`, `e_bd`, `e_msg`) VALUES
('Gajendra Shamrao Bansod', 'indianskatingacademy@gmail.com', 777777777, '50000', 'hi');

-- --------------------------------------------------------

--
-- Table structure for table `hire_nodejs`
--

DROP TABLE IF EXISTS `hire_nodejs`;
CREATE TABLE IF NOT EXISTS `hire_nodejs` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hire_php`
--

DROP TABLE IF EXISTS `hire_php`;
CREATE TABLE IF NOT EXISTS `hire_php` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hire_python`
--

DROP TABLE IF EXISTS `hire_python`;
CREATE TABLE IF NOT EXISTS `hire_python` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hire_reactjs`
--

DROP TABLE IF EXISTS `hire_reactjs`;
CREATE TABLE IF NOT EXISTS `hire_reactjs` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hire_reactjs`
--

INSERT INTO `hire_reactjs` (`fname`, `email`, `phno`, `e_bd`, `e_msg`) VALUES
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 2147483647, '123456', 'rupal'),
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 8625998582, '2500', 'rupal'),
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 8625998582, '2000', 'hiiii'),
('rohan', 'rohan@gmail.com', 777765456, '1234', 'hiiiii');

-- --------------------------------------------------------

--
-- Table structure for table `hire_reactnative`
--

DROP TABLE IF EXISTS `hire_reactnative`;
CREATE TABLE IF NOT EXISTS `hire_reactnative` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hire_ror`
--

DROP TABLE IF EXISTS `hire_ror`;
CREATE TABLE IF NOT EXISTS `hire_ror` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hire_ror`
--

INSERT INTO `hire_ror` (`fname`, `email`, `phno`, `e_bd`, `e_msg`) VALUES
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 8625998582, '20000', 'Hi');

-- --------------------------------------------------------

--
-- Table structure for table `hire_software`
--

DROP TABLE IF EXISTS `hire_software`;
CREATE TABLE IF NOT EXISTS `hire_software` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hire_swift`
--

DROP TABLE IF EXISTS `hire_swift`;
CREATE TABLE IF NOT EXISTS `hire_swift` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hire_uiux`
--

DROP TABLE IF EXISTS `hire_uiux`;
CREATE TABLE IF NOT EXISTS `hire_uiux` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hire_vuejs`
--

DROP TABLE IF EXISTS `hire_vuejs`;
CREATE TABLE IF NOT EXISTS `hire_vuejs` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint DEFAULT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hire_vuejs`
--

INSERT INTO `hire_vuejs` (`fname`, `email`, `phno`, `e_bd`, `e_msg`) VALUES
('Gajendra Shamrao Bansod', 'indianskatingacademy@gmail.com', 0, '1234556', 'gajendra'),
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 2147483647, '1234556', 'gajendra'),
('Babu Bhai', 'bhai@babu.com', 1234567895, '2000', 'Bss'),
('Babu Bhai', 'bhai@babu.com', 1234567895, '2000', 'Bss'),
('RUPAL RAMAKANT TALE', 'rupal.tale@gmail.com', 8625998582, '240087', 'hii');

-- --------------------------------------------------------

--
-- Table structure for table `hire_xamarin`
--

DROP TABLE IF EXISTS `hire_xamarin`;
CREATE TABLE IF NOT EXISTS `hire_xamarin` (
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` bigint NOT NULL,
  `e_bd` varchar(20) NOT NULL,
  `e_msg` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
