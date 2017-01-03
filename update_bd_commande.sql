CREATE TABLE `commande` (
  `id` int NOT NULL AUTO_INCREMENT,
  `token` int(32) NOT NULL,
  `etat` enum('created','paid','progress','ready','delivered') NOT NULL DEFAULT 'created',
  `nom_client` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `date` date NOT NULL,
  `montant` float(32) NOT NULL,
);
