<?php

require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/templates/profile.tpl.php');

$session = new Session();
if(!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();
$stmt = $db->prepare("Select * From Department");
$stmt->execute();
$departments = $stmt->fetchAll();

drawHeaderMain();
drawAside();
drawCreateNewTicket($departments);
drawFooterMain(); 
?>