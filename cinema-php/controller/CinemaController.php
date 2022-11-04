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

        require "view/Film/listFilms.php";
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

        require "view/Actor/listActors.php";
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

        require "view/Director/listDirectors.php";
    }

    public function listGenre(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query(
            "SELECT id_genre, libelle
            FROM genre"
        );

        require "view/Genre/listGenre.php";
    }

    public function listRole(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query(
            "SELECT id_role, nom
            FROM role
            ORDER BY nom ASC"
        );

        require "view/Role/listRole.php";
    }

    /*

        Display details functions

    */

    // details about actors
    public function actorDetails($id){
        $pdo = Connect::seConnecter();
        $requete_identity = $pdo->prepare(
            "SELECT id_acteur, CONCAT( prenom,' ', nom ) AS complete_name, TIMESTAMPDIFF(YEAR, personnage.date_naissance, CURDATE()) AS age, sexe
             FROM personnage 
             INNER JOIN acteur ON acteur.id_personnage = personnage.id_personnage
             WHERE id_acteur = :id"
        );
        $requete_identity->execute(["id"=>$id]);

        $requete_filmo = $pdo->prepare(
            "SELECT film.id_film AS id_film, film.titre AS film_title, role.nom AS role, film.annee_sortie_fr AS film_year
            FROM acteur
            INNER JOIN jouer ON jouer.id_acteur = acteur.id_acteur
            INNER JOIN role ON role.id_role = jouer.id_role
            INNER JOIN film ON jouer.id_film = film.id_film
            WHERE acteur.id_acteur = :id"
            );
        $requete_filmo->execute(["id"=>$id]);

        require "view/Actor/actorDetails.php";
    }

    // details about films
    public function filmDetails($id){
        $pdo = Connect::seConnecter();
        $requete_identity = $pdo->prepare(
            "SELECT film.titre AS title, film.annee_sortie_fr AS year, SEC_TO_TIME(duree*60) AS time, CONCAT( personnage.prenom, ' ', personnage.nom ) AS complete_name
            FROM film
            INNER JOIN realisateur ON realisateur.id_realisateur = film.id_realisateur
            INNER JOIN personnage ON personnage.id_personnage = realisateur.id_personnage
            WHERE film.id_film = :id"
        );
        $requete_identity->execute(["id" => $id]);

        $requete_genre = $pdo->prepare(
            "SELECT genre.libelle AS nom
            FROM genre
            INNER JOIN posseder ON posseder.id_genre = genre.id_genre
            INNER JOIN film ON posseder.id_film = film.id_film
            WHERE film.id_film = :id"
        );
        $requete_genre->execute(["id" => $id]);

        $requete_casting = $pdo->prepare(
            "SELECT CONCAT( personnage.prenom, ' ', personnage.nom ) AS complete_name, acteur.id_acteur as id_acteur, role.nom AS role
            FROM personnage
            INNER JOIN acteur ON acteur.id_personnage = personnage.id_personnage
            INNER JOIN jouer ON jouer.id_acteur = acteur.id_acteur
            INNER JOIN role ON role.id_role = jouer.id_role
            INNER JOIN film ON jouer.id_film = film.id_film
            WHERE film.id_film = :id"
            );
        $requete_casting->execute(["id" => $id]);
        
        require "view/Film/filmDetails.php";
    }

    public function roleDetails($id){
        $pdo = Connect::seConnecter();
        $requete_identity = $pdo->prepare(
            "SELECT id_role, nom
            FROM role
            WHERE id_role = :id"
        );
        $requete_identity->execute(["id" => $id]);

        $requete_filmo = $pdo->prepare(
            "SELECT CONCAT( personnage.prenom, ' ', personnage.nom ) AS actor_name, film.id_film AS id_film,acteur.id_acteur as id_actor, film.titre AS film_title, film.annee_sortie_fr AS film_year
            FROM jouer
            INNER JOIN film ON jouer.id_film = film.id_film
            INNER JOIN acteur ON acteur.id_acteur = jouer.id_acteur
            INNER JOIN personnage ON personnage.id_personnage = acteur.id_personnage
            WHERE id_role = :id"
        );
        $requete_filmo->execute(["id" => $id]);

        require "view/Role/roleDetails.php";
    }

    /*

        Add functions

    */

    public function addGenre(){
        $libelle = filter_input(INPUT_POST, "libelle", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(isset($_POST["submitGenre"]) && $libelle){
            $pdo = Connect::seConnecter();

            $requete = $pdo->prepare(
                "INSERT INTO genre (libelle)
                 VALUES (:libelle)"
            );
            $requete->execute(["libelle"=>$libelle]);
        }

        require "view/Genre/addGenre.php";
    }

    
    public function addFilm(){
        
        $pdo = Connect::seConnecter();
        // here I query directors and genres from my DB to inject them into lists in my addFilm form
        $requete_dir = $pdo->query(
            "SELECT id_realisateur, CONCAT( prenom,' ', nom ) AS complete_name
             FROM realisateur
             INNER JOIN personnage ON realisateur.id_personnage = personnage.id_personnage"
        );

        $requete_genre = $pdo->query(
            "SELECT genre.id_genre AS id_genre, libelle
             FROM genre"
        );

        // here I verify data from user input and I inject it in my DB
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
        
                // with this function I can get the latest id that has been added into my DB
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
        require "view/Film/addFilm.php";
    }

    public function addRole() {
        $pdo = Connect::seConnecter();
        // here I query film and actors from my DB to inject them into lists in my addRole form
        $requete_actor = $pdo->query(
            "SELECT id_acteur, CONCAT( prenom,' ', nom ) AS complete_name
            FROM acteur
            INNER JOIN personnage ON acteur.id_personnage = personnage.id_personnage"
        );

        $requete_film = $pdo->query(
            "SELECT id_film, titre
             FROM film"
        );

        if(isset($_POST["submitRole"])) {

            $nom_role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $id_acteur = filter_input(INPUT_POST, "actors", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $id_film = filter_input(INPUT_POST, "films", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if($nom_role && $id_acteur && $id_film) {
                $requete_role = $pdo->prepare("INSERT INTO role (nom) VALUES (:nom)");
                
                $requete_role->execute([
                    "nom" => $nom_role
                ]);

                $id_role = $pdo->lastInsertId('role');

                $requete_jouer = $pdo->prepare("INSERT INTO jouer (id_acteur,id_film,id_role) VALUES (:id_a, :id_f, :id_r)");
                $requete_jouer->execute([
                    "id_a" => $id_acteur,
                    "id_f" => $id_film,
                    "id_r" => $id_role,
                ]);
                header('Location: index.php?action=listRole');
                die();
            }
        }

        require "view/Role/addRole.php";
    }

    public function addPerson($type) {

        if(isset($_POST["submit"])) {
            
            $pdo = Connect::seConnecter();
            $nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenom = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sexe = filter_input(INPUT_POST, "sexe", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date_naissance = filter_input(INPUT_POST, "date_naissance", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $checked = filter_input(INPUT_POST, "personne", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $type = filter_input(INPUT_GET, "type", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($nom && $prenom && $sexe && $date_naissance && $type) {
                
                $requete = $pdo->prepare("INSERT INTO personnage (nom, prenom, date_naissance, sexe) 
                                        VALUES (:nom, :prenom, :date_naissance, :sexe)");
                $requete->execute([
                    "nom" => $nom,
                    "prenom" => $prenom,
                    "date_naissance" => $date_naissance,
                    "sexe" => $sexe
                ]);

                $id_personnage = $pdo->lastInsertId('personnage');
                $requete = $pdo->prepare("INSERT INTO $type (id_personnage) VALUES (:id_personnage)");
                
                $requete->execute([
                    "id_personnage" => $id_personnage
                ]);
                // if actor is also a director, then insert his id in director
                if(!empty($checked)){
                    $requete = $pdo->prepare("INSERT INTO $checked (id_personnage) VALUES (:id_personnage)");
                
                    $requete->execute([
                        "id_personnage" => $id_personnage
                    ]);
                }
            }
        }
        require "view/Personnage/addPerson.php";
    }
    
}