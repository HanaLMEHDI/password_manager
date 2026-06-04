-- donnees/base.sql

CREATE DATABASE IF NOT EXISTS password_manager;
USE password_manager;

CREATE TABLE IF NOT EXISTS utilisateurs (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    nom          VARCHAR(50)  NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    cree_le      DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS mots_de_passe (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    site           VARCHAR(100) NOT NULL,
    url            VARCHAR(200) DEFAULT '',
    identifiant    VARCHAR(100) NOT NULL,
    mot_de_passe   VARCHAR(255) NOT NULL,
    categorie      ENUM('Tous','Travail','Personnel','Shopping','Favoris') DEFAULT 'Personnel',
    ajoute_le      DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);