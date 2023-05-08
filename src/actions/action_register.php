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
if ($_SESSION['input']['new_user_password'] === $_SESSION['input']['new_user_confirmpassword']){
    $checkUsername = $db->prepare("SELECT * FROM User WHERE username=?");
    $checkUsername->execute(array($_SESSION['input']['new_user_username']));


    $result = $checkUsername->fetchAll();

    if($result){ //significa que se encontrou um user que ja existe
        $session->addMessage('error', 'This username already exists!');
        die(header('Location: ../pages/register.php'));
    }


    $checkEmail = $db->prepare("SELECT idUser,email FROM User WHERE email = ?");
    $checkEmail->execute(array($_SESSION['input']['new_user_email']));

    $result = $checkEmail->fetchAll();
    if($result){ //significa que se encontrou um email que ja existe
        $session->addMessage('error', 'This e-mail already exists!');
        die(header('Location: ../pages/register.php'));
    }
    $cost = ['cost' => 12];
    $stmt = $db->prepare('INSERT INTO User (name, username, email, password) VALUES (?,?,?,?)');
    $stmt->execute(array($_SESSION['input']['new_user_name'], strtolower($_SESSION['input']['new_user_username']), strtolower($_SESSION['input']['new_user_email']),password_hash($_SESSION['input']['new_user_password'], PASSWORD_DEFAULT, $cost)));
}
else{
    $session->addMessage('warning', "Passwords do not match");
    die(header('Location: ../pages/register.php'));
}

unset($_SESSION['input']);
$session->addMessage('sucess', "New user register with sucess");
header('Location: ../pages/login.php');

?>