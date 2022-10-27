-- a.Informations d’un film(id_film): titre, année, durée (au format HH:MM) et réalisateur
SELECT film.titre, film.annee_sortie_fr, SEC_TO_TIME(duree*60), personnage.prenom, personnage.nom
FROM film
INNER JOIN realisateur ON realisateur.id_realisateur = film.id_realisateur
INNER JOIN personnage ON personnage.id_personnage = realisateur.id_personnage

-- b.Liste des films dont la durée excède 2h15 classés par durée (du plus long au plus court
SELECT film.titre, SEC_TO_TIME(duree*60) AS duree
FROM film
WHERE duree > 135
ORDER BY duree DESC

-- c.Liste des films d’un réalisateur (en précisant l’année de sortie)
SELECT  personnage.prenom, personnage.nom, film.titre, film.annee_sortie_fr
FROM film
INNER JOIN realisateur ON realisateur.id_realisateur = film.id_realisateur
INNER JOIN personnage ON personnage.id_personnage = realisateur.id_personnage

-- d.Nombre de films par genre (classés dans l’ordre décroissant)
SELECT genre.libelle, COUNT(film.id_film) as nb_film
FROM film
INNER JOIN posseder ON posseder.id_film = film.id_film
INNER JOIN genre ON genre.id_genre = posseder.id_genre
GROUP BY genre.id_genre
ORDER BY nb_film DESC

-- e.Nombre de films par réalisateur (classés dans l’ordre décroissant)
SELECT  personnage.prenom, personnage.nom, COUNT(film.id_film) AS nb_film
FROM film
INNER JOIN realisateur ON realisateur.id_realisateur = film.id_realisateur
INNER JOIN personnage ON personnage.id_personnage = realisateur.id_personnage
GROUP BY realisateur.id_realisateur
ORDER BY nb_film DESC

-- f.Casting d’un film en particulier (id_film): nom, prénom des acteurs + sexe
SELECT film.titre, personnage.prenom, personnage.nom, personnage.sexe
FROM film
INNER JOIN jouer ON jouer.id_film = film.id_film
INNER JOIN personnage ON jouer.id_personnage = personnage.id_personnage
WHERE film.id_film = ..

-- g.Films tournés par un acteur en particulier (id_acteur)avec leur rôle et l’année de sortie (du film le plus récent au plus ancien)
SELECT personnage.prenom, personnage.nom, film.titre, role.nom, film.annee_sortie_fr
FROM acteur
INNER JOIN jouer ON acteur.id_personnage = jouer.id_personnage
INNER JOIN role ON role.id_role = jouer.id_role
INNER JOIN personnage ON jouer.id_personnage = personnage.id_personnage
INNER JOIN realisateur ON realisateur.id_personnage = acteur.id_personnage
INNER JOIN film ON film.id_realisateur = realisateur.id_realisateur
WHERE acteur.id_acteur = 5
ORDER BY film.annee_sortie_fr DESC

-- h.Listes des personnes qui sont à la fois acteurs et réalisateurs
SELECT personnage.prenom, personnage.nom
FROM acteur
INNER JOIN jouer ON acteur.id_personnage = jouer.id_personnage
INNER JOIN personnage ON jouer.id_personnage = personnage.id_personnage
INNER JOIN realisateur ON realisateur.id_personnage = acteur.id_personnage
INNER JOIN film ON film.id_realisateur = realisateur.id_realisateur

-- i.Liste des films qui ont moins de 5 ans (classés du plus récent au plus ancien)
SELECT film.titre, film.annee_sortie_fr
FROM film
WHERE film.annee_sortie_fr BETWEEN YEAR(NOW())-5 AND YEAR(NOW())
ORDER BY film.annee_sortie_fr DESC

-- j.Nombre d’hommes et de femmes parmi les acteurs
SELECT personnage.sexe, COUNT(personnage.sexe)
FROM personnage
INNER JOIN acteur ON personnage.id_personnage = acteur.id_personnage
GROUP BY personnage.sexe

-- k.Liste des acteurs ayant plus de 50 ans (âge révolu et non révolu)
SELECT personnage.prenom, personnage.nom, TIMESTAMPDIFF(YEAR, personnage.date_naissance, CURDATE()) AS age
FROM personnage
INNER JOIN acteur ON personnage.id_personnage = acteur.id_personnage
HAVING age >= 50

-- l.Acteurs ayant joué dans 3 films ou plus
SELECT personnage.prenom, personnage.nom
FROM personnage
INNER JOIN acteur ON personnage.id_personnage = acteur.id_personnage
INNER JOIN jouer ON acteur.id_personnage = jouer.id_personnage
INNER JOIN film ON jouer.id_film = film.id_film
GROUP BY personnage.id_personnage
HAVING COUNT(film.id_film) >= 3