<?php

declare(strict_types = 1);

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/inquiry.class.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));
if (!($session->check_tokens($_POST['csrf']))) die(header('Location: ../pages/createDepartment.php'));


$db = getDatabaseConnection();

$newTitle = htmlentities($_POST['title']);
$newDescription = htmlentities($_POST['description']);

if(isset($_POST['idDepartment'])){ //isto é para verificar se é para dar update a um department ou criar um novo
    $stmt = $db->prepare('UPDATE Department SET name = ? ,description = ? WHERE idDepartment = ?');
    $stmt->execute(array($newTitle,$newDescription,$_POST['idDepartment']));
}
else{
    $stmt = $db->prepare('INSERT INTO Department(name,description) Values (?,?)');
    $stmt->execute(array($newTitle,$newDescription));
}

header('Location: ../pages/manageDepartments.php');
?>