-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 17 déc. 2020 à 23:24
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `vehicule`
--

-- --------------------------------------------------------

--
-- Structure de la table `equipes`
--

DROP TABLE IF EXISTS `equipes`;
CREATE TABLE IF NOT EXISTS `equipes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `date_creation` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `equipes`
--

INSERT INTO `equipes` (`id`, `nom`, `date_creation`) VALUES
(1, 'Renault', '2018-11-19 00:00:00'),
(2, 'Audi', '2020-12-14 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `mesures`
--

DROP TABLE IF EXISTS `mesures`;
CREATE TABLE IF NOT EXISTS `mesures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_model` int(11) NOT NULL,
  `type_mesure` enum('Se-Sp','Se-Ap','Ae-Sp','Ae-Ap') NOT NULL,
  `AV_G` float NOT NULL,
  `AV_D` float NOT NULL,
  `AR_G` float NOT NULL,
  `AR_D` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `mesures`
--

INSERT INTO `mesures` (`id`, `id_model`, `type_mesure`, `AV_G`, `AV_D`, `AR_G`, `AR_D`) VALUES
(1, 1, 'Se-Sp', 100, 101, 200, 201),
(4, 1, 'Se-Ap', 165, 166, 265, 266),
(5, 1, 'Ae-Ap', 265, 266, 365, 366),
(6, 1, 'Ae-Sp', 155, 156, 255, 256),
(7, 2, 'Se-Sp', 99, 100, 199, 200),
(8, 2, 'Se-Ap', 164, 165, 264, 265),
(9, 2, 'Ae-Ap', 264, 265, 364, 365),
(10, 2, 'Ae-Sp', 154, 155, 254, 255),
(11, 4, 'Se-Sp', 101, 102, 201, 202),
(12, 4, 'Se-Ap', 166, 167, 266, 267),
(13, 4, 'Ae-Ap', 264, 265, 364, 365),
(14, 4, 'Ae-Sp', 156, 157, 256, 257);

-- --------------------------------------------------------

--
-- Structure de la table `models`
--

DROP TABLE IF EXISTS `models`;
CREATE TABLE IF NOT EXISTS `models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_equipe` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `models`
--

INSERT INTO `models` (`id`, `id_equipe`, `nom`) VALUES
(1, 1, 'Clio 3'),
(2, 1, 'Clio 1'),
(3, 2, 'A1'),
(4, 2, 'S1');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_equipe` int(11) NOT NULL,
  `periode_journee` enum('AM','PM') NOT NULL,
  `date_reservation` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_equipe` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `id_equipe`, `status`, `username`, `password`) VALUES
(1, 1, 2, 'renault.a', 'acd666b817dd25d00b07efc8e7a1ed4677c0a2edc7c15a20f5f3664b7ba35b68'),
(2, 1, 1, 'renault.u', 'acbf3bb418f07fb9bac90355a0d20d2cfe3b6cd249a646cd4a843b9fafdbbd96'),
(3, 2, 2, 'audi.a', '6b1f7409f0f50acb0f1f47287f571b1ff3d0b6d64a5a0cad9a229f6bb081f014'),
(4, 2, 1, 'audi.u', '45092a8731c66446b48c356d42783b7ff0debb109f850ddaec4738af7b03c2f3');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
