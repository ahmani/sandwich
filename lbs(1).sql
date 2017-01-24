-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `special` enum('0','1') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `categorie` (`id`, `nom`, `description`, `special`) VALUES
(1,	'salades',	'Nos bonnes salades, fraichement livrées par nos producteurs bios et locaux',	'0'),
(2,	'crudités',	'Nos crudités variées  et préparées avec soin, issues de producteurs locaux et bio pour la plupart.',	'0'),
(3,	'viandes',	'Nos viandes finement découpées et cuites comme vous le préférez. Viande issue d\'élevages certifiés et locaux.',	'1'),
(4,	'Fromages',	'Nos fromages bios et au lait cru. En majorité des AOC.',	'1'),
(5,	'Sauces',	'Toutes les sauces du monde !',	'0');

DROP TABLE IF EXISTS `commande`;
CREATE TABLE `commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` int(32) NOT NULL,
  `etat` enum('created','paid','progress','ready','delivered') COLLATE utf8_bin NOT NULL DEFAULT 'created',
  `nom_client` varchar(64) COLLATE utf8_bin NOT NULL,
  `email` varchar(64) COLLATE utf8_bin NOT NULL,
  `date` date NOT NULL,
  `montant` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `commande` (`id`, `token`, `etat`, `nom_client`, `email`, `date`, `montant`) VALUES
(1,	2147483647,	'created',	'ikram',	'ikram.ahmani@gmail.com',	'0000-00-00',	22);

DROP TABLE IF EXISTS `ingredient`;
CREATE TABLE `ingredient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(64) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `description` text,
  `fournisseur` varchar(128) DEFAULT NULL,
  `img` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ingredient` (`id`, `nom`, `cat_id`, `description`, `fournisseur`, `img`) VALUES
(1,	'laitue',	1,	'belle laitue verte',	'ferme \"la bonne salade\"',	NULL),
(2,	'roquette',	1,	'la roquette qui pète ! bio, bien sur, et sauvage',	'ferme \"la bonne salade\"',	NULL),
(3,	'mâche',	1,	'une mâche toute jeune et croquante',	'ferme \"la bonne salade\"',	NULL),
(4,	'carottes',	2,	'belles carottes bio, rapées avec amour',	'au jardin sauvage',	NULL),
(5,	'concombre',	2,	'concombre de jardin, bio et bien frais',	'au jardin sauvage',	NULL),
(6,	'avocat',	2,	'avocats en direct du Mexique !',	'la huerta bonita, Puebla',	NULL),
(7,	'blanc de poulet',	3,	'blanc de poulet émincé, et grillé comme il faut',	'élevage \"le poulet volant\"',	NULL),
(8,	'magret de canard',	3,	'magret de canard grillé, puis émincé',	'le colvert malin',	NULL),
(9,	'steack haché',	3,	'notre steack haché saveur, 5% MG., préparé juste avant cuisson.\r\nViande de notre producteur local.',	'ferme \"la vache qui plane\"',	NULL),
(10,	'munster',	4,	'Du munster de Munster, en direct. Pour amateurs avertis !',	'fromagerie \"le bon munster de toujours\"',	NULL),
(11,	'chèvre frais',	4,	'un chèvre frais onctueux et goutu !',	'A la chèvre rieuse',	NULL),
(12,	'comté AOC 18mois',	4,	'le meilleur comté du monde !',	'fromagerie du jura',	NULL),
(13,	'vinaigrette huile d\'olive',	5,	'la vinaigrette éternelle, à l\'huile d\'olive et moutarde à l\'ancienne.',	'Le Bon Sandwich',	NULL),
(14,	'salsa jalapeña',	5,	'sauce très légérement pimentée :-)',	'El Yucateco',	NULL),
(15,	'salsa habanera',	5,	'Pour initiés uniquement, dangereux sinon !',	'EL yucateco',	NULL);

DROP TABLE IF EXISTS `ingredient_sandwich`;
CREATE TABLE `ingredient_sandwich` (
  `id_sandwich` int(11) NOT NULL,
  `id_ingredient` int(11) NOT NULL,
  KEY `id_sandwich` (`id_sandwich`),
  KEY `id_ingredient` (`id_ingredient`),
  CONSTRAINT `ingredient_sandwich_ibfk_1` FOREIGN KEY (`id_sandwich`) REFERENCES `sandwich` (`id`),
  CONSTRAINT `ingredient_sandwich_ibfk_2` FOREIGN KEY (`id_ingredient`) REFERENCES `ingredient` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `ingredient_sandwich` (`id_sandwich`, `id_ingredient`) VALUES
(4,	1),
(4,	4),
(4,	7),
(4,	11);

DROP TABLE IF EXISTS `sandwich`;
CREATE TABLE `sandwich` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_size` int(11) NOT NULL,
  `id_type` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_size` (`id_size`),
  KEY `id_type` (`id_type`),
  CONSTRAINT `sandwich_ibfk_1` FOREIGN KEY (`id_size`) REFERENCES `size` (`id`),
  CONSTRAINT `sandwich_ibfk_2` FOREIGN KEY (`id_type`) REFERENCES `type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `sandwich` (`id`, `id_size`, `id_type`) VALUES
(1,	1,	1),
(2,	1,	1),
(3,	1,	1),
(4,	1,	1),
(5,	1,	1),
(6,	1,	1),
(7,	1,	1),
(8,	1,	1),
(9,	1,	1),
(10,	1,	1),
(11,	1,	1),
(12,	1,	1);

DROP TABLE IF EXISTS `size`;
CREATE TABLE `size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8_bin NOT NULL,
  `nb_ingredients` int(11) NOT NULL,
  `nb_special` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `size` (`id`, `nom`, `nb_ingredients`, `nb_special`) VALUES
(1,	'petite faim',	4,	1),
(2,	'moyenne faim',	5,	2),
(3,	'grosse faim',	6,	2),
(4,	'ogre',	7,	3);

DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `type` (`id`, `nom`) VALUES
(1,	'blanc'),
(2,	'complet'),
(3,	'cereales');

-- 2017-01-24 13:53:38
