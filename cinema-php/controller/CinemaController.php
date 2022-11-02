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

    public function sendDirectorsName(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query(
            "SELECT CONCAT( prenom,' ', nom ) AS complete_name
             FROM personnage
             INNER JOIN realisateur ON realisateur.id_personnage = personnage.id_personnage"
        );

        require "view/formFilm.php";
    }

    public function addFilms($film){
        $titre = $film['titre'];
        $annee = $film['annee'];
        $duree = (int) $film['duree'];
        $directors = (int) $film['directors'];

        $pdo = Connect::seConnecter();
        $requete = $pdo->query(
            "INSERT INTO film (titre, annee_sortie_fr, duree, id_realisateur)
             VALUES ('$titre', '$annee', $duree, $directors)" //insertion of films from user input
        );
        header("Location:listFilms.php");
        exit();
    }
}