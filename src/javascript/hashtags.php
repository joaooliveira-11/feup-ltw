<?php
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();
$q = $_GET['q'];

// Query the database for matching hashtags
$stmt = $db->prepare('SELECT name FROM Hashtag WHERE name LIKE :query');
$stmt->bindValue(':query', $q . '%', PDO::PARAM_STR);
$stmt->execute();

// Collect the matching hashtags into an array
$hashtags = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $hashtags[] = $row['name'];
}

// Return the list of matching hashtags as JSON
header('Content-Type: application/json');
echo json_encode($hashtags);
?>
