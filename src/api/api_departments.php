<?php

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/inquiry.class.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();
$user = User::getSingleUser($db, $session->getId());

if($user->getUserRole($db) < 2) die(header('Location: ../pages/login.php')); //verificar se é um agent, pelo menos

$departments = $user->getDepartments($db);
$return_departments = array();

foreach ($departments as $department){
    $departments[] = User::getDepartmentName($department);
}

echo json_encode($departments);