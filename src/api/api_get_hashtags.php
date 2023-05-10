<?php

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();
$q = $_GET['q'];

$stmt = $db->prepare('SELECT name FROM Hashtag WHERE name LIKE ?');
$stmt->execute(["%$q%"]);

$hashtags = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($hashtags);
?>
