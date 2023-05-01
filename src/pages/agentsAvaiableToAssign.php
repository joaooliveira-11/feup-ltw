<?php

require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/templates/adminTickets.tpt.php');

$session = new Session();
if(!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));
drawHeaderMain();
drawAside();
$db = getDatabaseConnection();
$idTicket = intval($_POST['idTicket']);
$ticket = Ticket::getTicketFromId($db,$idTicket);
$users = User::getUsersFromDepartment($db,$ticket->getidDepartment());
drawAgentsAvailableMain($idTicket, $users);
drawFooterMain();