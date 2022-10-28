<?php
spl_autoload_register(function ($class_name) {
    $class_name = str_replace("\\", DIRECTORY_SEPARATOR, $class_name);
    include_once $class_name . '.php';
});

use Controller\CinemaController;

$ctrlCinema = new CinemaController();

if(isset($_GET["action"])){
    switch($_GET["action"]){
        case "ListFilms" : $ctrlCinema->listFilms(); break;
        // case "ListActeurs" : $ctrlCinema->listActeurs(); break;
    }
}