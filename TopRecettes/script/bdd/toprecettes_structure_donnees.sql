﻿
-- Cedric Dos Reis
-- TopRecettes - TPI 2015
-- Structure et Données de la bdd

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

--
-- Contenu de la table `tcomments`
--

INSERT INTO `tcomments` (`idComment`, `CommentText`, `CommentNote`, `CommentDate`, `idUser`, `idRecipe`) VALUES
(17, 'Délicieux', 5, '2015-05-08 08:39:56', 1, 11),
(20, 'délicieux', 3, '2015-05-08 14:01:01', 1, 9),
(24, 'asas', 1, '2015-05-08 15:32:52', 1, 9);

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

--
-- Contenu de la table `tcontains`
--

INSERT INTO `tcontains` (`idContains`, `ContainsQuantity`, `idRecipe`, `idIngredient`) VALUES
(24, '375 grammes', 9, 118),
(25, '4', 9, 206),
(26, '1 cuillères a soupe', 9, 308),
(27, '50 cl', 9, 156),
(28, '20 g', 9, 26),
(29, '2 pincées', 9, 309),
(61, 'uhgvkug', 0, 5),
(63, 'ss', 15, 11),
(67, '1 kg', 24, 274),
(68, '1 pincée', 24, 309),
(69, '4 cuil à soupe', 24, 308),
(70, '50 g', 24, 26),
(71, '4', 24, 55),
(72, '1.5 kg', 24, 199),
(73, '500 g', 24, 313),
(74, '4', 24, 95),
(75, '1.5 kg', 24, 311),
(76, '2', 24, 208),
(77, '2 gousse', 24, 3),
(78, '140 g', 24, 292),
(79, '1 cuil à café', 24, 148),
(99, 'frais', 11, 21),
(100, '100 g', 11, 26),
(101, '1', 11, 55),
(102, '1', 11, 58),
(103, '250cl', 11, 156),
(104, '1', 11, 208),
(105, '150 g', 11, 270),
(106, '2', 11, 292),
(107, '2 cuil', 11, 308),
(108, '500 g', 11, 310),
(109, '250 g', 11, 311),
(110, '1 pincée', 11, 312);

-- --------------------------------------------------------

--
-- Structure de la table `tingredients`
--

