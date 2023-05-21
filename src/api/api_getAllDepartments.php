<?php

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/inquiry.class.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();
$user = User::getSingleUser($db,$session->getId());

if($user->getUserRole($db) < 3) die(header('Location: ../pages/login.php')); //verificar se é um admin

$departments = User::getAllIdsDepartments($db);
$return_departments = array();

foreach ($departments as $department){
    $departmentName = User::getDepartmentName($db, intval($department));
    $return_departments[] = array(intval($department), $departmentName['name']);
}

echo json_encode($return_departments);
?>
