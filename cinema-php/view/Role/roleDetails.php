<?php 
ob_start(); 
$role = $requete_identity->fetch();
?>
<table>
    <tbody>
        <p>
            Le personnage <?= $role['nom'] ?> est interprété par 
            <?php
                foreach($requete_filmo->fetchALL() as $filmo){
             ?>
                <a href="?action=actorDetails&id=<?= $filmo["id_actor"] ?>"><?= $filmo['actor_name'] ?> </a> dans
                <a href="?action=filmDetails&id=<?= $filmo["id_film"] ?>"><?= $filmo['film_title'] ?></a> (<?= $filmo['film_year'] ?>)
            <?php } ?>
        </p>
    </tbody>
</table>

<?php

$titre ="Infos sur ".$role['nom'];
$titre_secondaire = $role['nom'];
$contenu = ob_get_clean();
require "view/template.php";