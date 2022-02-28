DROP DATABASE IF EXISTS espace_programmeur_db;

create database espace_programmeur_db;

use espace_programmeur_db;

CREATE TABLE Compte (
   email VARCHAR(25) NOT NULL,
   password VARCHAR(25) NOT NULL,
   type ENUM('enseignant', 'programmeur'),
   PRIMARY KEY (email)
);

CREATE TABLE Programmeur (
   id INT NOT NULL AUTO_INCREMENT,
   nom VARCHAR(25) NOT NULL,
   prenom VARCHAR(25) NOT NULL,
   score int DEFAULT 0,
   image_profile VARCHAR(50),
   email VARCHAR(25),
   PRIMARY KEY (id),
   CONSTRAINT fk_compte FOREIGN KEY (email) REFERENCES Compte(email)
);

CREATE TABLE Groupe (
   id INT NOT NULL AUTO_INCREMENT,
   nom VARCHAR(25) NOT NULL,
   creer_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (id)
);

ALTER TABLE Programmeur 
ADD id_groupe INT,
ADD CONSTRAINT fk_groupe FOREIGN KEY (id_groupe) REFERENCES Groupe(id);

/* */

CREATE TABLE Enseignant (
   cin VARCHAR(10) NOT NULL,
   nom VARCHAR(25) NOT NULL,
   prenom VARCHAR(25) NOT NULL,
   image_profile VARCHAR(50),
   langagues JSON NOT NULL,
   email VARCHAR(25),
   PRIMARY KEY (cin),
   CONSTRAINT fk_enseignant_compte FOREIGN KEY (email) REFERENCES Compte(email)
);

CREATE TABLE Email (
   id INT NOT NULL AUTO_INCREMENT,
   objet VARCHAR(50) NOT NULL,
   contenu TEXT,
   creer_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   email_emetteur VARCHAR(25) NOT NULL,
   email_destinataire VARCHAR(25) NOT NULL,
   PRIMARY KEY (id),
   CONSTRAINT fk_email_emetteur FOREIGN KEY (email_emetteur) REFERENCES Compte(email),
   CONSTRAINT fk_email_destinataire FOREIGN KEY (email_destinataire) REFERENCES Compte(email)
);

CREATE TABLE MessagePersonnel (
   id INT NOT NULL AUTO_INCREMENT,
   contenu VARCHAR(255),
   creer_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   id_emetteur INT NOT NULL,
   id_destinataire INT NOT NULL,
   PRIMARY KEY (id),
   CONSTRAINT fk_msg_p_emetteur FOREIGN KEY (id_emetteur) REFERENCES Programmeur(id),
   CONSTRAINT fk_msg_p_destinataire FOREIGN KEY (id_destinataire) REFERENCES Programmeur(id)
);


CREATE TABLE MessageGroupe (
   id INT NOT NULL AUTO_INCREMENT,
   contenu TEXT,
   creer_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   id_emetteur INT NOT NULL,
   id_groupe INT NOT NULL,
   PRIMARY KEY (id),
   CONSTRAINT fk_msg_g_emetteur FOREIGN KEY (id_emetteur) REFERENCES Programmeur(id),
   CONSTRAINT fk_msg_g_groupe FOREIGN KEY (id_groupe) REFERENCES Groupe(id)
);
CREATE TABLE MiniProjet(
   id INT NOT NULL AUTO_INCREMENT,
   titre VARCHAR(50) NOT NULL,
   description TEXT NOT NULL,
   cin_enseignant VARCHAR(10) not NULL,
   PRIMARY KEY (id),
   CONSTRAINT fk_mini_enseignant FOREIGN KEY(cin_enseignant) REFERENCES Enseignant(cin)
);
CREATE TABLE Question(
   id INT NOT NULL AUTO_INCREMENT,
   titre VARCHAR(50) NOT NULL,
   description TEXT NOT NULL,
   id_programmeur int NOT NULL,
   PRIMARY KEY (id),
   CONSTRAINT fk_qst_programmeur FOREIGN KEY(id_programmeur) REFERENCES Programmeur(id)
);
CREATE TABLE Reponse(
   id INT NOT NULL AUTO_INCREMENT,
   description TEXT NOT NULL,
   id_question int Not NULL,
   PRIMARY KEY(id),
   CONSTRAINT fk_rep_question FOREIGN KEY(id_question) REFERENCES Question(id)

);
CREATE TABLE Achievement(
   id INT NOT NULL AUTO_INCREMENT,
   titre VARCHAR(50) NOT NULL,
   description TEXT NOT NULL,
   id_programmeur int NOT NULL,
   PRIMARY KEY (id),
   CONSTRAINT fk_achie_programmeur FOREIGN KEY(id_programmeur) REFERENCES Programmeur(id)

);
CREATE TABLE Commentaire(
   id INT NOT NULL AUTO_INCREMENT,
   description VARCHAR(255) NOT NULL,
   id_achievement int NOT NULL,
   PRIMARY KEY(id),
   CONSTRAINT fk_comm_achievement FOREIGN KEY(id_achievement) REFERENCES Achievement(id)
);


ALTER TABLE Reponse 
ADD id_programmeur INT NOT NULL,
ADD CONSTRAINT fk_rep_id_prog FOREIGN KEY (id_programmeur) REFERENCES Programmeur(id);

/*

INSERT INTO Compte(email, password, type) values ('email1', 'pass1', 'aaa');

*/
- Groupe (id, nom )