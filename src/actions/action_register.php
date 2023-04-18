<?php
// public function __construct(int $idUser, string $name, string $username, string $email, string $password)
declare(strict_types=1);

require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/utils/session.php');

$session = new Session();

$_SESSION['input']['new_user_name'] = htmlentities($_POST['name']);
$_SESSION['input']['new_user_username'] = htmlentities($_POST['username']);
$_SESSION['input']['new_user_email'] = htmlentities($_POST['email']);
$_SESSION['input']['new_user_password'] = htmlentities($_POST['password']);

$db = getDatabaseConnection();
$cost = ['cost' => 12];
$stmt = $db->prepare('INSERT INTO User (name, username, email, password) VALUES (?,?,?,?)');
$stmt->execute(array($_POST['name'], $_POST['username'], $_POST['email'],password_hash($_POST['password'], PASSWORD_DEFAULT, $cost)));

unset($_SESSION['input']);
$session->addMessage('sucess', "New user register");

header('Location: ../pages/login.php');