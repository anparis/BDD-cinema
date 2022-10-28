<?php
namespace Controller;
require_once 'model/Connect.php';
use Model\Connect;

class CinemaController{
    // lister les films
    public function listFilms(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("SELECT titre, annee_sortie_fr FROM film");

        require "view/listFilms.php";
    }

    public function listActeurs(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("SELECT prenom, nom, TIMESTAMPDIFF(YEAR, personnage.date_naissance, CURDATE()) AS age, sexe
        FROM personnage
        INNER JOIN acteur ON acteur.id_personnage = personnage.id_personnage");

        require "view/listActeurs.php";
    }
}