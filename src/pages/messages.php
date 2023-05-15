<?php

require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/templates/messages.tpl.php');
require_once(dirname(__DIR__).'/utils/session.php');

$session = new Session();
if(!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$idUser = $session->getId();
$ticket_id = intval($_POST['Ticket']);

drawHeaderMain("messages.js");
drawAside();
drawMessages($ticket_id, $idUser);
drawFooterMain(); 
?>