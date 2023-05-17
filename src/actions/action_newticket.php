<?php
declare(strict_types = 1);

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));
$db = getDatabaseConnection();

$cria = $session->getId();
$title = htmlentities($_POST['title']);
$description = htmlentities($_POST['description']);
$priority = htmlentities($_POST['priority']);
$date = htmlentities($_POST['date']);
$department = htmlentities($_POST['department']);

$stmt = $db->prepare('SELECT idDepartment FROM Department WHERE name = ?');
$stmt->execute(array($department));
$idDepartment = $stmt->fetch();

$new_ticket = new Ticket(NULL, $title, $description, intval($priority), $date, $session->getId(), NULL, intval($idDepartment['idDepartment']));
$new_ticket->insert_ticket($db);

header('Location: ../pages/main.php');
?>