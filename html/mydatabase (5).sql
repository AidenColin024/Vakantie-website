-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jun 26, 2025 at 09:15 AM
-- Server version: 5.7.44
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `Naam` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Wachtwoord` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`Naam`, `Email`, `Wachtwoord`) VALUES
('Aiden', 'aidencolindna@gmail.com', '$2y$10$TPrVkpscvihkVOsO2KbgT.JkVva9LqYmyVONi6GtTji8UML5D3PEW');

-- --------------------------------------------------------

--
-- Table structure for table `annuleren`
--

CREATE TABLE `annuleren` (
  `id` int(11) NOT NULL,
  `hotel` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `reden` text NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `boeking`
--

CREATE TABLE `boeking` (
  `id` int(11) NOT NULL,
  `hotel` varchar(100) NOT NULL,
  `naam` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `aankomst` date NOT NULL,
  `vertrek` date NOT NULL,
  `personen` int(11) NOT NULL,
  `datum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `boeking`
--

INSERT INTO `boeking` (`id`, `hotel`, `naam`, `email`, `aankomst`, `vertrek`, `personen`, `datum`) VALUES
(9, 'BarcelonaCityHotel', 'Aleks', '1208470@student.roc-nijmegen.nl', '2025-06-17', '2025-06-28', 1, '2025-06-17 02:46:47'),
(10, 'ZermattResort', 'Aleks', '1208470@student.roc-nijmegen.nl', '2025-06-19', '2025-06-26', 1, '2025-06-19 09:11:29'),
(11, 'ZermattResort', 'Aiden', 'aidencolindna@gmail.com', '2025-06-19', '2025-06-26', 1, '2025-06-19 09:12:47');

-- --------------------------------------------------------

--
-- Table structure for table `Gebruikers`
--

CREATE TABLE `Gebruikers` (
  `id` int(11) NOT NULL,
  `Naam` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Wachtwoord` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Gebruikers`
--

INSERT INTO `Gebruikers` (`id`, `Naam`, `Email`, `Wachtwoord`) VALUES
(1, 'Aleks', '1208470@student.roc-nijmegen.nl', '$2y$10$Li9/kSOX4viB/LQ2bd2ZI.eAKTdkZKlHQc1hu6nnde..UvnuKVoY.'),
(2, 'Aleks', 'Aleksmerdzhanov58@gmail.com', '$2y$10$.RrCU4CMeQmhU0NcIlcg3O7GMKP6syDq4lJ3ZkCb3NxareMDJa1uu'),
(7, 'Jantje', 'jantje@gmail.com', '$2y$10$zBIrJaKEPgTh.Gxw6l7k2e9knRHWnyvRLQMtxc6bnthwAuEBRWH4.');

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `hotel_naam` varchar(100) NOT NULL,
  `region` varchar(255) NOT NULL,
  `prijs` decimal(10,2) NOT NULL,
  `beschikbaar` date DEFAULT NULL,
  `stars` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `beschrijving` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `hotel_naam`, `region`, `prijs`, `beschikbaar`, `stars`, `type`, `category`, `beschrijving`, `image`) VALUES
(4, 'Frankrijk', 'Les Arcs Chalet', 'Europa', 240.00, '2025-06-26', 3, 'Wintersport', 'ski', 'SKIIIII', 'images/hotels/1750923158_les arcs chalet.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `landen`
--

CREATE TABLE `landen` (
  `id` int(11) NOT NULL,
  `naam` varchar(100) NOT NULL,
  `region` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `landen`
--

INSERT INTO `landen` (`id`, `naam`, `region`) VALUES
(1, 'Frankrijk', 'Europa'),
(4, 'Spanje', 'Europa');

-- --------------------------------------------------------

--
-- Table structure for table `Recensies`
--

CREATE TABLE `Recensies` (
  `Naam` varchar(100) NOT NULL,
  `Recensie` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Reizen`
--

CREATE TABLE `Reizen` (
  `id` int(11) NOT NULL,
  `hotel` int(11) NOT NULL,
  `startdatum` date NOT NULL,
  `einddatum` date NOT NULL,
  `beschikbaarheid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `hotel` varchar(100) NOT NULL,
  `naam` varchar(100) NOT NULL,
  `beoordeling` tinyint(4) NOT NULL,
  `commentaar` text NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `hotel`, `naam`, `beoordeling`, `commentaar`, `datum`) VALUES
(1, 'SalzburgerlandChalet', 'Aleks', 5, 'top', '2025-06-12 08:26:17'),
(2, 'ZermattResort', 'Aleks', 4, 'Top!', '2025-06-19 09:10:34'),
(3, 'Les Arcs Chalet', 'ss', 5, 'ss', '2025-06-26 08:58:21'),
(4, 'Les Arcs Chalet', 'ss', 5, 'ss', '2025-06-26 08:59:47');

-- --------------------------------------------------------

--
-- Table structure for table `Vragen`
--

CREATE TABLE `Vragen` (
  `Naam` varchar(100) NOT NULL,
  `Vraag` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Vragen`
--

INSERT INTO `Vragen` (`Naam`, `Vraag`) VALUES
('Aleks', 'fdsas'),
('test', 'wanneer kunnen we naar asië?'),
('test', 'wanneer noordpool vakantie?'),
('Test', 'Komt de vraag binnen?'),
('Aleks', 'komt deze ook binnen?');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Wachtwoord` (`Wachtwoord`);

--
-- Indexes for table `annuleren`
--
ALTER TABLE `annuleren`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `boeking`
--
ALTER TABLE `boeking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Gebruikers`
--
ALTER TABLE `Gebruikers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Wachtwoord` (`Wachtwoord`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landen`
--
ALTER TABLE `landen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `annuleren`
--
ALTER TABLE `annuleren`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `boeking`
--
ALTER TABLE `boeking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `Gebruikers`
--
ALTER TABLE `Gebruikers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `landen`
--
ALTER TABLE `landen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
