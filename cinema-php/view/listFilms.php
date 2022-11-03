<?php ob_start(); ?>
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
                    <td><a href="?action=filmDetails&id=<?= $film["id_film"] ?>"><?= $film["title"] ?></a></td>
                    <td><?= $film["year"] ?></td>
                </tr>    
        <?php } ?>
        <tr>
            <td colspan="2"><a href="?action=addFilm">Ajouter un film</a></td>
        </tr>

    </tbody>
</table>

<?php

$titre = "Liste des films";
$titre_secondaire = "Liste des films";
$contenu = ob_get_clean();
require "view/template.php";