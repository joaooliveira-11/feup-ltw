<?php
require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__) . '/templates/adminFunction.tpt.php');

$session = new Session();
if(!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();

$idDepartment = intval($_POST['department']);
$idUser = intval($_POST['user']);

$stmt = $db->prepare('INSERT INTO User_Departments(idUser, idDepartment) VALUES (?,?)');
$stmt->execute(array($idUser, $idDepartment));

echo json_encode("done");