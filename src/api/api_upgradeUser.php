<?php
declare(strict_types = 1);

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));
if (!($session->check_tokens($_POST['csrf']))) die(header('Location: ../pages/main.php'));

$db = getDatabaseConnection();

$idUser = intval($_POST['user']);
$idRole = intval($_POST['role']);

$stmt = $db->prepare('INSERT INTO User_Roles (idUser, idRole) VALUES (?,?)');
$stmt->execute(array($idUser, $idRole));

echo json_encode("done");
?>