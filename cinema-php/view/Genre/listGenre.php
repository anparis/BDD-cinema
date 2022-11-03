<?php ob_start(); ?>

<table>
    <thead>
        <tr>
            <th>Libelle</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchALL() as $genre) { ?>
                <tr>
                    <td><?= $genre["libelle"] ?></td>
                </tr>    
        <?php } ?>
        <tr>
            <td><a href="?action=addGenre">Ajouter un Genre</a></td>
        </tr>

    </tbody>
</table>

<?php

$titre = "Liste des Genres";
$titre_secondaire = "Liste des genres";
$contenu = ob_get_clean();
require "view/template.php";