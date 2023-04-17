<?php

declare(strict_types=1);

require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/utils/session.php');
$session = new Session();

$db = getDatabaseConnection();

$user = new User();

// register error and go back with the information
if (User::userExists($db, $_POST['email'])) {
    $session->addMessage('error', 'Email already being used');
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
}

User::saveUser($db, $_POST['username'], $_POST['password'], $_POST['name'], $_POST['email']);

$user = User::getUserAccordingToType($db, (string)$_POST["username"], $_POST["password"]);
$session->setUser($user);

$session->addMessage('success', 'Your account was created!');

header('Location: ../pages/login.php');