<?php

$pdo = require_once __DIR__ . '/../db.php';

class ArticleDB {

private PDOStatement $stateCreate;
private PDOStatement $stateUpdate;
private PDOStatement $stateRead;
private PDOStatement $stateReadAll;
private PDOStatement $stateDelete;



function __construct(private PDO $pdo) {
    $this->stateCreate = $pdo->prepare('
    INSERT INTO article (
        nom,
        marque,
        prix,
        couleur,
        Taille,
        img,
        description,
        category
    ) VALUES (
        :nom,
        :marque,
        :prix,
        :couleur,
        :Taille,
        :img,
        :category,
        :description
    )');
    
    $this->stateUpdate = $pdo->prepare('
    UPDATE article
    SET
    nom=:nom,
    marque=:marque,
    prix=:prix,
    couleur=:couleur,
    Taille=:Taille,
    img=:img,
    category=:category,
    description=:description
    WHERE id=:id');
    
    $this->stateRead = $pdo->prepare('SELECT * FROM article WHERE id=:id');  
    
    $this->stateReadAll = $pdo->prepare('SELECT * FROM article');
    
    $this->stateDelete = $pdo->prepare('DELETE FROM article WHERE id=:id');

   }

public function fetchAllArticle() {
$this->stateReadAll->execute();
return $this->stateReadAll->fetchAll();
}

public function fetchArticle(int $id) {
    $this->stateRead->bindValue(':id', $id);
    $this->stateRead->execute();
return $this->stateRead->fetch();
}

public function createArticle($article) {
    $this->stateCreate->bindValue(':nom', $article['nom']);
    $this->stateCreate->bindValue(':marque', $article['marque']);
    $this->stateCreate->bindValue(':prix', $article['prix']);
    $this->stateCreate->bindValue(':couleur', $article['couleur']);
    $this->stateCreate->bindValue(':Taille', $article['Taille']);
    $this->stateCreate->bindValue(':img', $article['img']);
    $this->stateCreate->bindValue(':category', $article['category']);
    $this->stateCreate->bindValue(':description', $article['description']);
    $this->stateCreate->execute();
return $this->fetchArticle($this->pdo->lastInsertId());
}

public function updateArticle($article) {
    $this->stateUpdate->bindValue(':nom', $article['nom']);
    $this->stateUpdate->bindValue(':marque', $article['marque']);
    $this->stateUpdate->bindValue(':prix', $article['prix']);
    $this->stateUpdate->bindValue(':couleur', $article['couleur']);
    $this->stateUpdate->bindValue(':Taille', $article['Taille']);
    $this->stateUpdate->bindValue(':img', $article['img']);
    $this->stateCreate->bindValue(':category', $article['category']);
    $this->stateUpdate->bindValue(':description', $article['description']);
    $this->stateUpdate->bindValue(':id', $article['id']);
    $this->stateUpdate->execute();
    return $article;
}

public function deleteArticle(int $id) {
    $this->stateDelete->bindValue(':id', $id);
    $this->stateDelete->execute();
    return $id;
}
};

return new ArticleDB($pdo);