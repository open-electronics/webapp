-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 27, 2017 alle 20:20
-- Versione del server: 10.1.21-MariaDB
-- Versione PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webapp`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `relays`
--

CREATE TABLE `relays` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `relays`
--

INSERT INTO `relays` (`id`, `name`, `status`) VALUES
(1, '', 0),
(2, '', 0),
(3, '', 0),
(4, '', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `sensors`
--

CREATE TABLE `sensors` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `eid_relay` int(11) NOT NULL DEFAULT '0',
  `target` int(1) NOT NULL DEFAULT '0',
  `relay_status` int(1) NOT NULL DEFAULT '0',
  `relay_seconds` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `sensors`
--

INSERT INTO `sensors` (`id`, `name`, `eid_relay`, `target`, `relay_status`, `relay_seconds`) VALUES
(1, '', 0, 0, 0, 0),
(2, '', 0, 0, 0, 0),
(3, '', 0, 0, 0, 0),
(4, '', 0, 0, 0, 0);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `relays`
--
ALTER TABLE `relays`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `sensors`
--
ALTER TABLE `sensors`
  ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
