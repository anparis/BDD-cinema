<?php ob_start(); ?>
<a href="?action=FormFilm">Ajouter un film</a>
<p>Il y a <?= $requete->rowCount() ?> films</p>

<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Annee Sortie</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchALL() as $film) { ?>
                <tr>
                    <td><?= $film["titre"] ?></td>
                    <td><?= $film["annee_sortie_fr"] ?></td>
                </tr>    
        <?php } ?>
    </tbody>
</table>

<?php

$titre = "Liste des films";
$titre_secondaire = "Liste des films";
$contenu = ob_get_clean();
require "view/template.php";