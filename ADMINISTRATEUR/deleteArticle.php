<?php

$articleDb = require_once __DIR__ .  './database/models/database.php';


$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $_GET['id'] ?? '';

if ($id) {
  $articleDb->deleteArticle($id);
}

header('Location: /');

