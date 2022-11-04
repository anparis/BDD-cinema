<?php 
    ob_start(); 
?>

<h2>Ajouter un <?= (isset($_GET["type"])) ? ucfirst($_GET["type"]) : "" ?></h2>

<form action="index.php?action=addPerson&type=<?= $_GET["type"] ?>" method="POST">
    <input type="text" name="nom" id="nom" class="form-control" placeholder="Nom" required><br>
    <input type="text" name="prenom" id="prenom" class="form-control" placeholder="Prénom" required><br>
    <input type="radio" id="feminin" name="sexe" value="Feminin">
      <label for="feminin">Féminin</label><br>
    <input type="radio" id="masculin" name="sexe" value="Masculin">
      <label for="masculin">Masculin</label><br>
    <input type="date" name="date_naissance" id="date_naissance" class="form-control">
    
    <input type="submit" name="submit" class="btn" value="Ajouter">
</form>

<?php

$titre = "Ajouter une personne";
$titre_secondaire = "";
$contenu = ob_get_clean();
require "view/template.php";