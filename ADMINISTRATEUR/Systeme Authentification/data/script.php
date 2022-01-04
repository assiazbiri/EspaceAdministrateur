<?php

$login = json_decode(file_get_contents('./log.Json'), true);
$db = 'mysql:host=localhost;dbname=monsite';
$user = 'root';
$password = '';

$pdo = new PDO($db , $user, $password);

if($pdo){
    echo 'ok';
}

$statemantLog = $pdo->prepare('
INSERT INTO login (
    name,
    password,  
)VALUES(
:name,
:password
)');
// on boucle sur notre fichier JSON $a corresspond a un seul article
foreach($login as $a) {
    $statemantLog->bindValue(':name', $a['name']);
    $statemantLog->bindValue(':password', $a['password']);
    $statemantLog->execute();
    echo "INSERED";
}
