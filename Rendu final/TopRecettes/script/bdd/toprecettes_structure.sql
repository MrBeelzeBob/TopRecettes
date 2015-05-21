-- Cedric Dos Reis
-- TopRecettes - TPI 2015
-- Structure de la bdd

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
-- Structure de la table `tcomments`
--

CREATE TABLE IF NOT EXISTS `tcomments` (
  `idComment` int(11) NOT NULL AUTO_INCREMENT,
  `CommentText` text NOT NULL,
  `CommentNote` int(11) DEFAULT NULL,
  `CommentDate` datetime NOT NULL,
  `idUser` int(11) NOT NULL DEFAULT '0',
  `idRecipe` int(11) NOT NULL,
  PRIMARY KEY (`idComment`),
  KEY `idUser` (`idUser`),
  KEY `idRecipe` (`idRecipe`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Structure de la table `tcontains`
--

CREATE TABLE IF NOT EXISTS `tcontains` (
  `idContains` int(11) NOT NULL AUTO_INCREMENT,
  `ContainsQuantity` varchar(30) NOT NULL,
  `idRecipe` int(11) NOT NULL,
  `idIngredient` int(11) NOT NULL,
  PRIMARY KEY (`idContains`),
  KEY `idRecipe` (`idRecipe`,`idIngredient`),
  KEY `idIngredient` (`idIngredient`),
  KEY `idRecipe_2` (`idRecipe`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=111 ;

-- --------------------------------------------------------

--
-- Structure de la table `tingredients`
--

CREATE TABLE IF NOT EXISTS `tingredients` (
  `idIngredient` int(11) NOT NULL AUTO_INCREMENT,
  `IngredientName` varchar(50) NOT NULL,
  PRIMARY KEY (`idIngredient`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=314 ;

-- --------------------------------------------------------

--
-- Structure de la table `trecipes`
--

CREATE TABLE IF NOT EXISTS `trecipes` (
  `idRecipe` int(11) NOT NULL AUTO_INCREMENT,
  `RecipeTitle` varchar(50) NOT NULL,
  `RecipePreparation` text NOT NULL COMMENT 'Réalisation de la recette',
  `RecipeOrigin` varchar(30) DEFAULT NULL,
  `idType` int(11) DEFAULT NULL,
  `RecipeImage` varchar(100) NOT NULL DEFAULT './imgRecettes/toprecette.jpg',
  `idUser` int(11) DEFAULT NULL,
  `RecipeDate` date NOT NULL,
  PRIMARY KEY (`idRecipe`),
  KEY `idUser` (`idUser`),
  KEY `idType` (`idType`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Structure de la table `ttypes`
--

CREATE TABLE IF NOT EXISTS `ttypes` (
  `idType` int(11) NOT NULL AUTO_INCREMENT,
  `TypeName` varchar(30) NOT NULL,
  PRIMARY KEY (`idType`),
  UNIQUE KEY `CategoryName` (`TypeName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Structure de la table `tusers`
--

CREATE TABLE IF NOT EXISTS `tusers` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `UserPseudo` varchar(20) NOT NULL,
  `UserPassword` varchar(50) NOT NULL,
  `UserEmail` varchar(100) NOT NULL,
  `UserAdmin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idUser`,`UserEmail`),
  UNIQUE KEY `UserPseudo` (`UserPseudo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
