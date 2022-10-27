#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------

#------------------------------------------------------------
#  Database : Cinema
#------------------------------------------------------------
CREATE DATABASE IF NOT EXISTS cinema;
USE cinema;
#------------------------------------------------------------
# Table: Personnage
#------------------------------------------------------------

CREATE TABLE Personnage(
        id_personnage  Int  Auto_increment  NOT NULL ,
        nom            Varchar (20) NOT NULL ,
        prenom         Varchar (20) NOT NULL ,
        date_naissance Date NOT NULL
        sexe           Varchar (10) NOT NULL,
	,CONSTRAINT Personnage_PK PRIMARY KEY (id_personnage)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Realisateur
#------------------------------------------------------------

CREATE TABLE Realisateur(
        id_personnage  Int NOT NULL ,
        id_realisateur Int NOT NULL
	,CONSTRAINT Realisateur_PK PRIMARY KEY (id_realisateur)
	,CONSTRAINT Realisateur_Personnage_FK FOREIGN KEY (id_personnage) REFERENCES Personnage(id_personnage)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Film
#------------------------------------------------------------

CREATE TABLE Film(
        id_film         Int  Auto_increment  NOT NULL ,
        titre           Varchar (50) NOT NULL ,
        annee_sortie_fr Date NOT NULL ,
        duree           Int NOT NULL ,
        synopsis        Text ,
        note            TinyINT ,
        affiche         Varchar (50) ,
        id_personnage   Int NOT NULL
	,CONSTRAINT Film_PK PRIMARY KEY (id_film)
	,CONSTRAINT Film_Realisateur_FK FOREIGN KEY (id_personnage) REFERENCES Realisateur(id_personnage)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Acteur
#------------------------------------------------------------

CREATE TABLE Acteur(
        id_personnage  Int NOT NULL ,
        id_acteur      Int NOT NULL
	,CONSTRAINT Acteur_PK PRIMARY KEY (id_acteur)
	,CONSTRAINT Acteur_Personnage_FK FOREIGN KEY (id_personnage) REFERENCES Personnage(id_personnage)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Role
#------------------------------------------------------------

CREATE TABLE Role(
        id_role Int  Auto_increment  NOT NULL ,
        nom     Varchar (20) NOT NULL
	,CONSTRAINT Role_PK PRIMARY KEY (id_role)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Genre
#------------------------------------------------------------

CREATE TABLE Genre(
        id_genre Int  Auto_increment  NOT NULL ,
        libelle  Varchar (20) NOT NULL
	,CONSTRAINT Genre_PK PRIMARY KEY (id_genre)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: jouer
#------------------------------------------------------------

CREATE TABLE jouer(
        id_film       Int NOT NULL ,
        id_role       Int NOT NULL ,
        id_personnage Int NOT NULL
	,CONSTRAINT jouer_PK PRIMARY KEY (id_film,id_role,id_personnage)
	,CONSTRAINT jouer_Film_FK FOREIGN KEY (id_film) REFERENCES Film(id_film)
	,CONSTRAINT jouer_Role0_FK FOREIGN KEY (id_role) REFERENCES Role(id_role)
	,CONSTRAINT jouer_Acteur1_FK FOREIGN KEY (id_personnage) REFERENCES Acteur(id_personnage)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: posseder
#------------------------------------------------------------

CREATE TABLE posseder(
        id_genre Int NOT NULL ,
        id_film  Int NOT NULL
	,CONSTRAINT posseder_PK PRIMARY KEY (id_genre,id_film)
	,CONSTRAINT posseder_Genre_FK FOREIGN KEY (id_genre) REFERENCES Genre(id_genre)
	,CONSTRAINT posseder_Film0_FK FOREIGN KEY (id_film) REFERENCES Film(id_film)
)ENGINE=InnoDB;
