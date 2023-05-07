<?php

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();

$ticket_id = $_GET['Ticket'];

$ticket = Ticket::getTicketFromId($db, intval($ticket_id));

$status = $_GET['Status'];


$ticket->change_ticket_status($db,$status);
echo json_encode("done");