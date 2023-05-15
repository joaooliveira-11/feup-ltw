<?php

declare(strict_types = 1);

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/inquiry.class.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();
$currentUser = User::getSingleUser($db,$session->getId());

$ticket_id = intval($_POST['idTicket']);
$date = date('d-m-Y');

$assignAgent = $session->getId(); //isto serve para verificar se dei assign de um ticket para mim ou a outro agent

if($assignAgent) {
    $stmt = $db->prepare('Update Ticket Set resolve=? WHERE idTicket=?');
    $stmt->execute(array($assignAgent, $_POST['idTicket']));
    if($stmt) {
        $ticket = Ticket::getTicketFromId($db, intval($ticket_id));
        $stmt_new = $db->prepare('
        INSERT INTO Ticket_Status(idTicket, idStatus, idDepartment, agent, date) VALUES (?,?,?,?,?)
       ');
        $stmt_new->execute(array($ticket_id, 2,$ticket->getidDepartment(), $ticket->getResolve(),$date));
        if($stmt_new){
            if($_POST['Inquiry']) Inquiry::deleteInquiryAssignRequest($db, intval($_POST['Inquiry']));
            $session->addMessage("Success", "Ticket Assigned successfully");
            header('Location: ../pages/myAssignedTickets.php');
        }
        else{
            $session->addMessage("Error", "Could not assign ticket to the agent in question; error on Ticket_Status update");
            die(header('Location: ../pages/openTickets.php'));
        }
    }
    else{
        $session->addMessage("Error", "Could not assign ticket to the agent in question; error on Ticket update");
        die(header('Location: ../pages/openTickets.php'));
    }
}
else{
    $session->addMessage("Error", "Could not assign ticket to the agent in question");
    die(header('Location: ../pages/openTickets.php'));
}

