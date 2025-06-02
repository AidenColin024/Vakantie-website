-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Gegenereerd op: 02 jun 2025 om 13:56
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
('Aiden', 'aidencolindna@gmail.com', 'Kai2007!');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Gebruikers`
--

CREATE TABLE `Gebruikers` (
  `Naam` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Wachtwoord` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `Gebruikers`
--

INSERT INTO `Gebruikers` (`Naam`, `Email`, `Wachtwoord`) VALUES
('Aiden', 'aidencolindna@gmail.com', '$2y$10$l2lu8C9lvQ36yxzcGU2tFeM4O8I8mSup92y.2KlqREkfYLpEDQcNi');

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
  `naam` text NOT NULL,
  `prijs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Vragen`
--

CREATE TABLE `Vragen` (
  `Naam` varchar(100) NOT NULL,
  `Vraag` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Indexen voor tabel `Gebruikers`
--
ALTER TABLE `Gebruikers`
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Wachtwoord` (`Wachtwoord`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
