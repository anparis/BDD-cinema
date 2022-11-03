<?php ob_start(); ?>
    <form action="?action=addFilm" method="post" enctype="multipart/form-data">
        <p>
            <label>
                *Titre du film :
                <input type="text" name="titre" maxlength="50">
            </label>
        </p>
        <p>
            <label>
                *Année de sortie en France :
                <input type="number" name="annee" min=0>
            </label>
        </p>
        <p>
            <label>
                *Durée du film (en minute) :
                <input type="number" name="duree" min=0>
            </label>
        </p>
        <p>
            <label>
                *Réalisateur :
                <select name="directors" id="directorList">
                    <?php
                    foreach($requete_dir->fetchALL() as $director) { ?>
                            <option value=<?= $director['id_realisateur'] ?>><?= $director["complete_name"]?></option>
                    <?php } ?>
                </select>
            </label>
        </p>
        <p>
            <label>
                *Genre :
                <select name="genre[]" id="genreList" multiple>
                    <?php
                    foreach($requete_genre->fetchALL() as $genre) { ?>
                        <option value=<?= $genre['id_genre'] ?>><?= $genre["libelle"] ?></option>
                    <?php } ?>
                </select>
            </label>
        </p>
        <p>
            <label>
                Note (sur 5) :
                <input type="number" name="note" min=0 max=5>
            </label>
        </p>
        <p>
            <label>
                Synopsis :
                <input type="textarea" name="synopsis">
            </label>
        </p>
        <p>
            <input type="submit" name="submitFilm" value="Ajouter le film">
        </p>
    </form>

<?php
$titre = "Formulaire des Films";
$titre_secondaire = "Ajouter un Film";
$contenu = ob_get_clean();
require('view/template.php');