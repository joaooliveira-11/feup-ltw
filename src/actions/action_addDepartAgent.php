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
$idUser = intval($_POST['idUser']);
$idDepartment =  intval($_POST['idDepart']);

$stmt = $db->prepare('INSERT INTO User_Departments(idUser, idDepartment) VALUES (?,?)');
$stmt->execute(array($idUser, $idDepartment));

header('Location: ../pages/manageDepartments.php');