-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Úte 03. pro 2013, 19:26
-- Verze MySQL: 5.1.36-community-log
-- Verze PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Databáze: `phpcms`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `contactform`
--

CREATE TABLE IF NOT EXISTS `contactform` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `phone` varchar(64) COLLATE utf8_czech_ci NOT NULL,
  `message` text COLLATE utf8_czech_ci NOT NULL,
  `date` int(11) NOT NULL,
  `jobId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `text` text COLLATE utf8_czech_ci NOT NULL,
  `template` varchar(63) COLLATE utf8_czech_ci NOT NULL,
  `slug` varchar(63) COLLATE utf8_czech_ci NOT NULL,
  `params` text COLLATE utf8_czech_ci NOT NULL,
  `meta` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=2 ;

--
-- Vypisuji data pro tabulku `page`
--

INSERT INTO `page` (`id`, `title`, `text`, `template`, `slug`, `params`, `meta`) VALUES
(1, 'Funguje to!', '<p>Toto je testovací stránka. Zdá se, že funguje!</p>', 'default', '/', 'N;', '');

-- --------------------------------------------------------

--
-- Struktura tabulky `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_czech_ci NOT NULL,
  `role` varchar(32) COLLATE utf8_czech_ci NOT NULL,
  `lastLogin` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=2 ;

--
-- Vypisuji data pro tabulku `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`, `lastLogin`) VALUES
(1, 'phpcms', '5c177f35077e9e0a4a5f7cb4dbc96937', 'admin', '2013-12-03 19:15:09');

