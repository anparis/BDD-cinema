<?php ob_start(); ?>

<p>Il y a <?= $requete->rowCount() ?> réalisateurs</p>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Age</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchALL() as $director) { ?>
                <tr>
                    <td><?= $director["complete_name"] ?></td>
                    <td><?= $director["age"] ?></td>
                </tr>
        <?php } ?>
        <tr>
            <td colspan="2"><a href="?action=addPerson&type=realisateur">Ajouter un réalisateur</a></td>
        </tr>
    </tbody>
</table>

<?php
$titre = "Liste des Réalisateurs";
$titre_secondaire = "Liste des réalisateurs";
$contenu = ob_get_clean();
require "view/template.php";