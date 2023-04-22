<?php
require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/templates/mytickets.tpl.php');


$session = new Session();
if(!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));
drawHeaderMain();
drawAside();
$db = getDatabaseConnection();
$tickets = Ticket::getTickets($db, $session->getId());

drawMyTicketPage($tickets);
drawFooterMain();
?>

