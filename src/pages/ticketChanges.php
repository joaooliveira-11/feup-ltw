<?php
require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/templates/adminTickets.tpt.php');
require_once(dirname(__DIR__).'/templates/mytickets.tpl.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');

$session = new Session();
if(!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));
$db = getDatabaseConnection();
$ticket_id = $_GET['Ticket'];
$ticket = Ticket::getTicketFromId($db, intval($ticket_id));
$changes = $ticket->getTicketHistory($db);

drawHeaderMain();
drawTicketHistory($changes, $db);
drawAside();
drawFooterMain();
?>

