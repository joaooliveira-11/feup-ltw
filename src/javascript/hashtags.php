<?php

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    die(header('Location: ../pages/login.php'));
}

$db = getDatabaseConnection();
$q = $_GET['q'];

// Check if the query is for inserting a hashtag
if (substr($q, 0, 4) === 'add:') {
    // Extract the hashtag value from the query
    $args = substr($q, 4);
    
    $hashtag = explode(":",$args)[0];
    $ticket = explode(":",$args)[1];

    // Insert the hashtag into the database
    $stmt = $db->prepare('INSERT INTO Ticket_Hashtags (idTicket, idHashtag) VALUES (:ticket, :hashtag)');
    $stmt->bindValue(':name', $hashtag, PDO::PARAM_STR);
    $stmt->execute();

    // Return a success message
    echo json_encode(['message' => 'Hashtag inserted successfully']);
} else {
    // Query the database for matching hashtags
    $stmt = $db->prepare('SELECT name FROM Hashtag WHERE name LIKE :query');
    $stmt->bindValue(':query', $q . '%', PDO::PARAM_STR);
    $stmt->execute();

    // Collect the matching hashtags into an array
    $hashtags = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Return the list of matching hashtags as JSON
    echo json_encode($hashtags);
}

?>
