-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jun 17, 2025 at 09:29 AM
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
(9, 'BarcelonaCityHotel', 'Aleks', '1208470@student.roc-nijmegen.nl', '2025-06-17', '2025-06-28', 1, '2025-06-17 02:46:47');

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
(2, 'Aleks', 'Aleksmerdzhanov58@gmail.com', '$2y$10$.RrCU4CMeQmhU0NcIlcg3O7GMKP6syDq4lJ3ZkCb3NxareMDJa1uu');

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE `hotel` (
  `id` int(11) NOT NULL,
  `hotel` varchar(255) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `aantal_nachten` int(11) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`id`, `hotel`, `naam`, `aantal_nachten`, `datum`) VALUES
(1, 'TirolResort', 'Aleks', 2, '2025-06-11 09:00:18');

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
  `image` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `hotel_naam`, `region`, `prijs`, `beschikbaar`, `stars`, `type`, `category`, `image`, `link`) VALUES
(10, 'Oostenrijk', '', 'Europa', 0.00, NULL, 5, 'Wintersport', 'ski', 'images/westendorf-drone.webp', 'winter/oostenrijk/oostenrijk.php'),
(11, 'Frankrijk', '', 'Europa', 0.00, NULL, 5, 'Wintersport', 'ski', '../../images/wintersport-frankrijk.webp', 'winter/frankrijk/frankrijk.php'),
(12, 'Italie', '', 'Europa', 0.00, NULL, 5, 'Wintersport', 'ski', '../../images/italie.jpg', 'winter/italie/italie.php'),
(13, 'Zwitserland', '', 'Europa', 0.00, NULL, 5, 'Wintersport', 'ski', '../../images/switzerland-zermatt-nl.jpg', 'winter/zwitserland/zwitserland.php'),
(17, 'Oostenrijk', 'Hotel Tirol Lodge', 'Europa', 130.00, '2025-06-17', 4, 'Wintersport', 'ski', '../../images/hotel%20tirol%20lodge.jpg', 'hotel-tirol-lodge.php'),
(19, 'Oostenrijk', 'Tirol Resort', 'Europa', 120.00, '2025-06-17', 4, 'Wintersport', 'ski', '../../images/tyrol%20resort.jpg', 'tirol-resort.php'),
(21, 'Oostenrijk', 'Vorarlberg Lodge', 'Europa', 90.00, '2025-06-17', 3, 'Wintersport', 'ski', '../../images/voralberg lodge.jpg', 'vorarlberg-lodge.php'),
(24, 'Oostenrijk', 'Salzburgerland Chalet', 'Europa', 180.00, '2025-06-17', 5, 'Wintersport', 'ski', '../../images/salzburg%20chalet.jpg', 'salzburgerland-chalet.php'),
(25, 'Zwitserland', 'Berner Hotel Deluxe', 'Europa', 0.00, NULL, 5, 'Wintersport', 'ski', '../../images/berner%20hotel.jpg', 'berner-hotel-deluxe.php'),
(26, 'Spanje', '', 'Europa', 0.00, NULL, 5, 'Zomervakantie', 'zomer', '../../images/OIP4.jpg', 'zomer/spanje/spanje.php'),
(27, 'Griekenland', '', 'Europa', 0.00, NULL, 5, 'Zomervakantie', 'zomer', '../../images/foto-mooie-vakantiebestemming-in-griekenland-met-huizen-en-de-zee-in-de-zomer-hd-vakantie-achtergrond.jpg', 'zomer/griekenland/griekenland.php\r\n'),
(28, 'Morokko', '', 'Noord-Afrika', 0.00, NULL, 5, 'Zomervakantie', 'zomer', '../../images/OIP%20(5).jpg', 'zomer/morokko/morokko.php'),
(29, 'Turkije', '', 'Midden-Oosten', 0.00, NULL, 5, 'Zomervakantie', 'zomer', '../../images/downloads%20(1).jpg', 'zomer/turkije/turkije.php'),
(30, 'Frankrijk', 'Les Arcs Chalet', 'Europa', 80.00, '2025-06-17', 4, 'Wintersport', 'ski', '../../images/les%20arcs%20chalet.jpg', 'les-arcs-chalet.php'),
(31, 'Frankrijk', 'La Plagne Resort', 'Europa', 120.00, '2025-06-17', 5, 'Wintersport', 'ski', '../../images/les%20plagne%20resort.jpg', 'la-plagne-resort.php'),
(32, 'Frankrijk', 'Chalet Mont Blanc', 'Europa', 150.00, '2025-06-17', 5, 'Wintersport', 'ski', '../../images/chalet%20mont%20blanc.jpg', 'chalet-mont-blanc.php'),
(33, 'Frankrijk', 'Serre Chevalier Lodge', 'Europa', 70.00, '2025-06-17', 3, 'Wintersport', 'ski', '../../images/serra%20chavalier%20lodge.webp', 'serre-chevalier-lodge.php'),
(34, 'Italie', 'Dolomieten Chalet', 'Europa', 90.00, '2025-06-17', 4, 'Wintersport', 'ski', '../../images/dolomieten%20lodge.jpg', 'dolomieten-chalet.php'),
(35, 'Italie', 'Val Gardena Resort', 'Europa', 150.00, '2025-06-17', 5, 'Wintersport', 'ski', '../../images/val%20gardana%20resort.jpg', 'val-gardena-resort.php'),
(36, 'Italie', 'Cervinia Lodge', 'Europa', 70.00, '2025-06-17', 3, 'Wintersport', 'ski', '../../images/cervinia%20lodge.jpg', 'cervinia-lodge.php'),
(37, 'Italie', 'Dolomiti Resort', 'Europa', 100.00, '2025-06-17', 4, 'Wintersport', 'ski', '../../images/dolomiti%20resort.jpg', 'dolomiti-resort.php');

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
(1, 'SalzburgerlandChalet', 'Aleks', 5, 'top', '2025-06-12 08:26:17');

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
-- AUTO_INCREMENT for table `boeking`
--
ALTER TABLE `boeking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Gebruikers`
--
ALTER TABLE `Gebruikers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hotel`
--
ALTER TABLE `hotel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
