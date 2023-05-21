<?php

declare(strict_types = 1);

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));
if (!($session->check_tokens($_POST['csrf']))) die(header('Location: ../pages/banUser.php'));

$db = getDatabaseConnection();

$reason = htmlentities($_POST['title']);
$description = htmlentities($_POST['description']);

$stmt1 = $db->prepare('INSERT INTO User_Ban(idUser, reason, description) VALUES (?,?,?)');
$stmt1->execute(array(intval($_POST['idUser']),$reason,$description));
$stmt2 = $db->prepare('DELETE FROM Ticket WHERE cria = ?');
$stmt2->execute(array(intval($_POST['idUser'])));
header('Location: ../pages/manageUsers.php');