<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titre ?></title>
</head>
<body>
    <nav>
        <ul>
            <a href="?">Home</a>
            <a href="?action=ListFilms">Films</a>
            <a href="?action=ListActeurs">Acteurs</a>
        </ul>
    </nav>
    <main>
        <h1>PDO Cinema</h1>
        <h2><?= $titre_secondaire ?></h2>
        <?= $contenu ?>
    </main>
</body>
</html>