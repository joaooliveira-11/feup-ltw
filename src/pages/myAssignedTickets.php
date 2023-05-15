<?php

require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__) . '/templates/agentTickets.tpt.php');
$session = new Session();
if(!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));
drawHeaderMain("changeStatus.js");
$db = getDatabaseConnection();
$ticketsAssigned = Ticket::getAssignedTickets($db,$session->getId());
drawAside();
drawAssignedTicketsMain($ticketsAssigned, $db);
drawFooterMain();

?>