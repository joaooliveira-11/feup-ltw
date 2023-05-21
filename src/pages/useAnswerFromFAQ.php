<?php
require_once(dirname(__DIR__).'/templates/faq.tpt.php');
require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');

$session = new Session();
if(!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));
if($role < 3) die(header('Location: ../pages/main.php'));

$db = getDatabaseConnection();
$stmt = $db->prepare("Select * From FAQ");
$stmt->execute();

drawHeaderMain();
drawAside();
drawFAQ($stmt, 0,true);
drawFooterMain();

?>
