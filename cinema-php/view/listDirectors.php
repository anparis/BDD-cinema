<?php ob_start(); ?>

<p>Il y a <?= $requete->rowCount() ?> réalisateurs</p>

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
            foreach($requete->fetchALL() as $director) { ?>
                <tr>
                    <td><?= $director["prenom"] ?> <?= $director["nom"] ?></td>
                    <td><?= $director["age"] ?></td>
                    <td><?= $director["sexe"] ?></td>
                </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$titre = "Liste des Réalisateurs";
$titre_secondaire = "Liste des réalisateurs";
$contenu = ob_get_clean();
require "view/template.php";