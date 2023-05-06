<?php

require_once(dirname(__DIR__).'/database/connection.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();

$stmt = $db->prepare('Select stage From Status');
$result = $stmt->fetchAll();
echo json_encode($result);
