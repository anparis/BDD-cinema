<?php

use Controller\CinemaController;

spl_autoload_call(function ($class_name) {
    include $class_name . '.php';
});

$ctrlCinema = new CinemaController();

if(isset($_GET["action"])){
    switch($_GET["action"]){
        case "ListFilms" : $ctrlCinema->listFilms(); break;
        case "ListActeurs" : $ctrlCinema->listActeurs(); break;
    }
}