CREATE TABLE IF NOT EXISTS `tingredients` (
  `idIngredient` int(11) NOT NULL AUTO_INCREMENT,
  `IngredientName` varchar(50) NOT NULL,
  PRIMARY KEY (`idIngredient`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=314 ;

--
-- Contenu de la table `tingredients`
--

INSERT INTO `tingredients` (`idIngredient`, `IngredientName`) VALUES
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
(308, 'HUILE D''OLIVE'),
(309, 'SEL'),
(310, 'PÂTE à LASAGNES'),
(311, 'VIANDE DE BOEUF'),
(312, 'POIVRE'),
(313, 'POIS CHICHE');

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

--
-- Contenu de la table `trecipes`
--

INSERT INTO `trecipes` (`idRecipe`, `RecipeTitle`, `RecipePreparation`, `RecipeOrigin`, `idType`, `RecipeImage`, `idUser`, `RecipeDate`) VALUES
(9, 'Crêpes', 'Mélanger la farine avec les oeufs, l''huile et le sel.\r\n\r\nAjoutez ensuite le lait, la bière et le rhum.\r\n\r\nMélangez le tout : c''est prêt en deux minutes avec un mixer !\r\n\r\nFaites cuire à la poêle avec une noix de beurre.', '', 3, './imgRecettes/554b6f7044040.jpg', 9, '2015-05-07'),
(11, 'Lasagnes', 'Faites revenir les échalotes dans le beurre, laisser fondre. \r\n\r\nAjouter le haché et laisser cuire à feu moyen. \r\n\r\nQuand le haché à blanchi, ajouter la boîte de tomates pelées ainsi que le concentré de tomates, remuer et bien mélanger. \r\n\r\nAjouter ensuite le poivron rouge coupé en dés, la carotte en dés, les champignons et l''ail pressée. \r\n\r\nAjouter les épices selon votre goût ainsi que le vin, laisser s''évaporer.\r\n\r\nLaisser mijoter à feux moyen durant 45 min en mélangeant de temps en temps. \r\n\r\nPréparer la sauce béchamel. \r\n\r\nCouper la mozzarella en rondelles très fines. \r\n\r\nDans un plat à gratin, disposer une couche de béchamel, une plaque, une couche de sauce bolognaise, une couche de béchamel, une couche de mozzarella, ainsi de suite... terminer par de la béchamel. \r\n\r\nParsemer de gruyère, de parmesan et de petits morceaux de beurre. \r\n\r\nLaisser gratiner au four à 200°C durant +/- 30 min.\r\n\r\n\r\n\r\nDès que le dessus est bien doré, servir', '', 3, './imgRecettes/554b7a83ea1b0.jpg', 5, '2015-05-07'),
(24, 'Couscous', 'Préparation de la semoule :\n\nVerser la semoule dans un grand récipient et la noyer avec l''eau. Remuer doucement.\n\nÉgoutter la semoule quand l''eau devient blanche\n\nLaisser reposer 15-20 mn (30 maxi), saler (1 cuillère à soupe rase), huiler (1 cuillère à soupe).\n\nMalaxer pour briser les mottes.\n\nCuisson de la semoule :\n\nDans une couscoussière de 5 litres, remplir à moitié d''eau la partie basse et verser la semoule dans la partie haute (ne pas mettre de couvercle).\n\nRendre hermétique si possible la couscoussière au niveau de la jonction des 2 parties afin d''éviter l''évaporation de la vapeur.\n\nCompter une cuisson de 20 min à partir de l''apparition de la vapeur à travers la semoule.\n\nVerser la semoule dans un récipient, remuer doucement avec une cuillère en bois pour briser les mottes, ajouter 50 g de beurre et mélanger doucement.\n\nLégumes et viandes :\n\nMettre dans une grande casserole 3 c à soupe d''huile, faire revenir les 2 oignons, les 2/3 gousses d''ail et faire dorer la viande. Saler, poivrer, ajouter les carottes en rondelles. Laisser cuire à feu doux 15 min.\n\nAjouter le concentré de tomate puis 2 litres d''eau bouillante.\n\nLaisser cuire 20 min.\n\nPendant cet temps, cuire à part dans l''eau salée les navets en morceaux pendant 20 min. Ajouter 5 min avant la fin les courgettes en rondelles. Égoutter en fin de cuisson.\n\nQuand la viande est cuite, y ajouter les navets et courgettes et les pois chiches.\n\nLaisser cuire le tout 5 à 10 min.\n\nAssaisonnement (facultatif) :\n\nRetirer 1 louche du jus de cuisson de la viande, ajouter 1 cuillère à café de harissa. La servir à part.\n', '', 3, './imgRecettes/554c7a3f1a49b.JPG', 5, '2015-05-08'),
(29, 'Spaghettis bolognaise', 'Hachez la sauge, le basilic et le persil.\r\n\r\nHachez les oignons, découpez le céleri en cubes.\r\n\r\nDétaillez les champignons en cubes également.\r\n\r\nFaites chauffer 3 cuillerées à soupe d''huile d''olive dans une cocotte, mettez-y les oignons, le céleri et les champignons.\r\n\r\nAjoutez l''ail écrasé, le concentré de tomate, la sauce tomate, la viande hachée et pressez bien le tout.\r\n\r\nAjoutez alors le thym et le laurier, mouillez de 50 cl d''eau, rajoutez les herbes fraîches hachées, 2 morceaux de sucre, la harissa, assaisonner.\r\n\r\nLaissez mijoter 30 min à feu doux.\r\n\r\n10 minutes avant la fin, faites cuire les pâtes al dente.\r\n\r\nEgouttez-les pâtes, mélangez-les avec un peu de beurre.\r\n\r\nRetirez le laurier de la sauce, versez-la sur les pâtes.\r\n\r\nParsemez de parmesan et servez.', '', 3, './imgRecettes/554cb21cf1223.jpg', 1, '2015-05-08');

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

--
-- Contenu de la table `ttypes`
--

INSERT INTO `ttypes` (`idType`, `TypeName`) VALUES
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

--
-- Contenu de la table `tusers`
--

INSERT INTO `tusers` (`idUser`, `UserPseudo`, `UserPassword`, `UserEmail`, `UserAdmin`) VALUES
(1, 'administrateur', '356a192b7913b04c54574d18c28d46e6395428ab', 'admin@gmail.com', 1),
(5, 'user', '356a192b7913b04c54574d18c28d46e6395428ab', 'user@gmail.com', 0),
(9, 'cedric', '356a192b7913b04c54574d18c28d46e6395428ab', 'cedric@gmail.com', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
