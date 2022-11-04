-- -------------------------------------------------------------
-- TablePlus 5.1.0(468)
--
-- https://tableplus.com/
--
-- Database: cinema
-- Generation Time: 2022-10-28 09:18:18.9360
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `acteur`;
CREATE TABLE `acteur` (
  `id_acteur` int NOT NULL,
  `id_personnage` int NOT NULL,
  PRIMARY KEY (`id_acteur`),
  KEY `Acteur_Personnage_FK` (`id_personnage`),
  CONSTRAINT `Acteur_Personnage_FK` FOREIGN KEY (`id_personnage`) REFERENCES `personnage` (`id_personnage`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `film`;
CREATE TABLE `film` (
  `id_film` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) NOT NULL,
  `annee_sortie_fr` year NOT NULL,
  `duree` int NOT NULL,
  `synopsis` text,
  `note` tinyint DEFAULT NULL,
  `affiche` varchar(50) DEFAULT NULL,
  `id_realisateur` int NOT NULL,
  PRIMARY KEY (`id_film`),
  KEY `Film_Realisateur_FK` (`id_realisateur`),
  CONSTRAINT `Film_Realisateur_FK` FOREIGN KEY (`id_realisateur`) REFERENCES `realisateur` (`id_personnage`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `genre`;
CREATE TABLE `genre` (
  `id_genre` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(20) NOT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `jouer`;
CREATE TABLE `jouer` (
  `id_film` int NOT NULL,
  `id_role` int NOT NULL,
  `id_acteur` int NOT NULL,
  PRIMARY KEY (`id_film`,`id_role`,`id_acteur`),
  KEY `jouer_Role0_FK` (`id_role`),
  KEY `jouer_Acteur1_FK` (`id_acteur`),
  CONSTRAINT `jouer_Acteur1_FK` FOREIGN KEY (`id_acteur`) REFERENCES `acteur` (`id_acteur`),
  CONSTRAINT `jouer_Film_FK` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `jouer_Role0_FK` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `personnage`;
CREATE TABLE `personnage` (
  `id_personnage` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `date_naissance` date NOT NULL,
  `sexe` varchar(10) NOT NULL,
  PRIMARY KEY (`id_personnage`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `posseder`;
CREATE TABLE `posseder` (
  `id_genre` int NOT NULL,
  `id_film` int NOT NULL,
  PRIMARY KEY (`id_genre`,`id_film`),
  KEY `posseder_Film0_FK` (`id_film`),
  CONSTRAINT `posseder_Film0_FK` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `posseder_Genre_FK` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `realisateur`;
CREATE TABLE `realisateur` (
  `id_personnage` int NOT NULL,
  `id_realisateur` int NOT NULL,
  PRIMARY KEY (`id_realisateur`),
  KEY `id_personnage` (`id_personnage`),
  CONSTRAINT `Realisateur_Personnage_FK` FOREIGN KEY (`id_personnage`) REFERENCES `personnage` (`id_personnage`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO `acteur` (`id_acteur`, `id_personnage`) VALUES
(1, 5),
(2, 6),
(3, 7),
(4, 8),
(5, 9),
(6, 10);

INSERT INTO `film` (`id_film`, `titre`, `annee_sortie_fr`, `duree`, `synopsis`, `note`, `affiche`, `id_realisateur`) VALUES
(1, 'Le seigneur des anneaux : la Communauté de lanneau', '2001', 228, NULL, NULL, NULL, 2),
(2, 'Prisoners', '2013', 153, NULL, NULL, NULL, 1),
(3, 'Blade Runner', '2019', 153, NULL, NULL, NULL, 1),
(4, 'DUNE', '2021', 155, NULL, NULL, NULL, 1),
(5, 'Le Parrain II', '1974', 112, NULL, NULL, NULL, 3),
(6, 'Gran Torino', '2019', 112, NULL, NULL, NULL, 5),
(7, 'Alien, le huitième passager', '1979', 117, NULL, NULL, NULL, 4);

INSERT INTO `genre` (`id_genre`, `libelle`) VALUES
(1, 'science-fiction'),
(2, 'Fantasy'),
(3, 'Gangsters'),
(4, 'Thriller'),
(5, 'drame');

INSERT INTO `jouer` (`id_film`, `id_role`, `id_acteur`) VALUES
(1, 5, 1),
(2, 4, 6),
(2, 6, 3),
(3, 7, 4),
(4, 3, 1),
(4, 3, 2),
(6, 8, 5),
(6, 9, 2),
(7, 7, 2);

INSERT INTO `personnage` (`id_personnage`, `nom`, `prenom`, `date_naissance`, `sexe`) VALUES
(1, 'Villeneuve', 'Denis', '1967-10-03', 'homme'),
(2, 'Jackson', 'Peter', '1961-10-31', 'homme'),
(3, 'Coppola', 'Francis', '1939-10-31', 'homme'),
(4, 'Scott', 'Ridley', '1937-11-30', 'homme'),
(5, 'Chalamet', 'Timothée', '1997-01-30', 'homme'),
(6, 'Young', 'Sean', '1972-11-12', 'femme'),
(7, 'Davis', 'Viola', '1987-07-24', 'femme'),
(8, 'Weaver', 'Sigourney', '1949-10-08', 'femme'),
(9, 'Eastwood', 'Clint', '1957-02-17', 'homme'),
(10, 'Huppert', 'Isabelle', '1953-06-16', 'femme');

INSERT INTO `posseder` (`id_genre`, `id_film`) VALUES
(1, 3),
(1, 4),
(1, 7),
(2, 1),
(3, 5),
(4, 2),
(5, 6);

INSERT INTO `realisateur` (`id_personnage`, `id_realisateur`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(9, 5);

INSERT INTO `role` (`id_role`, `nom`) VALUES
(1, 'Rick Deckard'),
(2, 'Rachel'),
(3, 'Paul'),
(4, 'Ellen'),
(5, 'Legolas'),
(6, 'Patricia'),
(7, 'Ellen Ripley'),
(8, 'William'),
(9, 'Samantha');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;