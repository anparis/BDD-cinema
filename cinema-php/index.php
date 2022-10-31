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
        case "ListFilms" : $ctrlCinema->listFilms(); break;
        case "ListActors" : $ctrlCinema->listActors(); break;
        case "ListDirectors" : $ctrlCinema->listDirectors(); break;
        case "FormFilm" : $ctrlCinema->sendDirectorsName(); break;
    }
    die;
}


if(isset($_POST["submit"])){     
    $ctrlCinema->addFilms($_POST);
}


require('view/homepage.php');