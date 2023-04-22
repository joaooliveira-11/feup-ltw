<?php
declare(strict_types=1);

require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/utils/session.php');

$session = new Session();

$_SESSION['input']['new_user_name'] = htmlentities($_POST['name']);
$_SESSION['input']['new_user_username'] = htmlentities($_POST['username']);
$_SESSION['input']['new_user_email'] = htmlentities($_POST['email']);
$_SESSION['input']['new_user_password'] = htmlentities($_POST['password']);
$_SESSION['input']['new_user_confirmpassword'] = htmlentities($_POST['password1']);

$db = getDatabaseConnection();
if ($_POST['password'] === $_POST['password1']){
    $cost = ['cost' => 12];
    $stmt = $db->prepare('INSERT INTO User (name, username, email, password) VALUES (?,?,?,?)');
    $stmt->execute(array($_POST['name'], strtolower($_POST['username']), strtolower($_POST['email']),password_hash($_POST['password'], PASSWORD_DEFAULT, $cost)));
}
else{
    $session->addMessage('warning', "Passwords do not match");
    die(header('Location: ../pages/register.php'));
}

unset($_SESSION['input']);
$session->addMessage('sucess', "New user register with sucess");
header('Location: ../pages/login.php');

?>