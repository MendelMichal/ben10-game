-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 03 Lip 2013, 08:18
-- Wersja serwera: 5.1.65
-- Wersja PHP: 5.4.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `ordlbati_ben`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pokemon_gracze`
--

CREATE TABLE IF NOT EXISTS `pokemon_gracze` (
  `gracz` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(24) NOT NULL,
  `haslo` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `avatar` tinyint(4) NOT NULL DEFAULT '0',
  `opis` varchar(100) NOT NULL,
  `akcje` int(11) NOT NULL DEFAULT '100',
  `akcje_max` int(11) NOT NULL DEFAULT '100',
  `vip` int(11) NOT NULL DEFAULT '0',
  `ostatnia_akcja` int(11) NOT NULL DEFAULT '0',
  `kasa` int(11) NOT NULL DEFAULT '1000',
  `zbanowany` tinyint(4) NOT NULL DEFAULT '0',
  `pracuje` int(11) NOT NULL DEFAULT '0',
  `pracuje_godzin` tinyint(4) NOT NULL DEFAULT '0',
  `aktywny_pokemon` int(11) NOT NULL DEFAULT '0',
  `punkty` int(11) NOT NULL DEFAULT '0',
  `misje` int(11) NOT NULL,
  `misje_godzin` int(11) NOT NULL,
  `ref` int(11) NOT NULL,
  `omnitrix` int(11) NOT NULL,
  `aktywny_omnitrix` int(11) NOT NULL,
  `ref_vip` int(11) NOT NULL,
  `misja` int(11) NOT NULL,
  `zabitemaleroboty` int(11) NOT NULL,
  `zabiteduzeroboty` int(11) NOT NULL,
  `zabiteropuchy` int(11) NOT NULL,
  `zabitejonah` int(11) NOT NULL,
  `zabitemegawhatty` int(11) NOT NULL,
  PRIMARY KEY (`gracz`),
  KEY `login` (`login`,`email`),
  KEY `ostatnia_akcja` (`ostatnia_akcja`),
  KEY `zbanowany` (`zbanowany`),
  KEY `punkty` (`punkty`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=384 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pokemon_kody`
--

CREATE TABLE IF NOT EXISTS `pokemon_kody` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kod` varchar(40) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `gracz_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kod` (`kod`),
  KEY `status` (`status`,`gracz_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1999 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pokemon_kody5`
--

CREATE TABLE IF NOT EXISTS `pokemon_kody5` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kod` varchar(40) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `gracz_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kod` (`kod`),
  KEY `status` (`status`,`gracz_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1002 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pokemon_poczta`
--

CREATE TABLE IF NOT EXISTS `pokemon_poczta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `od` int(11) NOT NULL,
  `do` int(11) NOT NULL,
  `tytul` text NOT NULL,
  `tresc` text NOT NULL,
  `data` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `typ` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `od` (`od`),
  KEY `status` (`status`),
  KEY `do` (`do`),
  KEY `typ` (`typ`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1270 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pokemon_pokemony`
--

CREATE TABLE IF NOT EXISTS `pokemon_pokemony` (
  `pokemon` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` text NOT NULL,
  `cena` int(11) NOT NULL,
  `atak` int(11) NOT NULL,
  `obrona` int(11) NOT NULL,
  `obrazenia_min` int(11) NOT NULL,
  `obrazenia_max` int(11) NOT NULL,
  `zycie` int(11) NOT NULL,
  `ewolucjaLvl` int(11) NOT NULL DEFAULT '20',
  `ewolucjaPrzedmiot` int(11) NOT NULL DEFAULT '1',
  `omnitrix` tinyint(4) NOT NULL,
  PRIMARY KEY (`pokemon`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pokemon_pokemony_gracze`
--

CREATE TABLE IF NOT EXISTS `pokemon_pokemony_gracze` (
  `gracz_id` int(11) NOT NULL,
  `pokemon_id` int(11) NOT NULL,
  `nazwa` text NOT NULL,
  `wartosc` int(11) NOT NULL,
  `atak` int(11) NOT NULL,
  `obrona` int(11) NOT NULL,
  `obrazenia_min` int(11) NOT NULL,
  `obrazenia_max` int(11) NOT NULL,
  `zycie` int(11) NOT NULL,
  `zycie_max` int(11) NOT NULL,
  `ostatnia_walka` int(11) NOT NULL DEFAULT '0',
  `exp` int(11) NOT NULL DEFAULT '0',
  `expMax` int(11) NOT NULL DEFAULT '10',
  `lvl` int(11) NOT NULL DEFAULT '1',
  `ewolucjaLvl` int(11) NOT NULL DEFAULT '20',
  `ewolucjaPrzedmiot` int(11) NOT NULL DEFAULT '1',
  `ewol` int(11) NOT NULL,
  KEY `gracz_id` (`gracz_id`,`pokemon_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pokemon_przedmioty_gracze`
--

CREATE TABLE IF NOT EXISTS `pokemon_przedmioty_gracze` (
  `ppid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `aktywny` int(11) NOT NULL,
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pokemon_przedmioty_misje`
--

CREATE TABLE IF NOT EXISTS `pokemon_przedmioty_misje` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` text COLLATE latin1_general_ci NOT NULL,
  `opis` text COLLATE latin1_general_ci NOT NULL,
  `szansa` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
