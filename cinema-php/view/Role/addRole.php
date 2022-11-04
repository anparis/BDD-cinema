<?php ob_start(); ?>
    <form action="?action=addRole" method="post" enctype="multipart/form-data">
        <p>
            <label>
                Role :
                <input type="text" name="role" maxlength="50">
            </label>
        </p>
       
        <p>
            <input type="submit" name="submitRole" value="Ajouter le Role">
        </p>
    </form>

<?php
$titre = "Formulaire des Roles";
$titre_secondaire = "Ajouter un Role";
$contenu = ob_get_clean();
require('view/template.php');