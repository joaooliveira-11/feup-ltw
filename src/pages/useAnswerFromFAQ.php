<?php
require_once(dirname(__DIR__).'/templates/faq.tpt.php');
require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');

$session = new Session();
if(!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();
$user = User::getSingleUser($db,$session->getId());
$role = $user->getUserRole($db);
if($role < 2) die(header('Location: ../pages/main.php'));

$stmt = $db->prepare("Select * From FAQ");
$stmt->execute();

drawHeaderMain();
drawAside();
drawFAQ($stmt, 0,true);
drawFooterMain();

?>
