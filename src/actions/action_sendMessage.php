<?php

declare(strict_types = 1);

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/inquiry.class.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();
$currentUser = User::getSingleUser($db,$session->getId());

$ticket_id = intval($_POST['idTicket']);
$message = htmlentities($_POST['message']);

$ticket = Ticket::getTicketFromId($db, $ticket_id);

$user_receiving = $ticket->getTicketReceiver($db,$currentUser->getId());

if($user_receiving){
    $stmt1 = $db->prepare('Insert INTO Reply(message, create_date, idTicket, idUser) VALUES (?,?,?,?)');
    $stmt1->execute(array($message,date('d-m-Y'),$ticket_id,$currentUser->getId()));
    $stmt2 = $db->prepare('INSERT INTO Inquiry (idUserReceiving,idUserGiving,idTicket,type,date) VALUES (?,?,?,?,?)');
    $stmt2->execute(array($user_receiving,$currentUser->getId(),$ticket_id,"TICKET_RESPONDED",date('d-m-Y')));
}
