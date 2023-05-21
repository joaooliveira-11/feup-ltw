<?php

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();

if (isset($_POST['hashtag'])) {
    $hashtag = $_POST['hashtag'];

    $stmt = $db->prepare('SELECT COUNT(*) FROM Hashtag WHERE name = ?');
    $stmt->execute([$hashtag]);
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        $stmt = $db->prepare('INSERT INTO Hashtag (name) VALUES (?)');
        $stmt->execute([$hashtag]);
    }
}
?>
