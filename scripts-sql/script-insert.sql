#------------------------------------------------------------
# Insertions
#------------------------------------------------------------

INSERT INTO Genre (libelle) VALUES
	('science-fiction'),
	('Fantasy'),
	('Gangsters'),
	('Thriller'),
	('drame');

INSERT INTO Personnage (id_personnage, nom, prenom, date_naissance, sexe) VALUES
	(1, 'Villeneuve', 'Denis', '1967-10-03','homme'), 
	(2, 'Jackson', 'Peter', '1961-10-31','homme'),
	(3, 'Coppola', 'Francis', '1939-10-31','homme'),
    (4, 'Scott', 'Ridley', '1937-11-30','homme'),
    (5, 'Chalamet', 'Timothée', '1997-01-30','homme'),
    (6, 'Young', 'Sean', '1972-11-12','femme'),
    (7, 'Davis', 'Viola', '1987-07-24','femme'),
    (8, 'Weaver', 'Sigourney', '1949-10-08','femme'),
    (9, 'Eastwood', 'Clint', '1957-02-17','homme'),
	(10, 'Huppert', 'Isabelle', '1953-06-16','femme');

INSERT INTO Acteur (id_acteur, id_personnage) VALUES
	(1, 5),
	(2, 6),
	(3, 7),
	(4, 8),
	(5, 9),
	(6, 10);

INSERT INTO Acteur (id_acteur, id_personnage) VALUES
	(1, 5),
	(2, 6),
	(3, 7),
	(4, 8),
	(5, 9),
	(6, 10);

INSERT INTO Role (id_role, nom) VALUES
	(1, 'Rick Deckard'),
	(2, 'Rachel'),
	(3, 'Paul'),
	(4, 'Ellen'),
	(5, 'Legolas'),
	(6, 'Patricia'),
	(7, 'Ellen Ripley'),
	(8, 'William'),
	(9, 'Samantha');

INSERT INTO Film (id_film, titre, annee_sortie_fr, duree) VALUES
	(1, "Le seigneur des anneaux : la Communauté de l'anneau",'2001',228),
	(2, 'Prisoners','2013',153),
	(3, 'Blade Runner','2019',153),
	(4, 'DUNE','2021',155),
	(5, 'Le Parrain II','1974',112),
	(6, 'Gran Torino','2019',112),
	(7, 'Alien, le huitième passager','1979',117);

INSERT INTO jouer (id_personnage,id_role,id_film) VALUES
	(8,7,7),
	(5,3,4),
	(6,3,4),
	(6,9,3),
	(6,7,7),
	(9,8,6),
	(5,5,1),
	(10,4,2),
	(7,6,2);

INSERT INTO posseder (id_film,id_genre) VALUES
	(1,2),
	(2,4),
	(3,1),
	(4,1),
	(5,3),
	(6,5),
	(7,1);	