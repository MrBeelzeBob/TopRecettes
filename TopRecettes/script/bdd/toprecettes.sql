-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 24 Avril 2015 à 11:53
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `toprecettes`
--
CREATE DATABASE IF NOT EXISTS `toprecettes` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `toprecettes`;

-- --------------------------------------------------------

--
-- Structure de la table `tuser`
--

CREATE TABLE IF NOT EXISTS `tuser` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `UserPseudo` varchar(20) NOT NULL,
  `UserPassword` varchar(50) NOT NULL,
  `UserEmail` varchar(100) NOT NULL,
  `UserAdmin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idUser`,`UserEmail`),
  UNIQUE KEY `UserPseudo` (`UserPseudo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `tuser`
--

INSERT INTO `tuser` (`idUser`, `UserPseudo`, `UserPassword`, `UserEmail`, `UserAdmin`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
