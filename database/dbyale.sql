-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2022 at 06:34 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbyale`
--

-- --------------------------------------------------------

--
-- Table structure for table `carttb`
--

CREATE TABLE `carttb` (
  `cartID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `transID` varchar(100) NOT NULL,
  `courseName` varchar(100) DEFAULT NULL,
  `coursePrice` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `carttb`
--

INSERT INTO `carttb` (`cartID`, `userID`, `transID`, `courseName`, `coursePrice`) VALUES
(1, 2, '93B026139D917101V', 'Graphic design', 1500),
(2, 3, '45C898291S787920K', 'Photography', 2599),
(3, 3, '45C898291S787920K', 'Sculpture', 1799),
(4, 2, '20117429UH678741A', 'Painting', 2199),
(5, 3, '8XG95165DM7869944', 'Painting', 2199),
(6, 2, '4G078046MW125612E', 'Photography', 2599);

-- --------------------------------------------------------

--
-- Table structure for table `coursetb`
--

CREATE TABLE `coursetb` (
  `courseID` int(11) NOT NULL,
  `courseImage` varchar(100) NOT NULL,
  `courseName` varchar(100) NOT NULL,
  `courseDesc` longtext NOT NULL,
  `coursePrice` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coursetb`
--

INSERT INTO `coursetb` (`courseID`, `courseImage`, `courseName`, `courseDesc`, `coursePrice`) VALUES
(1, 'images\\logo.png', 'Graphic design', 'A studio introduction to visual communication with an emphasis on the visual organization of design elements as a means to transmit meaning and values. Topics include shape, color, visual hierarchy, symbol design, and persuasion. ', 1500),
(2, 'images\\logo.png', 'Painting', 'A broad formal introduction to basic painting issues, including the study of composition, value, color, and pictorial space. Emphasis on observational study. Course work introduces students to technical and historical issues central to the language of painting.', 2199),
(3, 'images\\logo.png', 'Photography', 'An introductory course in the exploration of the transition of photographic processes and techniques into digital formats. A range of tools is presented, including scanning, digital cameras, retouching, color correction, basic composition, and ink-jet printing.', 2599),
(4, 'images\\logo.png', 'Sculpture', 'The concepts of space, form, weight, mass, and design in sculpture are explored and applied through basic techniques of construction and material. Various techniques of gluing and fastening, mass/weight distribution, hanging/mounting, and types of materials are addressed.', 1799);

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(5) NOT NULL,
  `image_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `image_name`) VALUES
(2, 'id1234.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `myuser`
--

CREATE TABLE `myuser` (
  `no` int(5) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `password` varchar(150) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `state` varchar(50) NOT NULL,
  `usertype` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `myuser`
--

INSERT INTO `myuser` (`no`, `first_name`, `last_name`, `email`, `mobile`, `password`, `gender`, `state`, `usertype`) VALUES
(1, 'Admin', 'Yale', 'admin@gmail.com', '+6012-5674893', '$2y$10$7zlf56qnjcu5OJ8ti3NRDeQk6tS7p4ssoGGDIlAQy1Fd.aal/1pji', 'Male', 'Federal Territory of Putrajaya', 'admin'),
(2, 'Stephen', 'Curry', 'ooizhihern123@gmail.com', '+6012-6578908', '$2y$10$jxcGxKgGfY.EE/nhsJV5zuVQwwzvN6xDYqDTOyP9bkDAsFOaOLq92', 'Male', 'Penang', 'user'),
(3, 'Lebron', 'James', '76533@siswa.unimas.my', '+6011-57896543', '$2y$10$Ew7/qzjW2.P/FYQcvQAQkOWa5OOvJRmwlZkN7Nv2nLs.rhMjGfqde', 'Male', 'Perlis', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `transtb`
--

CREATE TABLE `transtb` (
  `orderID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `transID` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `totalAmount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transtb`
--

INSERT INTO `transtb` (`orderID`, `userID`, `transID`, `date`, `totalAmount`) VALUES
(1, 2, '93B026139D917101V', '2022-01-14 08:33:05', 1500),
(2, 3, '45C898291S787920K', '2022-01-15 08:51:17', 4398),
(3, 2, '20117429UH678741A', '2022-01-06 08:54:42', 2199),
(4, 3, '8XG95165DM7869944', '2021-12-28 08:59:01', 2199),
(5, 2, '4G078046MW125612E', '2022-01-08 09:15:26', 2599);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carttb`
--
ALTER TABLE `carttb`
  ADD PRIMARY KEY (`cartID`);

--
-- Indexes for table `coursetb`
--
ALTER TABLE `coursetb`
  ADD PRIMARY KEY (`courseID`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `myuser`
--
ALTER TABLE `myuser`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `transtb`
--
ALTER TABLE `transtb`
  ADD PRIMARY KEY (`orderID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carttb`
--
ALTER TABLE `carttb`
  MODIFY `cartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `coursetb`
--
ALTER TABLE `coursetb`
  MODIFY `courseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `myuser`
--
ALTER TABLE `myuser`
  MODIFY `no` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transtb`
--
ALTER TABLE `transtb`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
