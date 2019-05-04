-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 02 mai 2019 à 14:43
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

CREATE DATABASE IF NOT EXISTS amazonece;

USE amazonece;
-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

DROP TABLE IF EXISTS `adresse`;
CREATE TABLE IF NOT EXISTS `adresse` (
  `id_ad` int(11) NOT NULL AUTO_INCREMENT,
  `adresse_l1` varchar(255) DEFAULT NULL,
  `adresse_l2` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `code_postal` int(11) UNSIGNED DEFAULT NULL,
  `pays` varchar(255) DEFAULT NULL,
  `telephone` int(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id_ad`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `adresse`
--

INSERT INTO `adresse` (`id_ad`, `adresse_l1`, `adresse_l2`, `ville`, `code_postal`, `pays`, `telephone`) VALUES
(1, 'rue du test1', NULL, 'Paris', 75015, 'France', 697854321),
(2, 'rue du test2', NULL, 'Paris', 75015, 'France', 676540987),
(3, 'rue du test 3', NULL, 'Paris', 75013, 'France', 965473526),
(4, 'rue du test 4', NULL, 'Paris', 75002, 'France', 548763529);

-- --------------------------------------------------------

--
-- Structure de la table `donnee_bancaire`
--

DROP TABLE IF EXISTS `donnee_bancaire`;
CREATE TABLE IF NOT EXISTS `donnee_bancaire` (
  `id_db` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `numero_carte` int(11) UNSIGNED DEFAULT NULL,
  `nom_affiche` varchar(255) DEFAULT NULL,
  `date_exp_mois` int(11) DEFAULT NULL,
  `date_exp_annee` int(11) DEFAULT NULL,
  `code_secur` int(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id_db`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `donnee_bancaire`
--

INSERT INTO `donnee_bancaire` (`id_db`, `type`, `numero_carte`, `nom_affiche`, `date_exp_mois`,`date_exp_annee`, `code_secur`) VALUES
(1, '', NULL, NULL, NULL,NULL, NULL),
(2, '', NULL, NULL, NULL,NULL, NULL),
(3, NULL, NULL, NULL, NULL,NULL, NULL),
(4, '', NULL, NULL, NULL,NULL, NULL);

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
  `prix_unite` int(11) UNSIGNED DEFAULT NULL,
  `quantite` int(11) UNSIGNED DEFAULT NULL,
  `photo` varchar(255)DEFAULT NULL,
  `qty_vendu` int(11) UNSIGNED DEFAULT 0,
  PRIMARY KEY (`id_item`),
  KEY `id_vendeur` (`id_vendeur`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`id_item`, `id_vendeur`, `nom`, `description`, `categorie`, `prix_unite`, `quantite`,`photo`,`qty_vendu`) VALUES
(1, 2, 'Pantalons', 'c', 'vetement', 40, 4,NULL,0),
(2, 2, 'Chaussure', 'c', 'vetement', 40, 4,NULL,0),
(3, 3, 'Doudoune', 'c', 'vetement', 40, 4,NULL,0),
(4, 3, 'Echarpe', 'c', 'vetement', 40, 4,NULL,0),
(5, 2, 'Avenger : Infinity war', 'film', 'divertissement', 40, 4,NULL,0),
(6, 2, 'Club de golf', 'c', 'divertissement', 40, 4,NULL,0),
(7, 2, 'Le petit prince d\'Antoine de Saint-Exupéry', 'c', 'livre', 40, 4,NULL,0),
(8, 3, 'Les Trois Mousquetaires d\'Alexandre Dumas', 'livre', 'livre', 30, 5,NULL,0);

-- --------------------------------------------------------

--
-- Structure de la table `item_variation`
--

DROP TABLE IF EXISTS `item_variation`;
CREATE TABLE IF NOT EXISTS `item_variation` (
  `id_item` int(10) UNSIGNED NOT NULL,
  `num_var_item` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_var_item` varchar(10) NOT NULL,
  KEY `id_item` (`id_item`,`num_var_item`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `item_variation`
--

INSERT INTO `item_variation` (`id_item`, `num_var_item`, `nom_var_item`) VALUES
(4, 1, 'M'),
(4, 2, 'S');

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id_panier` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `prix_tot` int(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id_panier`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id_panier`, `nom`, `prenom`, `prix_tot`) VALUES
(3, 'Brasse', 'Jeremy', 350),
(2, 'Drancy', 'Estelle', 80);

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
  `nom_item` varchar(255) NOT NULL,
  UNIQUE KEY `user_cart` (`id_user`,`id_item`,`id_panier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user_item_panier`
--

INSERT INTO `user_item_panier` (`id_user`, `id_item`, `id_panier`, `qty`, `prix_unitaire`, `prix_total`,`nom_item`) VALUES
(5, 4, 3, 2, 40, 80,'Echarpe'),
(5, 1, 3, 1, 40, 40,'Pantalons'),
(4, 3, 2, 2, 40, 80,'Doudoune'),
(5, 2, 3, 1, 40, 40,'Chaussure'),
(5, 5, 3, 1, 40, 40,'Avenger : Infinity war'),
(5, 6, 3, 2, 40, 80,'Club de golf'),
(5, 7, 3, 1, 40, 40,'Le petit prince d\'Antoine de Saint-Exupéry'),
(5, 8, 3, 1, 30, 30,'Les Trois Mousquetaires d\'Alexandre Dumas ');

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
  `photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  KEY `id_db` (`id_db`),
  KEY `id_ad` (`id_ad`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_user`, `nom`, `prenom`, `email`, `statut`, `mdp`, `id_db`, `id_ad`, `sexe`, `date_de_naissance`, `pseudo`, `connet`, `id_panier`,`photo`) VALUES
(1, 'Admin', 'Admin', 'Administrateur@gmail.fr', 'administrateur', 'Adm1n1strateur', NULL, NULL, NULL, NULL, 'Administrateur', 0, NULL,NULL),
(2, 'Fayol', 'Clement', 'clemen.fayol@gmail.fr', 'vendeur', 'mdpclement', 1, 1, 'man', '1990-10-20', 'ClementF', 0, NULL,NULL),
(3, 'Demas', 'Laure', 'Laure.strmfld@gmail.com', 'vendeur', 'mdpLaure', 2, 2, 'woman', '1998-05-11', 'LaureD', 0, NULL,NULL),
(4, 'Drancy', 'Estelle', 'estelle.drancy@gmail.com', 'acheteur', 'mdpEstelle', 3, 3, 'woman', '1998-10-21', 'EstelleD', 0, 2,NULL),
(5, 'Brasse', 'Jeremy', 'Jeremy.brasse@gmail.com', 'acheteur', 'mdpJeremy', 4, 4, 'man', '1997-06-18', 'JeremyB', 1, 3,NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
