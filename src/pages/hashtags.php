<?php
require_once(dirname(__DIR__).'/templates/hashtags.tpt.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');

$session = new Session();
if(!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));
$db = getDatabaseConnection();
$tickets = Ticket::getTickets($db, $session->getId());

drawMyTicketPage($tickets, $db);

?>
