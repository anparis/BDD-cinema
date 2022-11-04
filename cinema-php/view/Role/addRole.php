<?php ob_start(); ?>
    <form action="?action=addRole" method="post" enctype="multipart/form-data">
        <p>
            <label>
                Role :
                <input type="text" name="role" maxlength="50">
            </label>
        </p>
        <p>
            <label>
                Acteurs :
                <select name="actors" id="actorList">
                    <?php foreach($requete_actor->fetchALL() as $actor) { ?>
                            <option value=<?= $actor['id_acteur'] ?>><?= $actor["complete_name"]?></option>
                    <?php } ?>
                </select>
            </label>
        </p>
        <p>
            <label>
                Films :
                <select name="films" id="filmList">
                    <?php foreach($requete_film->fetchALL() as $film) { ?>
                            <option value=<?= $film['id_film'] ?>><?= $film["titre"]?></option>
                    <?php } ?>
                </select>
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