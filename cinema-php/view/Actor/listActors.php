<?php ob_start(); ?>

<p>Il y a <?= $requete->rowCount() ?> acteurs</p>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Age</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchALL() as $acteur) { ?>
                <tr>
                    <td><a href="index.php?action=actorDetails&id=<?= $acteur['id_acteur']?>"><?= $acteur["complete_name"] ?></a></td>
                    <td><?= $acteur["age"] ?></td>
                </tr>
        <?php } ?>
    </tbody>
</table>

<?php

$titre = "Liste des Acteurs";
$titre_secondaire = "Liste des acteurs";
$contenu = ob_get_clean();
require "view/template.php";