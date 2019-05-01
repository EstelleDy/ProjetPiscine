-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 01 mai 2019 à 15:23
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
-- Base de données :  `amazonece`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

CREATE DATABASE IF NOT EXISTS amazonece;

USE amazonece;

DROP TABLE IF EXISTS `adresse`;
CREATE TABLE IF NOT EXISTS `adresse` (
  `id_ad` int(11) NOT NULL AUTO_INCREMENT,
  `adresse_l1` varchar(255) DEFAULT NULL,
  `adresse_l2` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `code_postal` int(11) DEFAULT NULL,
  `pays` varchar(255) DEFAULT NULL,
  `telephone` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_ad`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `adresse`
--

INSERT INTO `adresse` (`id_ad`, `adresse_l1`, `adresse_l2`, `ville`, `code_postal`, `pays`, `telephone`) VALUES
(1, 'rue du test', NULL, 'Paris', 75000, 'France', 697854321),
(2, 'rue du test', NULL, 'Paris', 75000, 'France', 697854321);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_cat` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `donnee_bancaire`
--

DROP TABLE IF EXISTS `donnee_bancaire`;
CREATE TABLE IF NOT EXISTS `donnee_bancaire` (
  `id_db` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `numero_carte` int(11) DEFAULT NULL,
  `num_affiche` varchar(255) DEFAULT NULL,
  `date_exp` date DEFAULT NULL,
  `code_secur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_db`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `donnee_bancaire`
--

INSERT INTO `donnee_bancaire` (`id_db`, `type`, `numero_carte`, `num_affiche`, `date_exp`, `code_secur`) VALUES
(1, '', NULL, NULL, NULL, NULL),
(2, '', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `id_vendeur` int(11) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `categorie` varchar(255) DEFAULT NULL,
  `prix_unite` int(11) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_item`),
  KEY `id_vendeur` (`id_vendeur`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`id_item`, `id_vendeur`, `nom`, `description`, `categorie`, `prix_unite`, `quantite`, `id_stock`) VALUES
(3, 2, 'chaussure', 'c', 'vetement', 40, 4, 1),
(4, 2, 'chaussure', 'c', 'vetement', 40, 4, 1),
(5, 2, 'chaussure', 'cest une chaussure', 'vetement', 40, 4, 1),
(6, 2, 'chaussure', 'cest une chaussure', 'vetement', 40, 4, 1),
(7, 2, 'pantalon', 'c', 'vetement', 40, 4, 1),
(8, 2, 'pantalon', 'c', 'vetement', 40, 4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id_panier` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `prix_tot` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_panier`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id_panier`, `nom`, `prenom`, `prix_tot`) VALUES
(1, 'test9', 'test2', 120);

-- --------------------------------------------------------

--
-- Structure de la table `user_item_panier`
--

DROP TABLE IF EXISTS `user_item_panier`;
CREATE TABLE IF NOT EXISTS `user_item_panier` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_item` int(10) UNSIGNED NOT NULL,
  `id_panier` int(10) UNSIGNED NOT NULL,
  `qty` int(10) UNSIGNED NOT NULL,
  `prix_unitaire` int(10) UNSIGNED NOT NULL,
  `prix_total` int(10) UNSIGNED NOT NULL,
  UNIQUE KEY `user_cart` (`id_user`,`id_item`,`id_panier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user_item_panier`
--

INSERT INTO `user_item_panier` (`id_user`, `id_item`, `id_panier`, `qty`, `prix_unitaire`, `prix_total`) VALUES
(1, 3, 1, 2, 40, 80),
(1, 5, 1, 1, 40, 40);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `statut` varchar(255) DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  `id_db` int(11) DEFAULT NULL,
  `id_ad` int(11) DEFAULT NULL,
  `sexe` varchar(255) DEFAULT NULL,
  `date_de_naissance` date DEFAULT NULL,
  `pseudo` varchar(255) DEFAULT NULL,
  `connet` int(11) DEFAULT NULL,
  `id_panier` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  KEY `id_db` (`id_db`),
  KEY `id_ad` (`id_ad`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_user`, `nom`, `prenom`, `email`, `statut`, `mdp`, `id_db`, `id_ad`, `sexe`, `date_de_naissance`, `pseudo`, `connet`, `id_panier`) VALUES
(1, 'test9', 'test2', 'testeur@test.fr', 'acheteur', 'mdptest', 1, 1, 'man', '2019-04-04', 'testeur', 1, 1),
(2, 'test', 'test2', 'testeur2@test.fr', 'vendeur', 'mdptest', 2, 2, 'man', '2019-04-04', 'testeur', 0, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
