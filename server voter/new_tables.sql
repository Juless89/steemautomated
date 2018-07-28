-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 28, 2018 at 07:39 PM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `steemvoter`
--

-- --------------------------------------------------------

--
-- Table structure for table `error_log`
--

CREATE TABLE `error_log` (
  `id` int(11) NOT NULL,
  `voter` varchar(20) NOT NULL,
  `author` varchar(20) NOT NULL,
  `permlink` varchar(200) NOT NULL,
  `weight` int(11) NOT NULL,
  `error` varchar(200) NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vote_log`
--

CREATE TABLE `vote_log` (
  `id` int(11) NOT NULL,
  `voter` varchar(20) NOT NULL,
  `author` varchar(20) NOT NULL,
  `permlink` text NOT NULL,
  `weight` int(11) NOT NULL,
  `voted` varchar(200) NOT NULL DEFAULT 'no',
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vote_queue`
--

CREATE TABLE `vote_queue` (
  `id` int(11) NOT NULL,
  `voter` varchar(20) NOT NULL,
  `author` varchar(20) NOT NULL,
  `permlink` varchar(300) NOT NULL,
  `weight` int(11) NOT NULL,
  `expire_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `error_log`
--
ALTER TABLE `error_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voter` (`voter`);

--
-- Indexes for table `vote_log`
--
ALTER TABLE `vote_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voted` (`voted`);

--
-- Indexes for table `vote_queue`
--
ALTER TABLE `vote_queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voter` (`voter`),
  ADD KEY `expire_on` (`expire_on`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `error_log`
--
ALTER TABLE `error_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `vote_log`
--
ALTER TABLE `vote_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `vote_queue`
--
ALTER TABLE `vote_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
