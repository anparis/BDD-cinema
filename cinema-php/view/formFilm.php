<?php ob_start(); ?>
    <form action="../index.php" method="post" enctype="multipart/form-data">
        <p>
            <label>
                Titre du film :
                <input type="text" name="titre" maxlength="50">
            </label>
        </p>
        <p>
            <label>
                Année de sortie en France :
                <input type="number" name="annee" min=0>
            </label>
        </p>
        <p>
            <label>
                Durée du film (en minute) :
                <input type="number" name="duree" min=0>
            </label>
        </p>
        <p>
            <label>
                Réalisateur :
                <input name="directors" list="directorlist">
                <datalist id="directorlist">
                    <?php
                    $i = 1;
                    foreach($requete->fetchALL() as $director) { ?>
                            <option value="<?= $i ?>"><?= $director["prenom"] ?> <?= $director["nom"] ?></option>
                    <?php $i++; } ?>
                </datalist>
            </label>
        </p>
        <p>
            <input type="submit" name="submit" value="Ajouter le film">
        </p>
    </form>

<?php
$titre = "Formulaire des Films";
$titre_secondaire = "Ajouter un Film";
$contenu = ob_get_clean();
require('view/template.php');