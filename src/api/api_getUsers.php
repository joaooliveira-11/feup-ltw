<?php

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();
$users = User::getAllUsers($db);

$userData = array();
foreach ($users as $user) {
    $userData[] = array(
        'userid' => $user->getId(),
        'username' => $user->getUsername(),
        'name' => $user->getName(),
        'role' => $user->getUserRole($db),
        'roleName' => $user->getRoleName($db, $user->getUserRole($db)),
        'tokens' => $_SESSION['csrf']
    );
}

echo json_encode($userData);
?>