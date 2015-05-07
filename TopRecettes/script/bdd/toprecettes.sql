-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 07 Mai 2015 à 13:22
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
  `CommentNote` int(11) DEFAULT NULL,
  `CommentDate` datetime NOT NULL,
  `idUser` int(11) NOT NULL DEFAULT '0',
  `idRecipe` int(11) NOT NULL,
  PRIMARY KEY (`idComment`),
  KEY `idUser` (`idUser`),
  KEY `idRecipe` (`idRecipe`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`idComment`, `CommentText`, `CommentNote`, `CommentDate`, `idUser`, `idRecipe`) VALUES
(7, 'jh', 1, '2015-05-07 13:00:17', 5, 1),
(8, 'h', 5, '2015-05-07 13:00:27', 5, 1),
(9, 'asdas', 5, '2015-05-07 13:08:46', 5, 1),
(10, 'hjk', 1, '2015-05-07 13:10:46', 5, 2);

-- --------------------------------------------------------

--
-- Structure de la table `contains`
--

CREATE TABLE IF NOT EXISTS `contains` (
  `idContains` int(11) NOT NULL AUTO_INCREMENT,
  `ContainsQuantity` varchar(30) NOT NULL,
  `idRecipe` int(11) NOT NULL,
  `idIngredient` int(11) NOT NULL,
  PRIMARY KEY (`idContains`),
  KEY `idRecipe` (`idRecipe`,`idIngredient`),
  KEY `idIngredient` (`idIngredient`),
  KEY `idRecipe_2` (`idRecipe`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `contains`
--

INSERT INTO `contains` (`idContains`, `ContainsQuantity`, `idRecipe`, `idIngredient`) VALUES
(1, '2', 1, 292),
(2, '2cuil', 1, 308),
(5, 'uhgvkug', 2, 6),
(6, '2cuil', 2, 300),
(7, 'fghfdgh', 2, 304),
(8, '2', 3, 9),
(9, 'zz', 3, 296),
(10, 'fghfdgh', 3, 12),
(11, 'sdd', 3, 107),
(12, 'fgdsg', 3, 123),
(13, 'f', 4, 119),
(14, 'f', 5, 305),
(15, 'f', 6, 118),
(16, 'yfdsga', 6, 126),
(17, 'f', 6, 300),
(18, 'ijuhioé', 7, 14),
(19, 'nbjké', 7, 299),
(20, 'fgkhdkzd', 7, 302),
(21, 'f', 8, 12),
(22, 'f', 8, 12),
(23, 'f', 8, 12);

-- --------------------------------------------------------

--
-- Structure de la table `tingredient`
--

CREATE TABLE IF NOT EXISTS `tingredient` (
  `idIngredient` int(11) NOT NULL AUTO_INCREMENT,
  `IngredientName` varchar(50) NOT NULL,
  PRIMARY KEY (`idIngredient`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=309 ;

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
(306, 'YAOURT'),
(307, 'CONFITURE AU FROMAGE'),
(308, 'HUILE D''OLIVE');

-- --------------------------------------------------------

--
-- Structure de la table `trecipe`
--

CREATE TABLE IF NOT EXISTS `trecipe` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `trecipe`
--

INSERT INTO `trecipe` (`idRecipe`, `RecipeTitle`, `RecipePreparation`, `RecipeOrigin`, `idType`, `RecipeImage`, `idUser`, `RecipeDate`) VALUES
(1, 'caca', 'dfjkhg kjhg kjhgt kjh', 'italie france', 1, './imgRecettes/554a102de0416.jpg', 1, '2015-05-06'),
(2, 'Lasagnes au riz', 's ljh lkj hlkjh lkjh lkjhlkjh lkjh lkj hlkjh lkj hlkjh lkjh lkj hlkjh lkjh lkj hlkjh', 'espagne turc', 3, './imgRecettes/554b14045923e.jpg', 5, '2015-05-07'),
(3, 'sdr gsdf gdf', 'ydfh dysfg dsrfrg afdg dfgadfgy sfdgs d gsdf gdsgfh', ' sdfg sdrg', 9, './imgRecettes/toprecette.jpg', 5, '2015-05-07'),
(4, 'sdfdsaf sad', ' gfdgjfdxz jst gsh', 'asdfs fdf asdf', 7, './imgRecettes/554b2533f236a.jpg', 5, '2015-05-07'),
(5, 'sfedsdfdf', 'sdf sdf sdf dsf sd fsdf sd', 'gghhggh', 7, './imgRecettes/toprecette.jpg', 5, '2015-05-07'),
(6, 's dthsdfgsdf', 'y fdg fdg dg', ' sdfg dsfgsdf gsd', 9, './imgRecettes/554b25cf6138d.jpg', 5, '2015-05-07'),
(7, ' drjhtesrhz', 'zfrkjrtuotui  ftuik ', 'fhg stfdh et ert hsr  hfdx', 9, './imgRecettes/toprecette.jpg', 5, '2015-05-07'),
(8, 'acacacacacacacaca', ' dfzjs t urset jh jdsfgs', 'acacacacacacacaca', 2, './imgRecettes/toprecette.jpg', 5, '2015-05-07');

-- --------------------------------------------------------

--
-- Structure de la table `ttype`
--

CREATE TABLE IF NOT EXISTS `ttype` (
  `idType` int(11) NOT NULL AUTO_INCREMENT,
  `TypeName` varchar(30) NOT NULL,
  PRIMARY KEY (`idType`),
  UNIQUE KEY `CategoryName` (`TypeName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `ttype`
--

INSERT INTO `ttype` (`idType`, `TypeName`) VALUES
(4, 'Accompagnement'),
(5, 'Amuse-gueule'),
(6, 'Boisson'),
(7, 'Confiserie'),
(9, 'Conseil'),
(1, 'Dessert'),
(2, 'Entrée'),
(3, 'Plat principal'),
(8, 'Sauce');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `tuser`
--

INSERT INTO `tuser` (`idUser`, `UserPseudo`, `UserPassword`, `UserEmail`, `UserAdmin`) VALUES
(1, 'administrateur', 'c4ca4238a0b923820dcc509a6f75849b', 'admin@gmail.com', 1),
(5, 'user', 'c4ca4238a0b923820dcc509a6f75849b', 'user@gmail.com', 0),
(6, 'moiap13', '4fec1940e2bc2b6e835a5372e3b59c7a', 'moiap13@gmail.com', 0),
(7, 'putedusiecle', '8dd01288dd803f549e0c89b78ab743be', 'pute@yopmail.com', 0),
(8, '123', 'c4ca4238a0b923820dcc509a6f75849b', '123@gmail.ch', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
