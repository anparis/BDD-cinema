<?php
spl_autoload_register(function ($class_name) {
    // replacement of \ with directory separator to include them
    $class_name = str_replace("\\", DIRECTORY_SEPARATOR, $class_name);
    include_once $class_name . '.php';
});

use Controller\CinemaController;

$ctrlCinema = new CinemaController();


if(isset($_GET["action"])){
    switch($_GET["action"]){
        case "listFilms" : $ctrlCinema->listFilms(); break;
        case "listActors" : $ctrlCinema->listActors(); break;
        case "listDirectors" : $ctrlCinema->listDirectors(); break;
        case "formFilm" : $ctrlCinema->sendDirectorsName(); break;
        case "actorDetails" : $ctrlCinema->actorDetails($_GET["id"]); break;
        case "addFilm" : 
            if(isset($_POST["submit"])){     
                $ctrlCinema->addFilms($_POST);
            }; 
            break;
    }
}
else $ctrlCinema->homePage();



