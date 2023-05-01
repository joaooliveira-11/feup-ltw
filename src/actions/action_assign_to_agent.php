<?php

declare(strict_types = 1);

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/inquiry.class.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();
$currentUser = User::getSingleUser($db,$session->getId());

$assignAgent = $session->getId(); //isto serve para verificar se dei assign de um ticket para mim ou a outro agent

if($assignAgent) {
    $stmt = $db->prepare('Update Ticket Set resolve=? WHERE idTicket=?');
    $stmt->execute(array($assignAgent, $_POST['idTicket']));
    if($stmt) {
        $stmt_new = $db->prepare('Update Ticket_Status SET idStatus=? WHERE idTicket=?');
        $stmt_new->execute(array(2, $_POST['idTicket']));
        if($stmt_new){
            if($_POST['Inquiry']) Inquiry::deleteInquiry($db, intval($_POST['Inquiry']));
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

