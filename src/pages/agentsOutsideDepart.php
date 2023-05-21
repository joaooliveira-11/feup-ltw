<?php
require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__) . '/templates/adminFunction.tpt.php');

$session = new Session();
if(!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();
$user = User::getSingleUser($db,$session->getId());
$role = $user->getUserRole($db);
if($role < 3 || !(isset($_POST['department']))) die(header('Location: ../pages/main.php'));

drawHeaderMain("adminFunct.js");
$db = getDatabaseConnection();

$idDepartment = intval($_POST['department']);
$users = User::getAllUsersOutsideDepartment($db,$idDepartment);

drawAside();
drawOutsideDepartmentAgents($users, $idDepartment, $db);
drawFooterMain();