<?php
namespace Controller;
use Model\Connect;

class CinemaController{
    public function homePage(){
        require "view/homepage.php";
    }
    // list of films
    public function listFilms(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query(
            "SELECT titre AS title, annee_sortie_fr AS year, id_film
            FROM film 
            ORDER BY year DESC"
        );

        require "view/listFilms.php";
    }

    // list of actors
    public function listActors(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query(
            "SELECT CONCAT( prenom,' ', nom ) AS complete_name, TIMESTAMPDIFF(YEAR, personnage.date_naissance, CURDATE()) AS age, id_acteur 
             FROM personnage 
             INNER JOIN acteur ON acteur.id_personnage = personnage.id_personnage
             ORDER BY age DESC"
        );

        require "view/listActors.php";
    }

    // list of directors
    public function listDirectors(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query(
            "SELECT CONCAT( prenom, ' ', nom ) AS complete_name, TIMESTAMPDIFF(YEAR, personnage.date_naissance, CURDATE()) AS age, id_realisateur
             FROM personnage
             INNER JOIN realisateur ON realisateur.id_personnage = personnage.id_personnage
             ORDER BY age DESC"
        );

        require "view/listDirectors.php";
    }

    // details about actors
    public function actorDetails($id){
        $pdo = Connect::seConnecter();
        $requete_identity = $pdo->query(
            "SELECT id_acteur, CONCAT( prenom,' ', nom ) AS complete_name, TIMESTAMPDIFF(YEAR, personnage.date_naissance, CURDATE()) AS age, sexe
             FROM personnage 
             INNER JOIN acteur ON acteur.id_personnage = personnage.id_personnage
             WHERE id_acteur = $id"
        );

        $requete_filmo = $pdo->query(
            "SELECT film.id_film AS id_film, film.titre AS film_title, role.nom AS role, film.annee_sortie_fr AS film_year
            FROM acteur
            INNER JOIN jouer ON jouer.id_acteur = acteur.id_acteur
            INNER JOIN role ON role.id_role = jouer.id_role
            INNER JOIN film ON jouer.id_film = film.id_film
            WHERE acteur.id_acteur = $id"
            );

        require "view/actorDetails.php";
    }

    // details about films
    public function filmDetails($id){
        $pdo = Connect::seConnecter();
        $requete_identity = $pdo->query(
            "SELECT film.titre AS title, film.annee_sortie_fr AS year, SEC_TO_TIME(duree*60) AS time, CONCAT( personnage.prenom, ' ', personnage.nom ) AS complete_name
            FROM film
            INNER JOIN realisateur ON realisateur.id_realisateur = film.id_realisateur
            INNER JOIN personnage ON personnage.id_personnage = realisateur.id_personnage
            WHERE film.id_film = $id"
        );

        $requete_genre = $pdo->query(
            "SELECT genre.libelle AS nom
            FROM genre
            INNER JOIN posseder ON posseder.id_genre = genre.id_genre
            INNER JOIN film ON posseder.id_film = film.id_film
            WHERE film.id_film = $id"
        );

        $requete_casting = $pdo->query(
            "SELECT CONCAT( personnage.prenom, ' ', personnage.nom ) AS complete_name, acteur.id_acteur as id_acteur, role.nom AS role
            FROM personnage
            INNER JOIN acteur ON acteur.id_personnage = personnage.id_personnage
            INNER JOIN jouer ON jouer.id_acteur = acteur.id_acteur
            INNER JOIN role ON role.id_role = jouer.id_role
            INNER JOIN film ON jouer.id_film = film.id_film
            WHERE film.id_film = $id"
            );
        
        require "view/filmDetails.php";
    }

    // here I query directors and genres from my DB to inject them into lists in my addFilm form
    public function addFilm(){
        
        $pdo = Connect::seConnecter();
        
        $requete_dir = $pdo->query(
            "SELECT id_realisateur, CONCAT( prenom,' ', nom ) AS complete_name
             FROM realisateur
             INNER JOIN personnage ON realisateur.id_personnage = personnage.id_personnage"
        );

        $requete_genre = $pdo->query(
            "SELECT genre.id_genre AS id_genre, libelle
             FROM genre"
        );
        require "view/addFilm.php";
    }

    // here I control my data and then I inject it in my DB
    public function traitementFilm($film){
        $titre = $film['titre'];
        $annee = $film['annee'];
        $duree = (int) $film['duree'];
        $directors = (int) $film['directors'];
        $id_genre = (int) $film['genre'];

        $pdo = Connect::seConnecter();

        $requete_film = $pdo->query(
            "INSERT INTO film (titre, annee_sortie_fr, duree, id_realisateur)
             VALUES ('$titre', '$annee', $duree, $directors)" //insertion of films from user input still needs to be verified
        );

        $id_film = $pdo->lastInsertId('film');

        $requete_posseder = $pdo->query(
            "INSERT INTO posseder (id_film,id_genre)
             VALUES ($id_film,$id_genre)" 
        );
        header("Location:listFilms.php");
        exit();
    }

    public function addGenre($genre){
        $libelle = $genre['libelle'];
        
        $pdo = Connect::seConnecter();
        $requete = $pdo->query(
            "INSERT INTO genre (libelle)
             VALUES ($libelle)"
        );
        header("Location:listFilms.php");
        exit();
    }
}