-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Gegenereerd op: 11 jun 2025 om 12:18
-- Serverversie: 5.7.44
-- PHP-versie: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Reis`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Admin`
--

CREATE TABLE `Admin` (
  `Naam` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Wachtwoord` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `Admin`
--

INSERT INTO `Admin` (`Naam`, `Email`, `Wachtwoord`) VALUES
('Aiden', 'aidencolindna@gmail.com', '$2y$10$0uzv.PRSqhKUn6eoYauy6O.R1e74WOAjW8EJFNc9Qs9UYsfqTI/Yu'),
('Aleks', 'aleksiboi@gmail.com', '$2y$10$qEoSuC3xVWVOWa8E3w1hOO9uid899rkYCx3fr6m5gxU9Yzbsy7ZrW');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Annuleringen`
--

CREATE TABLE `Annuleringen` (
  `id` int(11) NOT NULL,
  `boeking_id` int(11) NOT NULL,
  `reden` text NOT NULL,
  `annuleerdatum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Boekingen`
--

CREATE TABLE `Boekingen` (
  `id` int(11) NOT NULL,
  `klant_id` int(11) NOT NULL,
  `reis_id` int(11) NOT NULL,
  `boekdatum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Hotels`
--

CREATE TABLE `Hotels` (
  `id` int(11) NOT NULL,
  `naam` varchar(100) NOT NULL,
  `land_id` int(11) NOT NULL,
  `sterren` tinyint(4) NOT NULL,
  `locatie` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Klanten`
--

CREATE TABLE `Klanten` (
  `id` int(11) NOT NULL,
  `naam` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `Klanten`
--

INSERT INTO `Klanten` (`id`, `naam`, `email`, `wachtwoord`) VALUES
(1, 'spatje', 'spacolindna@gmail.com', '$2y$10$DPyN1aaF5DSaqjSgkRWlMeRphFHimXNZiqWXpbOBiZPa.MVphiZvC');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Landen`
--

CREATE TABLE `Landen` (
  `id` int(11) NOT NULL,
  `naam` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Recensies`
--

CREATE TABLE `Recensies` (
  `Naam` varchar(100) NOT NULL,
  `Recensie` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Reizen`
--

CREATE TABLE `Reizen` (
  `id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `prijs` decimal(10,2) NOT NULL,
  `startdatum` date NOT NULL,
  `einddatum` date NOT NULL,
  `beschikbaarheid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Vragen`
--

CREATE TABLE `Vragen` (
  `naam` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `bericht` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `Vragen`
--

INSERT INTO `Vragen` (`naam`, `email`, `bericht`) VALUES
('test', '1212500@student.roc-nijmegen.nl', 'waar staan de vragen'),
('test', 'aidencolindna@gmail.com', 'is dit een test?');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `Admin`
--
ALTER TABLE `Admin`
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Wachtwoord` (`Wachtwoord`);

--
-- Indexen voor tabel `Annuleringen`
--
ALTER TABLE `Annuleringen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `boeking_id` (`boeking_id`);

--
-- Indexen voor tabel `Boekingen`
--
ALTER TABLE `Boekingen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reis_id` (`reis_id`),
  ADD KEY `klant_id` (`klant_id`);

--
-- Indexen voor tabel `Hotels`
--
ALTER TABLE `Hotels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `land_id` (`land_id`);

--
-- Indexen voor tabel `Klanten`
--
ALTER TABLE `Klanten`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexen voor tabel `Landen`
--
ALTER TABLE `Landen`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `Reizen`
--
ALTER TABLE `Reizen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexen voor tabel `Vragen`
--
ALTER TABLE `Vragen`
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `Klanten`
--
ALTER TABLE `Klanten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `Annuleringen`
--
ALTER TABLE `Annuleringen`
  ADD CONSTRAINT `Annuleringen_ibfk_1` FOREIGN KEY (`boeking_id`) REFERENCES `Boekingen` (`id`);

--
-- Beperkingen voor tabel `Boekingen`
--
ALTER TABLE `Boekingen`
  ADD CONSTRAINT `Boekingen_ibfk_2` FOREIGN KEY (`reis_id`) REFERENCES `Reizen` (`id`),
  ADD CONSTRAINT `Boekingen_ibfk_3` FOREIGN KEY (`klant_id`) REFERENCES `Klanten` (`id`);

--
-- Beperkingen voor tabel `Hotels`
--
ALTER TABLE `Hotels`
  ADD CONSTRAINT `Hotels_ibfk_1` FOREIGN KEY (`land_id`) REFERENCES `Landen` (`id`);

--
-- Beperkingen voor tabel `Reizen`
--
ALTER TABLE `Reizen`
  ADD CONSTRAINT `Reizen_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `Hotels` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
