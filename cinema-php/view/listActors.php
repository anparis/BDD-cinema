<?php ob_start(); ?>

<p>Il y a <?= $requete->rowCount() ?> acteurs</p>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Age</th>
            <th>Sexe</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchALL() as $acteur) { ?>
                <tr>
                    <td><?= $acteur["prenom"] ?> <?= $acteur["nom"] ?></td>
                    <td><?= $acteur["age"] ?></td>
                    <td><?= $acteur["sexe"] ?></td>
                </tr>
        <?php } ?>
    </tbody>
</table>

<?php

$titre = "Liste des Acteurs";
$titre_secondaire = "Liste des acteurs";
$contenu = ob_get_clean();
require "view/template.php";