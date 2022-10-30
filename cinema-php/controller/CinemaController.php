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
}