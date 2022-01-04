<?php

const ERR_REQUIRED = "Veuillez renseigner ce champs !";
const ERR_SHORT_TITLE = "Le titre est trop court";
const ERR_CONTENT_SHORT = "L'article est trop court";
const ERR_IMG_URL = "L'image doit avoir une URL valide";

$articleDb = require_once __DIR__ .  './database/models/database.php';

$category = '';


$errors = [
    'nom' => '',
    'marque' => '',
    'prix' => '',
    'couleur' => '',
    'Taille' => '',
    'img' => '',
    'description' => '',
    'category' => ''
];

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $_GET['id'] ?? '';

if ($id) {
    $article = $articleDb->fetchArticle($Id);
    $nom = $article['nom'];
    $marque = $article['marque'];
    $prix = $article['prix'];
    $couleur = $article['couleur'];
    $taille = $article['Taille'];
    $image = $article['img'];
    $category = $article['category'];
    $description = $article['description'];
}


if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $_POST = filter_input_array(INPUT_POST, [
        'nom' => FILTER_SANITIZE_STRING,
        'prix' => FILTER_SANITIZE_STRING,
        'marque' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'couleur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'Taille' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'category' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'img' => FILTER_SANITIZE_URL,
        'description' => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'flags' => FILTER_FLAG_NO_ENCODE_QUOTES
        ]
    ]);

    $nom = $_POST['nom'] ?? '';
    $prix = $_POST['prix'] ?? '';
    $marque = $_POST['marque'] ?? '';
    $couleur = $_POST['couleur'] ?? '';
    $taille = $_POST['Taille'] ?? '';
    $image = $_POST['img'] ?? '';
    $category = $_POST['category'] ?? '';
    $description = $_POST['description'] ?? '';


    if (!$nom) {
        $errors['nom'] = ERR_REQUIRED;
    } else if (mb_strlen($nom) < 3) {
        $errors['nom'] = ERR_SHORT_TITLE;
    }
    if (!$prix) {
        $errors['prix'] = ERR_REQUIRED;
    }
    if (!$marque) {
        $errors['marque'] = ERR_REQUIRED;
    }
    // if (!$couleur) {
    //     $errors['couleur'] = ERR_REQUIRED;
    // }
    if (!$taille) {
        $errors['Taille'] = ERR_REQUIRED;
    }
    if (!$image) {
        $errors['img'] = ERR_REQUIRED;
    } else if (!filter_var($image, FILTER_VALIDATE_URL)) {
        $errors['img'] = ERR_IMG_URL;
    }
    if (!$category) {
        $errors['category'] = ERR_REQUIRED;
    }

    if (!$description) {
        $errors['description'] = ERR_REQUIRED;
    } elseif (mb_strlen($description) < 50) {
        $errors['description'] = ERR_CONTENT_SHORT;
    }


    if (empty(array_filter($errors, fn ($e) => $e !== ''))) {
        if ($Id) {
            $article['nom'] = $nom;
            $article['marque'] = $marque;
            $article['prix'] = $prix;
            $article['couleur'] = $couleur;
            $article['Taille'] = $taille;
            $article['img'] = $image;
            $article['category'] = $category;
            $article['description'] = $description;
            $articleDb->updateArticle($article);
        } else {
            $articleDb->createArticle([
                'nom' => $nom,
                'marque' => $marque,
                'prix' => $prix,
                'couleur' => $couleur,
                'Taille' => $taille,
                'category' => $category,
                'img' => $image,
                'description' => $description
            ]);
        };
        header('Location: /');
    }
}

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once 'includes/head.php'; ?>
    <link rel="stylesheet" href="/public/css/addAnArticle.css">
    <title>Article</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php'; ?>
        <div class="content">
            <div class="block p-20 form-container">
                <h1><?= $id ? "Modifier " : "Ecrire " ?>un article</h1>

                <form action="/addAnArticle.php<?= $id ? "?id=$id" : '' ?>" method="POST">


                    <div class="form-control">
                        <label for="title">Titre</label>
                        <input type="nom" name="nom" id="title" value="<?= $nom ?? '' ?>">
                        <p class="text-danger"><?= $errors['nom'] ?></p>
                    </div>
                    <div class="form-control">
                        <label for="category">category</label>
                        <select name="category" id="category">
                            <option <?= !$category || $category === "Enjoliveur" ? 'selected' : '' ?> value="Enjoliveur">Enjoliveur</option>
                            <option <?= $category === "CameradeRecule" ? 'selected' : '' ?> value="CameradeRecule">Camerade Recule</option>
                            <option <?= $category === "Tapisdesol" ? 'selected' : '' ?> value="Tapisdesol">Tapisdesol</option>
                            <option <?= $category === "SupportdeTelephone" ? 'selected' : '' ?> value="SupportdeTelephone">Support de Telephone</option>
                            <option <?= $category === "HautParleur" ? 'selected' : '' ?> value="HautParleur">HautParleur</option>
                            <option <?= $category === "ProtegeSiege" ? 'selected' : '' ?> value="ProtegeSiege">ProtegeSiege</option>
                            <option <?= $category === "ProtegePareBrise" ? 'selected' : '' ?> value="ProtegePareBrise">ProtegePareBrise</option>
                            <option <?= $category === "AutoRadio" ? 'selected' : '' ?> value="AutoRadio">Auto-Radio</option>
                        </select>
                        <p class="text-danger"><?= $errors['category'] ?></p>

                    </div>
                    <div class="form-control">
                        <label for="prix">Prix</label>
                        <input type="text" name="prix" id="title" value="<?= $prix ?? '' ?>">
                        <p class="text-danger"><?= $errors['prix'] ?></p>

                    </div>

                    <div class="form-control">
                        <label for="Taille">Taille</label>
                        <input type="text" name="Taille" id="title"value="<?= $taille ?? '' ?>">
                        <p class="text-danger"><?= $errors['Taille'] ?></p>

                    </div>
        

            <div class="form-control">
                <label for="couleur">couleur</label>
                <input type="text" name="couleur" id="title" value="<?= $couleur ?? '' ?>">
                <p class="text-danger"><?= $errors['couleur'] ?></p>

            </div>


        <div class="form-control">
            <label for="img">Image</label>
            <input type="text" name="img" id="title" value="<?= $image ?? '' ?>">
            <p class="text-danger"><?= $errors['img'] ?></p>
        </div>


        <div class="form-control">
            <label for="description">Description</label>
            <textarea name="description" id="content"><?= $description ?? '' ?></textarea>
            <p class="text-danger"><?= $errors['description'] ?></p>

        </div>

        <div class="form-action">
            <a href="/" class="btn btn-secondary" type="button">Annuler</a>
            <button class="btn btn-primary"><?= $id ? "Modifier" : "Sauvegarder" ?></button>
        </div>
        </form>
    </div>
    </div>
    <?php require_once 'includes/footer.php'; ?>
    </div>
</body>

</html>