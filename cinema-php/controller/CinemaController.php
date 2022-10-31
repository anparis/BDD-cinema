<?php
namespace Controller;
use Model\Connect;

class CinemaController{

    // list of films
    public function listFilms(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query(
            "SELECT titre, annee_sortie_fr FROM film"
        );

        require "view/listFilms.php";
    }

    // list of actors
    public function listActors(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query(
            "SELECT prenom, nom, TIMESTAMPDIFF(YEAR, personnage.date_naissance, CURDATE()) AS age, sexe FROM personnage INNER JOIN acteur ON acteur.id_personnage = personnage.id_personnage"
        );

        require "view/listActors.php";
    }

    public function listDirectors(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query(
            "SELECT prenom, nom, TIMESTAMPDIFF(YEAR, personnage.date_naissance, CURDATE()) AS age, sexe
             FROM personnage
             INNER JOIN realisateur ON realisateur.id_personnage = personnage.id_personnage"
        );

        require "view/listDirectors.php";
    }

    public function sendDirectorsName(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query(
            "SELECT prenom, nom
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
                VALUES ($titre, $annee, $duree, $directors)" //insertion of films from user input
        );
    }
}