<?php

$dns = 'mysql:host=localhost;dbname=assiauto-base';
$user = 'root';
$password = '';


try {
    $pdo = new PDO($dns, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC   // pour faire un tableau associatif, une clé : une valeur
    ]);
} catch (\Throwable $th) {
    echo "error : " . $e->getMessage();
}

return $pdo;