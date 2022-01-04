<?php

$articleDb = require_once __DIR__ .  './database/models/database.php';

$articles = $articleDb->fetchAllArticle();
$categories = [];

$selectCat = '';

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$selectCat = $_GET['cat'] ?? '';

if (count($articles)) {
    $categories = array_map(fn ($a) => $a['category'], $articles);
   

    $cat = array_reduce($categories, function ($acc, $c) {
        if (isset($acc[$c])) {
            $acc[$c]++;
        } else {
            $acc[$c] = 1;
        }
        return $acc;
    }, []);


    $artPerCat = array_reduce($articles, function ($acc, $art) {
        if (isset($acc[$art['category']])) {
            $acc[$art['category']] = [...$acc[$art['category']], $art];
        } else {
            $acc[$art['category']] = [$art];
        }
        return $acc;
    }, []);
    // echo "<pre>";
    // print_r($artPerCat);
    // echo "</pre>";
}

// echo count($articles);
// echo "<pre>";
// print_r($articles);
// echo "</pre>";

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once 'includes/head.php'; ?>
    <link rel="stylesheet" href="./public/css/index.css">
    <title>ADMINISTRATEUR</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php'; ?>

        <div class="content">
            <div class="main-category-container">
                <ul class="category-container">
                    <li class="fz"> <a href="/">All Articles<span class="small">(<?= count($articles) ?>)</span></a></li>
                    <?php foreach ($cat as $cKey => $cNum) : ?>
                        <li><a href="/?cat=<?= $cKey ?>"><?= $cKey ?><span class="small">(<?= $cNum ?>)</span></a></li>
                    <?php endforeach; ?>
                </ul>
                <div class="category-content">
                    <?php if (!$selectCat) : ?>
                        <?php foreach ($cat as $c => $num) : ?>
                            <h2><?= $c ?></h2>
                            <div class="articles-container">
                                <?php foreach ($artPerCat[$c] as $a) : ?>
                                    <a href="/detailArticle.php?id=<?= $a['id'] ?>" class="article block">
                                        <!-- <div class="img-container" style="background-image:url(<?= $a['img'] ?>) ;"></div> -->
                                        <img src="<?= $a['img'] ?>" alt="" class="img-container">
                                        <h2><?= $a['nom'] ?></h2>
                                    
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <h2><?= $selectCat ?></h2>
                        <div class="articles-container">
                            <?php foreach ($artPerCat[$selectCat] as $a) : ?>
                                <a href="/detailArticle.php?id=<?= $a['id'] ?>" class="article block">
                                    <!-- <div class="img-container" style="background-image:url(<?= $a['img'] ?>) ;"></div> -->
                                    <img src="<?= $a['img'] ?>" alt="" class="img-container">
                                    <h2><?= $a['nom'] ?></h2>
                            
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


        </div>
        <?php require_once 'includes/footer.php'; ?>
    </div>
</body>

</html>