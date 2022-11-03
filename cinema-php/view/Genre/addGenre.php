<?php ob_start(); ?>
    <form action="?action=addGenre" method="post" enctype="multipart/form-data">
        <p>
            <label>
                Genre :
                <input type="text" name="libelle" maxlength="20">
            </label>
        </p>
       
        <p>
            <input type="submit" name="submitGenre" value="Ajouter le Genre">
        </p>
    </form>

<?php
$titre = "Formulaire des Genres";
$titre_secondaire = "Ajouter un Genre";
$contenu = ob_get_clean();
require('view/template.php');