
<?php ob_start(); ?>

<p>Un site dédié aux fans de cinéma.</p> 

<?php
$titre = "Home Page";
$titre_secondaire = "Le blog du Cinema !";
$contenu = ob_get_clean();
require "view/template.php";