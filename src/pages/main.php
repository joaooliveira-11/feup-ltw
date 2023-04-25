<?php
require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/utils/session.php');

$session = new Session();
if(!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

drawHeaderMain();
drawAside();

$db = getDatabaseConnection();
$stmt = $db->prepare("Select * From Department");
$stmt->execute();
$departments = $stmt->fetchAll();

drawMainPage($departments, $db);
drawFooterMain();
?>

