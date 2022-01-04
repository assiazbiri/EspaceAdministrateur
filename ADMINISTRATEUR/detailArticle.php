<?php

$articleDb = require_once __DIR__ .  './database/models/database.php';

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$Id = $_GET['Id'] ?? '';

if (!$Id) {
 header('Location: /');
} else {
    $article = $articleDb->fetchArticle($Id);
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once 'includes/head.php'; ?>
    <link rel="stylesheet" href="./public/css/detailArticle.css">
    <title>Espace Administrateur</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php'; ?>

        <div class="content">
            <div class="article-container">
            <div class="article-cover-img" style="background-image: url(<?= $article['img'] ?>)"></div>

                <h1 class="article-title"><?= $article['nom'] ?></h1>
                <div class="article-content"><?= $article['description'] ?></div>
                
                <div class="action">
                    <a class="btn btn-secondary"  href="/deleteArticle.php?Id=<?= $article['id'] ?>">Delete</a>
                    <a class="btn btn-primary"  href="/addAnArticle.php?Id=<?= $article['id'] ?>">Edit</a>

                </div>
            </div>
        </div>

        <?php require_once 'includes/footer.php'; ?>
    </div>
</body>

</html>