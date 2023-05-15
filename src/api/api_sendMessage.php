<?php

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();

$ticket_id = intval($_POST['Ticket']);
$content = $_POST['content'];
$user_id = $session->getId();
$date = date('d-m-Y');

$stmt = $db->prepare('INSERT INTO Reply (message, create_date, idTicket, idUser) VALUES (?,?,?,?)');
$stmt->execute(array($content, $date, $ticket_id, $user_id));

$ticket = Ticket::getTicketFromId($db, $ticket_id);
$last_reply = $ticket->getAllLastReplyFromTicket($db);

echo json_encode($last_reply);