
<?php
// print_r($_SERVER);
?>



<header>
    <a href="/" class="logo">AssiAuto</a>
    <ul class="header-menu">
        <li class="<?= $_SERVER['REQUEST_URI'] === '/addAnArticle.php' ? 'active' : '' ?>">
            <a href="/addAnArticle.php">Ecrire un article</a>
        </li>
    </ul>
</header>