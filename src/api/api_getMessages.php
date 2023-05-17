<?php

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();

$ticket_id = intval($_POST['Ticket']);

$stmt = $db->prepare('
SELECT r.message, u.username, r.create_date, r.idTicket, r.idUser 
FROM Reply r 
JOIN User u ON r.idUser = u.idUser 
WHERE r.idTicket = ? 
ORDER BY r.ROWID ASC
');
$stmt->execute(array($ticket_id));
$replies = $stmt->fetchAll();

echo json_encode($replies);