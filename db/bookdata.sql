-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 17. Jan 2024 um 21:05
-- Server-Version: 8.0.30
-- PHP-Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `bookdata`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookdata`
--

CREATE TABLE `bookdata` (
  `id` int DEFAULT NULL,
  `title` varchar(11) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `price` decimal(4,2) DEFAULT NULL,
  `stock` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `bookdata`
--

INSERT INTO `bookdata` (`id`, `title`, `price`, `stock`) VALUES
(1, 'Y-Solowarm', '6.25', 0),
(2, 'Gembucket', '7.80', 1),
(3, 'Bamity', '31.09', 5),
(4, 'Bamity', '27.15', 2),
(5, 'Bytecard', '11.81', 2),
(6, 'Zoolab', '5.83', 7),
(7, 'Keylex', '30.35', 7),
(8, 'Mat Lam Tam', '24.44', 1),
(9, 'Holdlamis', '10.31', 0),
(10, 'Viva', '15.78', 7),
(11, 'Lotstring', '14.66', 2),
(12, 'Holdlamis', '16.79', 6),
(13, 'Mat Lam Tam', '38.28', 4),
(14, 'Sonair', '9.48', 10),
(15, 'Duobam', '29.27', 7),
(16, 'Overhold', '24.83', 4),
(17, 'Hatity', '5.41', 1),
(18, 'Latlux', '37.97', 8),
(19, 'Cardguard', '26.13', 6),
(20, 'Flexidy', '15.27', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
