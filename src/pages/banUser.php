<?php


require_once(dirname(__DIR__) . '/templates/common.tpt.php');
require_once(dirname(__DIR__) . '/database/connection.php');
require_once(dirname(__DIR__) . '/classes/user.class.php');
require_once(dirname(__DIR__) . '/classes/ticket.class.php');
require_once(dirname(__DIR__) . '/utils/session.php');
require_once(dirname(__DIR__) . '/templates/agentTickets.tpt.php');
require_once(dirname(__DIR__) . '/templates/adminFunction.tpt.php');

$session = new Session();
if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();
$user = User::getSingleUser($db,$session->getId());
$role = $user->getUserRole($db);
if($role < 3 || !(isset($_POST['idUser']))) die(header('Location: ../pages/main.php'));

drawHeaderMain();
$db = getDatabaseConnection();
$user = User::getSingleUser($db, intval($_POST['idUser']));
drawAside();
drawBanUser($user->getId());
drawFooterMain();