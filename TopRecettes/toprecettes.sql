-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 28 Avril 2015 à 08:29
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
-- Structure de la table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `idComment` int(11) NOT NULL AUTO_INCREMENT,
  `CommentText` text NOT NULL,
  `CommentNote` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idRecipe` int(11) NOT NULL,
  PRIMARY KEY (`idComment`),
  KEY `idUser` (`idUser`,`idRecipe`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `contains`
--

CREATE TABLE IF NOT EXISTS `contains` (
  `idContains` int(11) NOT NULL AUTO_INCREMENT,
  `ContainsQuantity` double NOT NULL,
  `ContainsUnit` varchar(10) NOT NULL,
  `idRecipe` int(11) NOT NULL,
  `idIngredient` int(11) NOT NULL,
  PRIMARY KEY (`idContains`),
  KEY `idRecipe` (`idRecipe`,`idIngredient`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `isin`
--

CREATE TABLE IF NOT EXISTS `isin` (
  `idRecipe` int(11) NOT NULL,
  `idCategory` int(11) NOT NULL,
  KEY `idRecipe` (`idRecipe`,`idCategory`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tcategory`
--

CREATE TABLE IF NOT EXISTS `tcategory` (
  `idCategory` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(30) NOT NULL,
  PRIMARY KEY (`idCategory`),
  UNIQUE KEY `CategoryName` (`CategoryName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `tingredient`
--

CREATE TABLE IF NOT EXISTS `tingredient` (
  `idIngredient` int(11) NOT NULL AUTO_INCREMENT,
  `IngredientName` varchar(50) NOT NULL,
  PRIMARY KEY (`idIngredient`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=307 ;

--
-- Contenu de la table `tingredient`
--

INSERT INTO `tingredient` (`idIngredient`, `IngredientName`) VALUES
(1, 'ABRICOT'),
(2, 'AGNEAU'),
(3, 'AIL'),
(4, 'AIRELLE'),
(5, 'ALGUE'),
(6, 'AMANDE'),
(7, 'ANANAS'),
(8, 'ANCHOIS'),
(9, 'ANETH'),
(10, 'ANGUILLE'),
(11, 'ARMAGNAC'),
(12, 'ARTICHAUT'),
(13, 'ASPERGE'),
(14, 'AUBERGINE'),
(15, 'AUTRUCHE'),
(16, 'AVOCAT'),
(17, 'BACON'),
(18, 'BAGUETTE'),
(19, 'BANANE'),
(20, 'BAR'),
(21, 'BASILIC'),
(22, 'BATAVIA'),
(23, 'BEAUFORT'),
(24, 'BÉCHAMEL'),
(25, 'BETTERAVE'),
(26, 'BEURRE'),
(27, 'BIÈRE'),
(28, 'BISCOTTE'),
(29, 'BISCUIT'),
(30, 'BLÉ'),
(31, 'BLETTE'),
(32, 'BLEU'),
(33, 'BOEUF'),
(34, 'BONBON'),
(35, 'BOUDIN'),
(36, 'BOUQUET GARNI'),
(37, 'BOURBON'),
(38, 'BOURSIN'),
(39, 'BRANDY'),
(40, 'BRIOCHE'),
(41, 'BROCOLI'),
(42, 'CABILLAUD'),
(43, 'CACAHUÈTE'),
(44, 'CACAO'),
(45, 'CAFÉ'),
(46, 'CAILLE'),
(47, 'CALAMAR'),
(48, 'CALVADOS'),
(49, 'CAMEMBERT'),
(50, 'CANARD'),
(51, 'CANNELLE'),
(52, 'CANTAL'),
(53, 'CÂPRE'),
(54, 'CARAMEL'),
(55, 'CAROTTE'),
(56, 'CARPE'),
(57, 'CASSIS'),
(58, 'CÉLERI'),
(59, 'CÈPE'),
(60, 'CERFEUIL'),
(61, 'CERISE'),
(62, 'CHAMPAGNE'),
(63, 'CHAMPIGNON'),
(64, 'CHANTERELLE'),
(65, 'CHAPON'),
(66, 'CHÂTAIGNE'),
(67, 'CHÈVRE'),
(68, 'CHOCOLAT'),
(69, 'CHORIZO'),
(70, 'CHOU'),
(71, 'CHOU-FLEUR'),
(72, 'CIBOULETTE'),
(73, 'CIDRE'),
(74, 'CITRON'),
(75, 'CITROUILLE'),
(76, 'CLÉMENTINE'),
(77, 'CLOU DE GIROFLE'),
(78, 'COCA-COLA'),
(79, 'COEUR DE PALMIER'),
(80, 'COGNAC'),
(81, 'COING'),
(82, 'COINTREAU'),
(83, 'COLIN'),
(84, 'COMPOTE'),
(85, 'COMTÉ'),
(86, 'CONCOMBRE'),
(87, 'CONFITURE'),
(88, 'COQUELET'),
(89, 'COQUILLE SAINT-JACQUES'),
(90, 'COQUILLETTES'),
(91, 'CORIANDRE'),
(92, 'CORN FLAKES'),
(93, 'CORNICHON'),
(94, 'COURGE'),
(95, 'COURGETTE'),
(96, 'COUSCOUS'),
(97, 'CRABE'),
(98, 'CRÈME FRAÎCHE'),
(99, 'CRÊPE'),
(100, 'CRESSON'),
(101, 'CREVETTE'),
(102, 'CROSNE'),
(103, 'CROTTIN DE CHÈVRE'),
(104, 'CUMIN'),
(105, 'CURCUMA'),
(106, 'CURRY'),
(107, 'DATTE'),
(108, 'DAURADE'),
(109, 'DINDE'),
(110, 'EAU DE VIE'),
(111, 'ÉCHALOTE'),
(112, 'EMMENTAL'),
(113, 'ENDIVE'),
(114, 'ÉPINARDS'),
(115, 'ESCALOPE'),
(116, 'ESCARGOT'),
(117, 'ESTRAGON'),
(118, 'FARINE'),
(119, 'FENOUIL'),
(120, 'FETA'),
(121, 'FEUILLE DE BRICK'),
(122, 'FÈVE'),
(123, 'FIGUE'),
(124, 'FOIE GRAS'),
(125, 'FRAISE'),
(126, 'FRAMBOISE'),
(127, 'FROMAGE BLANC'),
(128, 'FROMAGE'),
(129, 'FRUIT DE LA PASSION'),
(130, 'FRUITS DE MER'),
(131, 'GAMBA'),
(132, 'GIBIER'),
(133, 'GIGOT'),
(134, 'GIN'),
(135, 'GINGEMBRE'),
(136, 'GIROLLE'),
(137, 'GLACE'),
(138, 'GOYAVE'),
(139, 'GRAND MARNIER'),
(140, 'GRENADINE'),
(141, 'GRENOUILLE'),
(142, 'GRIOTTE AU SIROP'),
(143, 'GROSEILLE'),
(144, 'GRUYÈRE'),
(145, 'HADDOCK'),
(146, 'HARENG'),
(147, 'HARICOT'),
(148, 'HARISSA'),
(149, 'HOMARD'),
(150, 'HUÎTRE'),
(151, 'JAMBON'),
(152, 'JAMBONNEAU'),
(153, 'JUS'),
(154, 'KIWI'),
(155, 'LAIT DE COCO'),
(156, 'LAIT'),
(157, 'LAITUE'),
(158, 'LANGOUSTE'),
(159, 'LANGOUSTINE'),
(160, 'LAPIN'),
(161, 'LARD'),
(162, 'LARDON'),
(163, 'LASAGNE'),
(164, 'LAURIER'),
(165, 'LENTILLE'),
(166, 'LIEU'),
(167, 'LIÈVRE'),
(168, 'LIMONADE'),
(169, 'LIQUEUR'),
(170, 'LITCHI'),
(171, 'LOTTE'),
(172, 'LOUP'),
(173, 'MACARON'),
(174, 'MACARONI'),
(175, 'MÂCHE'),
(176, 'MAGRET'),
(177, 'MAÏS'),
(178, 'MALIBU'),
(179, 'MANGUE'),
(180, 'MAQUEREAU'),
(181, 'MARRON'),
(182, 'MARSHMALLOW'),
(183, 'MARTINI'),
(184, 'MELON'),
(185, 'MENTHE'),
(186, 'MERGUEZ'),
(187, 'MERLAN'),
(188, 'MERLU'),
(189, 'MIEL'),
(190, 'MIRABELLE'),
(191, 'MORUE'),
(192, 'MOULES'),
(193, 'MOUTON'),
(194, 'MOZZARELLA'),
(195, 'MUNSTER'),
(196, 'MÛRE'),
(197, 'MUSCADE'),
(198, 'MYRTILLE'),
(199, 'NAVET'),
(200, 'NECTAR'),
(201, 'NOISETTE'),
(202, 'NOIX DE CAJOU'),
(203, 'NOIX DE COCO'),
(204, 'NOIX'),
(205, 'NOUGAT'),
(206, 'OEUF'),
(207, 'OIE'),
(208, 'OIGNON'),
(209, 'OLIVE'),
(210, 'ORANGE'),
(211, 'ORIGAN'),
(212, 'OSEILLE'),
(213, 'PAIN'),
(214, 'PAMPLEMOUSSE'),
(215, 'PAPAYE'),
(216, 'PAPRIKA'),
(217, 'PARMESAN'),
(218, 'PASTIS'),
(219, 'PÂTE'),
(220, 'PÂTES'),
(221, 'PÊCHE'),
(222, 'PERSIL'),
(223, 'PETIT SUISSE'),
(224, 'PETITS POIS'),
(225, 'PIGEON'),
(226, 'PIGNON'),
(227, 'PIMENT'),
(228, 'PINEAU'),
(229, 'PINTADE'),
(230, 'POIRE'),
(231, 'POIREAU'),
(232, 'POIS'),
(233, 'POISSON'),
(234, 'POITRINE FUMÉE'),
(235, 'POIVRON'),
(236, 'POMME DE TERRE'),
(237, 'POMME'),
(238, 'PORC'),
(239, 'PORTO'),
(240, 'POTIMARRON'),
(241, 'POULET'),
(242, 'POULPE'),
(243, 'POUSSE DE BAMBOU'),
(244, 'PRUNE'),
(245, 'PRUNEAU'),
(246, 'PURÉE'),
(247, 'RADIS'),
(248, 'RAIE'),
(249, 'RAISIN'),
(250, 'RASCASSE'),
(251, 'RATATOUILLE'),
(252, 'RAVIOLIS'),
(253, 'REBLOCHON'),
(254, 'REINE CLAUDE'),
(255, 'RHUBARBE'),
(256, 'RHUM'),
(257, 'RICOTTA'),
(258, 'RISOTTO'),
(259, 'RIZ'),
(260, 'ROMARIN'),
(261, 'ROQUEFORT'),
(262, 'ROUGET'),
(263, 'RUMSTEAK'),
(264, 'SAFRAN'),
(265, 'SAINT-MORET'),
(266, 'SAINT-NECTAIRE'),
(267, 'SAKÉ'),
(268, 'SALADE'),
(269, 'SARDINE'),
(270, 'SAUCISSE'),
(271, 'SAUCISSON'),
(272, 'SAUMON'),
(273, 'SEICHE'),
(274, 'SEMOULE'),
(275, 'SÉSAME'),
(276, 'SODA'),
(277, 'SOJA'),
(278, 'SOLE'),
(279, 'SORBET'),
(280, 'SPAGHETTI'),
(281, 'SPÉCULAUS'),
(282, 'STEAK'),
(283, 'SUCRE'),
(284, 'SURIMI'),
(285, 'TAGLIATELLE'),
(286, 'TAPENADE'),
(287, 'TEQUILA'),
(288, 'THÉ'),
(289, 'THON'),
(290, 'THYM'),
(291, 'TOFU'),
(292, 'TOMATE'),
(293, 'TOPINAMBOUR'),
(294, 'TOURNEDOS'),
(295, 'TRUFFE'),
(296, 'TRUITE'),
(297, 'TURBOT'),
(298, 'VANILLE'),
(299, 'VEAU'),
(300, 'VERMOUTH'),
(301, 'VIANDE DE GRISON'),
(302, 'VIN'),
(303, 'VODKA'),
(304, 'VOLAILLE'),
(305, 'WHISKY'),
(306, 'YAOURT');

-- --------------------------------------------------------

--
-- Structure de la table `trecipe`
--

CREATE TABLE IF NOT EXISTS `trecipe` (
  `idRecipe` int(11) NOT NULL AUTO_INCREMENT,
  `RecipeTitle` varchar(50) NOT NULL,
  `RecipeContenu` text NOT NULL COMMENT 'Réalisation de la recette',
  `RecipeOrigin` varchar(30) DEFAULT NULL,
  `RecipeImage` varchar(100) NOT NULL,
  PRIMARY KEY (`idRecipe`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `tuser`
--

INSERT INTO `tuser` (`idUser`, `UserPseudo`, `UserPassword`, `UserEmail`, `UserAdmin`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com', 1),
(2, 'User', 'ee11cbb19052e40b07aac0ca060c23ee', 'user@gmail.com', 0),
(3, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'demo@gmail.com', 0);

-- --------------------------------------------------------

--
-- Structure de la table `writes`
--

CREATE TABLE IF NOT EXISTS `writes` (
  `idUser` int(11) NOT NULL,
  `idRecipe` int(11) NOT NULL,
  KEY `idUser` (`idUser`,`idRecipe`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
