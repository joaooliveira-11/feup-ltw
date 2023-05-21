<?php
require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__) . '/templates/agentTickets.tpt.php');
require_once(dirname(__DIR__) . '/templates/myTickets.tpl.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');

$session = new Session();
if(!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));
$db = getDatabaseConnection();

if(!(isset($_POST['Ticket']))) die(header('Location: ../pages/main.php'));

$ticket_id = $_POST['Ticket'];
$ticket = Ticket::getTicketFromId($db, intval($ticket_id));
$changes = $ticket->getTicketHistory($db);

drawHeaderMain();
drawTicketHistory($changes, $db);
drawAside();
drawFooterMain();
?>

