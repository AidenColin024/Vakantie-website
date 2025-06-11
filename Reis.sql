-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jun 11, 2025 at 10:03 AM
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
    ('Aiden', 'aidencolindna@gmail.com', 'Kai2007!');

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
-- Table structure for table `Gebruikers`
--

CREATE TABLE `Gebruikers` (
                              `Naam` varchar(100) NOT NULL,
                              `Email` varchar(100) NOT NULL,
                              `Wachtwoord` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Gebruikers`
--

INSERT INTO `Gebruikers` (`Naam`, `Email`, `Wachtwoord`) VALUES
    ('Aiden', 'aidencolindna@gmail.com', '$2y$10$l2lu8C9lvQ36yxzcGU2tFeM4O8I8mSup92y.2KlqREkfYLpEDQcNi');

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE `hotel` (
                         `id` int(11) NOT NULL,
                         `hotel` varchar(255) NOT NULL,
                         `naam` varchar(255) NOT NULL,
                         `email` varchar(255) NOT NULL,
                         `aantal_nachten` int(11) NOT NULL,
                         `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`id`, `hotel`, `naam`, `email`, `aantal_nachten`, `datum`) VALUES
    (1, 'TirolResort', 'Aleks', '1208470@student.roc-nijmegen.nl', 2, '2025-06-11 09:00:18');

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
                          `id` int(11) NOT NULL,
                          `name` varchar(255) NOT NULL,
                          `region` varchar(255) NOT NULL,
                          `stars` int(11) NOT NULL,
                          `type` varchar(255) NOT NULL,
                          `category` varchar(50) NOT NULL,
                          `image` varchar(255) NOT NULL,
                          `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `region`, `stars`, `type`, `category`, `image`, `link`) VALUES
                                                                                                (1, 'Oostenrijk', 'Europa', 5, 'Wintersport', 'ski', 'images/westendorf-drone.webp', 'oostenrijk.php'),
                                                                                                (2, 'Italië', 'Europa', 5, 'Wintersport', 'ski', '', ''),
                                                                                                (3, 'Frankrijk', 'Europa', 5, 'Wintersport', 'ski', '', ''),
                                                                                                (4, 'Zwitserland', 'Europa', 5, 'Wintersport', 'ski', '', '');

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
                          `naam` text NOT NULL,
                          `prijs` int(11) NOT NULL
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

-- --------------------------------------------------------

--
-- Table structure for table `Vragen`
--

CREATE TABLE `Vragen` (
                          `Naam` varchar(100) NOT NULL,
                          `Vraag` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Indexes for table `Gebruikers`
--
ALTER TABLE `Gebruikers`
    ADD UNIQUE KEY `Email` (`Email`),
    ADD UNIQUE KEY `Wachtwoord` (`Wachtwoord`);

--
-- Indexes for table `hotel`
--
ALTER TABLE `hotel`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
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
-- AUTO_INCREMENT for table `hotel`
--
ALTER TABLE `hotel`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
