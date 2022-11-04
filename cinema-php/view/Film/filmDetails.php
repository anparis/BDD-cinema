<?php 
ob_start(); 
$film = $requete_identity->fetch();
$genre = $requete_genre->fetch();
?>
<table>
    <tbody>
        <tr>
            <th scope="row" style="width:8em;">Titre : </th>
            <td><?= $film["title"]?></td>
        </tr>
        <tr>
            <th scope="row" style="width:8em;">Année de sortie : </th>
            <td><?= $film["year"]?></td>
        </tr>
        <tr>
            <th scope="row" style="width:8em;">Durée : </th>
            <td><?= $film["time"]?></td>
        </tr>
        <tr>
            <th scope="row" style="width:8em;">Genre : </th>
            <td><?= $genre["nom"]?></td>
        </tr>
        <tr>
            <th scope="row" style="width:8em;">Casting : </th>
            <td><?php
                $requete1 = $requete_casting->fetchAll();
                foreach($requete1 as $casting){ ?>
                    <a href="index.php?action=actorDetails&id=<?= $casting["id_acteur"]?>"><?= $casting["complete_name"]?></a> (<?= $casting["role"]?>)
                <?php } ?>
            </td>
        </tr>
        <tr>
            <th scope="row" style="width:8em;">Note sur 5 : </th>
            <td><?= $film["note"]?></td>
        </tr>
        <tr>
            <th scope="row" style="width:8em;">Synopsis : </th>
            <td><?= $film["synopsis"]?></td>
        </tr>
        <tr>
            <th scope="row" style="width:8em;">Affiche : </th>
            <td><img src=<?= $film["affiche"]?>></td>
        </tr>
    </tbody>
</table>

<?php

$titre ="Infos sur ".$film['complete_name'];
$titre_secondaire = $film['complete_name'];
$contenu = ob_get_clean();
require "view/template.php";