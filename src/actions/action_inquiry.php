<?php

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));
if (!($session->check_tokens($_POST['csrf']))) die(header('Location: ../pages/agentsAvaiableToAssign.php'));

$db = getDatabaseConnection();
$user = User::getSingleUser($db,$session->getId());

if(!(empty($_POST['idUserReceiving'])) and !(empty($_POST['idTicket']))){
    $stmt = $db->prepare('INSERT INTO Inquiry (idUserReceiving,idUserGiving,idTicket,type,date) VALUES (?,?,?,?,?)');
    $stmt->execute(array(intval($_POST['idUserReceiving']),$user->getId(),intval($_POST['idTicket']),$_POST['type'],date('d-m-Y')));
    header('Location: ../pages/main.php');
}

else{
    $session->addMessage("error", "Could not make an inquiry");
    die(header('Location: ../pages/openTickets.php'));
}
?>

