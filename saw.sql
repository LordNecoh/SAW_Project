-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 25, 2025 alle 15:52
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saw`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `campaign_info`
--

CREATE TABLE `campaign_info` (
  `name` varchar(30) NOT NULL COMMENT 'Specifies what the field is',
  `amount` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Information about the startup crowdFunding';

--
-- Dump dei dati per la tabella `campaign_info`
--

INSERT INTO `campaign_info` (`name`, `amount`) VALUES
('goal', 2000);

-- --------------------------------------------------------

--
-- Struttura della tabella `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `email` varchar(254) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT 0,
  `donation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_user` varchar(254) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `donations`
--

INSERT INTO `donations` (`id`, `email`, `amount`, `public`, `donation_date`, `deleted_user`) VALUES
(40, 'leonardo.necordi@gmail.com', 100.00, 1, '2025-01-25 12:04:43', NULL),
(41, 'luigimangione@gmail.com', 20.00, 1, '2025-01-25 12:05:59', NULL),
(42, 'luigimangione@gmail.com', 5.00, 0, '2025-01-25 12:06:08', NULL),
(43, 'leonardo.necordi@gmail.com', 20.00, 0, '2025-01-25 12:56:29', NULL),
(44, 'leonardo.necordi@gmail.com', 10.00, 0, '2025-01-25 14:49:54', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `email` varchar(254) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `password` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`email`, `firstname`, `lastname`, `username`, `admin`, `password`) VALUES
('leonardo.necordi@gmail.com', 'Leonardo', 'Necordi', 'Necoh', 1, '$2y$10$XE3XrLcaav6xhwRb4S/rP.Ps8ngc7XIvSG09FBZPpueL2U1Us9NsO'),
('luigimangione@gmail.com', 'Luigi', 'Mangione', 'Luigi', 0, '$2y$10$bNgm1Gm9bvkNJe1xLUL/XOexM6WDx/rHz1mY3hdcC36acLkOU0beO');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `campaign_info`
--
ALTER TABLE `campaign_info`
  ADD PRIMARY KEY (`name`);

--
-- Indici per le tabelle `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
