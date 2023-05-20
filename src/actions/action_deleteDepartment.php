<?php
declare(strict_types = 1);

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();

$stmt = $db->prepare('DELETE FROM Department WHERE idDepartment = ?');
$stmt->execute(array($_POST['department']));

header('Location: ../pages/manageDepartments.php');