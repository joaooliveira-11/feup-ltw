<?php

require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/templates/messages.tpl.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');

$session = new Session();
if(!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();

$idUser = $session->getId();
$ticket_id = intval($_SESSION['Ticket']);
$ticket = Ticket::getTicketFromId($db,$ticket_id);
$resolve = $idUser===$ticket->getResolve();
$value = null;
if($_POST['faqQuestion'] && $_POST['faqAnswer']){
    $value = "From Question on FAQ: " . $_POST['faqQuestion'] . " \n\n Answer: " . $_POST['faqAnswer'];
}

drawHeaderMain("messages.js");
drawAside();
drawMessages($ticket_id, $idUser, $resolve, $value);
drawFooterMain(); 
?>