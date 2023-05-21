<?php

declare(strict_types = 1);

require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__) . '/templates/adminFunction.tpt.php');

$session = new Session();
if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();
$user = User::getSingleUser($db,$session->getId());
$role = $user->getUserRole($db);
if($role < 3) die(header('Location: ../pages/main.php'));

drawHeaderMain();
$statuses = User::getAllStatus($db);
$hashtags = User::getAllHashtags($db);
drawAside();
if(isset($_SESSION['errorAdding'])){
    drawOtherOptions($_SESSION['errorAdding']);
    unset($_SESSION['errorAdding']);
}
else {
    drawOtherOptions();
}
drawFooterMain();