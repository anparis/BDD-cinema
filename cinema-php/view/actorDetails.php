<?php 
ob_start(); 
$actor = $requete_identity->fetch();
?>
<table>
    <tbody>
        <tr>
            <th scope="row" style="width:8em;">Nom de naissance</th>
            <td><?= $actor["complete_name"]?></td>
        </tr>
        <tr>
            <th scope="row" style="width:8em;">Age</th>
            <td><?= $actor["age"]?> ans</td>
        </tr>
        <tr>
            <th scope="row" style="width:8em;">Sexe</th>
            <td><?= $actor["sexe"]?></td>
        </tr>
    </tbody>
</table>

<h2> Filmographie :</h2>
<table>
    <thead>
        <tr>
            <th>Films</th>
            <th>Année sortie</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete_filmo->fetchAll() as $film){ ?>
                <tr>
                    <td><a href="index.php?action=filmDetails&id=<?= $film["id_film"]?>"><?= $film["film_title"]?></a></td>
                    <td><?= $film["film_year"]?></td>
                    <td><?= $film["role"]?></td>
                </tr>
        <?php } ?>
    </tbody>
</table>

<?php

$titre ="Infos sur ".$actor['complete_name'];
$titre_secondaire = $actor['complete_name'];
$contenu = ob_get_clean();
require "view/template.php";
