CREATE DATABASE IF NOT EXISTS amazonece;

USE amazonece;

CREATE TABLE IF not EXISTS donnee_bancaire
(
	id_db int PRIMARY key not NULL AUTO_INCREMENT,
	type VARCHAR(255),
	numero_carte int,
	num_affiche VARCHAR(255),
	date_exp DATE,
	code_secur int
);

CREATE TABLE IF not EXISTS adresse
(
	id_ad int PRIMARY key not NULL AUTO_INCREMENT,
	adresse_l1 VARCHAR(255),
	adresse_l2 VARCHAR(255),
	ville VARCHAR(255),
	code_postal int,
	pays VARCHAR(255),
	telephone int
);

CREATE TABLE IF not EXISTS utilisateur
(
    id_user INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(255),
    statut VARCHAR(255),
    mdp VARCHAR(255),
    id_db INT,
    id_ad INT,
    sexe VARCHAR(255),
    date_de_naissance DATE,
    pseudo VARCHAR(255),
    connet INT,
    foreign key(id_db) references donnee_bancaire(id_db),
    foreign key(id_ad) references adresse(id_ad)
);

CREATE TABLE IF not EXISTS acheteur
(
	id_acheteur int PRIMARY key not NULL AUTO_INCREMENT,
	id_panier int,
	id_user int,
    FOREIGN KEY(id_user) references utilisateur(id_user)
);

CREATE TABLE IF not EXISTS vendeur
(
	id_vendeur int PRIMARY key not NULL AUTO_INCREMENT,
	id_stock int,
	id_user int,
    foreign key(id_user) references utilisateur(id_user)
);

CREATE TABLE IF not EXISTS item
(
	id_item int PRIMARY key not NULL AUTO_INCREMENT,
	id_vendeur int,
	id_acheteur int,
	nom VARCHAR(255),
	description VARCHAR(255),
	categorie VARCHAR(255),
	prix_unite int,
	quantite int,
	id_panier INT,
	id_stock INT,
	foreign key(id_vendeur) references vendeur(id_vendeur)
);

CREATE TABLE IF not EXISTS panier
(
	id_panier INT PRIMARY key not null AUTO_INCREMENT,
	nom VARCHAR(255),
	prenom VARCHAR(255),
	quantite int,
	prix_tot int,
	id_user int,
	foreign key(id_user) references utilisateur(id_user)
);

CREATE TABLE if not EXISTS stock
(
	id_stock int PRIMARY key not null AUTO_INCREMENT,
	nom VARCHAR(255),
	prenom VARCHAR(255),
	id_item int,
	id_user int,
	foreign key(id_item) references item(id_item),
	foreign key(id_user) references utilisateur(id_user)
);

CREATE TABLE IF not EXISTS categorie
(
	id_cat int PRIMARY key not null,
	nom VARCHAR(255)
);

/*INSERT INTO `utilisateur`(`nom`, `prenom`, `email`, `statut`, `mdp`, `sexe`, `date_de_naissance`, `pseudo`, `connet`) 
VALUES ("fayol","clement","clemen.fayol@jeece.fr","acheteur","test","man","1998-04-28","clemf","1")
