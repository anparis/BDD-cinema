<?php
namespace Controller;
use Model\Connect;

class CinemaController{

    public function homePage(){
        require "view/homepage.php";
    }

    /*

        Display list functions

    */

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

    public function listGenre(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query(
            "SELECT id_genre, libelle
            FROM genre
            ORDER BY libelle ASC"
        );

        require "view/listGenre.php";
    }

    /*

        Display details functions

    */

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

    /*

        Add functions

    */

    public function addGenre(){
        $libelle = filter_input(INPUT_POST, "libelle", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(isset($_POST["submitGenre"]) && $libelle){
            $pdo = Connect::seConnecter();

            $requete = $pdo->query(
                "INSERT INTO genre (libelle)
                 VALUES ('$libelle')"
            );
        }

        require "view/addGenre.php";
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

        // here I verify my data and then I inject it in my DB
        
        if(isset($_POST["submitFilm"])){
            $titre = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $annee = filter_input(INPUT_POST, "annee", FILTER_VALIDATE_INT);
            $duree = filter_input(INPUT_POST, "duree", FILTER_VALIDATE_INT);
            $directors = filter_input(INPUT_POST, "directors", FILTER_VALIDATE_INT);
            $genre = filter_input(INPUT_POST, "genre", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $note = filter_input(INPUT_POST, "note", FILTER_VALIDATE_INT);
            $synopsis = filter_input(INPUT_POST, "synopsis", FILTER_DEFAULT);

            if($titre && $annee && $duree && $directors && $genre && is_string($synopsis) && $note){
                $requete_film = $pdo->prepare("INSERT INTO film 
                (titre, annee_sortie_fr, duree, note, synopsis, id_realisateur)
                VALUES (:titre, 
                        :annee_sortie_fr, 
                        :duree, 
                        :note, 
                        :synopsis,
                        :id_realisateur
                    )");

                $requete_film->execute([
                    "titre" => $titre,
                    "annee_sortie_fr" => $annee,
                    "duree" => $duree,
                    "note" => $note,
                    "synopsis" => $synopsis,
                    "id_realisateur" => $directors
                ]);
        
                //with this function I can get the latest id that has been added into my DB
                $id_film = $pdo->lastInsertId('film');
        
                foreach($genre as $id_genre){
                    $requete_posseder = $pdo->prepare("INSERT INTO posseder (id_film, id_genre) VALUES (:id_film, :id_genre)");
                    $requete_posseder->execute([
                        "id_film" => $id_film,
                        "id_genre" => $id_genre
                    ]);
                }    
            }
        }
        require "view/addFilm.php";
    }
    
}