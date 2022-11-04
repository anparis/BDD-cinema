<?php ob_start(); ?>

<table>
    <thead>
        <tr>
            <th>Nom des Roles</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchALL() as $role) { ?>
                <tr>
                    <td><a href="?action=roleDetails&id=<?= $role["id_role"] ?>"><?= $role["nom"] ?></a></td>
                </tr>    
        <?php } ?>
        <tr>
            <td><a href="?action=addRole">Ajouter un role</a></td>
        </tr>

    </tbody>
</table>

<?php

$titre = "Liste des Roles";
$titre_secondaire = "Liste des roles";
$contenu = ob_get_clean();
require "view/template.php";