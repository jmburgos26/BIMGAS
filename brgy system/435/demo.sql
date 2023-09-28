-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2023 at 06:52 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `access`
--

CREATE TABLE `access` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `access`
--

INSERT INTO `access` (`id`, `user_id`, `first_name`, `last_name`, `user_name`, `password`) VALUES
(1, 12345, 'ad', 'ads', 'admin', 'admin'),
(2, 12123, 'asasdaasdasds', 'fasfasf', 'access2', '12345'),
(3, 41414, 'manag', 'adasd', 'access', 'access');

-- --------------------------------------------------------

--
-- Table structure for table `residents`
--

CREATE TABLE `residents` (
  `id` int(225) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `contact` varchar(13) NOT NULL,
  `age` int(5) NOT NULL,
  `birthday` varchar(20) NOT NULL,
  `city` varchar(10) NOT NULL,
  `province` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `residents`
--

INSERT INTO `residents` (`id`, `first_name`, `last_name`, `contact`, `age`, `birthday`, `city`, `province`, `status`) VALUES
(1, 'Austine Jude', 'Mendoza', '', 0, '', '', '', ''),
(2, 'try', '', '', 0, '', '', '', ''),
(10, 'ewan', 'wan', '1313123123', 123, '', '', '', ''),
(11, 'asaDAS', 'SDASD', '1313123123', 213123, '', '', '', ''),
(12, 'asdas', 'asdas', '1313123123', 12, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `filename` varchar(50) NOT NULL,
  `age` int(3) NOT NULL,
  `location` varchar(50) NOT NULL,
  `birthday` varchar(20) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `firstname`, `lastname`, `filename`, `age`, `location`, `birthday`, `user_name`, `password`) VALUES
(16, 226726, 'Naruto', 'Uzamaki', '20230220162519000000.png', 21, 'Hidden Leaf', 'Since Birth', 'naruto@gmail.com', 'naruto'),
(17, 7892, 'Sasuke ', 'Uchiha', '20230220162700000000.png', 21, 'HIdden Leaf', 'Since Birth', 'sasuke@gmail.com', 'sasuke'),
(18, 58625617658339489, 'John ', 'doe', '20230221115537000000.jpg', 69, 'New york Cubao', 'February 22', 'johndoe@gmail.com', 'johndoe'),
(19, 31259773, 'John ', 'Doe', '20230221120225000000.jpg', 69, 'New York Cubao', 'February 22', 'johndoee@gmail.com', 'johndoee'),
(20, 6068529039, 'sadasd', 'asds', '20230221122215000000.jpg', 0, 'dasdas', 'sadasd', 'austine07', 'sdasdasd'),
(21, 76536, 'Judit', 'Mendoza', '20230222031717000000.jpg', 41, 'Laguna', 'December', 'judit@gmail.com', 'judit'),
(22, 399091698117562, 'John ', 'Doe', '20230222065418000000.png', 21, 'Calamba ,laguna', 'Feb 21, 2022', 'johndoe@yahoo.com', 'johndoeee'),
(23, 470535888084, 'sadasd', 'sadasdsa', '20230222070431000000.jpg', 0, 'dasdasd', 'asdasdas', 'johndoe@gmail.com', 'johndoee'),
(26, 39958234380427174, 'Itachi', 'Uchiha', '20230222094533000000.png', 21, 'Hidden Leaf', 'February,21,1976', 'itachi@yahoo.com', 'itachi'),
(27, 398852584567773912, 'Itahi', 'Uchiha', '20230222095252000000.png', 21, 'hidden leaf', 'februart', 'itachi1@yahoo.com', 'itachie'),
(28, 78705323332565110, 'Mark', 'Austria', '20230222100507000000.jpg', 21, 'Batangas', 'August 22, 2001', 'mark@gmail.com', 'markie'),
(29, 6844969312, 'akoay', 'maylobo', '20230511071820000000.png', 12, 'mabahok', 'ausgust', 'akoay', 'maylobo'),
(30, 0, '', '', '', 0, '', '', 'admin', 'admin'),
(31, 66115435663831108, 'austine', 'jude', '20230920074536000000.png', 12, 'adasd', 'januart', 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access`
--
ALTER TABLE `access`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `residents`
--
ALTER TABLE `residents`
  MODIFY `id` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
