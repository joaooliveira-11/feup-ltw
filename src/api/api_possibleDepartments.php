<?php

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();

$ticket_id = $_GET['Ticket'];
$ticket = Ticket::getTicketFromId($db, intval($ticket_id));

$currentDepart = $ticket->getTicketDepartmentName($db);
$possibleDepartments = $ticket->possibleChangingDepartment($db, $currentDepart);

echo json_encode($possibleDepartments);
?>
