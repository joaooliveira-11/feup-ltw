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
    $args_arr = explode(':', $args);
    $ticket = array_pop($args_arr);
    $hashtags = $args_arr;

    $stmt = $db->prepare('SELECT idHashtag FROM Hashtag WHERE name = :hashtag');

    $stmt_insert = $db->prepare('INSERT INTO Ticket_Hashtags (idTicket, idHashtag) SELECT :ticket, :hashtag_id WHERE NOT EXISTS (SELECT 1 FROM Ticket_Hashtags WHERE idTicket = :ticket AND idHashtag = :hashtag_id)');

    foreach ($hashtags as $hashtag) {
        $stmt->bindValue(':hashtag', $hashtag, PDO::PARAM_STR);
        $stmt->execute();
        $hashtag_id = $stmt->fetchColumn();

        $stmt_insert->bindValue(':ticket', $ticket, PDO::PARAM_INT);
        $stmt_insert->bindValue(':hashtag_id', $hashtag_id, PDO::PARAM_INT);
        $stmt_insert->execute();
    }

    // Retrieve the updated list of hashtags for the ticket
    $updatedHashtags = getHashtagsForTicket($ticket);

    // Return a response object with the success message and updated hashtags
    echo json_encode(['message' => 'Hashtag inserted successfully', 'hashtags' => $updatedHashtags]);
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

function getHashtagsForTicket($ticketId) {
    global $db;

    $stmt = $db->prepare('SELECT Hashtag.idHashtag, Hashtag.name FROM Hashtag INNER JOIN Ticket_Hashtags ON Hashtag.idHashtag = Ticket_Hashtags.idHashtag WHERE Ticket_Hashtags.idTicket = :ticketId');
    $stmt->bindValue(':ticketId', $ticketId, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the hashtags for the ticket
    $hashtags = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $hashtags;
}

?>
