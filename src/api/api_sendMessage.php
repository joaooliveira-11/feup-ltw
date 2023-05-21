<?php

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));
if (!($session->check_tokens($_POST['csrf']))) die(header('Location: ../pages/main.php'));

$db = getDatabaseConnection();

$ticket_id = intval($_POST['Ticket']);
$content = $_POST['content'];
$user_id = $session->getId();
$date = date('d-m-Y');
$ticket = Ticket::getTicketFromId($db,$ticket_id);
$user_receiving = $ticket->getTicketReceiver($db,$user_id);

$stmt = $db->prepare('INSERT INTO Reply (message, create_date, idTicket, idUser) VALUES (?,?,?,?)');
$stmt->execute(array($content, $date, $ticket_id, $user_id));
$stmt2 = $db->prepare('INSERT INTO Inquiry (idUserReceiving,idUserGiving,idTicket,type,date) VALUES (?,?,?,?,?)');
$stmt2->execute(array($user_receiving,$user_id,$ticket_id,"TICKET_RESPONDED",$date));

$last_reply = $ticket->getAllLastReplyFromTicket($db);

echo json_encode($last_reply);
?>