<?php

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();

$stmt = $db->prepare('Select stage From Status ');
$stmt->execute();
$result = $stmt->fetchAll();
$stages = array_column($result,'stage');
echo json_encode($stages);
?>
