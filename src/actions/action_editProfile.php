<?php
declare(strict_types = 1);

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();
$updateUser = User::getSingleUser($db,$session->getId());

$currentUser = User::getUserWithPassword($db, $updateUser->getUsername(), $_POST['currentPassword']); //este user só serve para testar se a password atual corresponde à do user atual. Não sei se isto está bem em termos de segurança, por causa daquele $_POST.
if(!$currentUser){
    $session->addMessage('error', 'Wrong password!');
    die(header('Location: ../pages/editProfile.php'));
}

$newName = (!empty($_POST['newName'])? $_POST['newName'] : $updateUser->getName());
$newUsername = (!empty($_POST['newUsername'])? $_POST['newUsername'] : $updateUser->getUsername());
$newEmail = (!empty($_POST['newEmail'])? $_POST['newEmail'] : $updateUser->getEmail());

$newPassword = (!empty($_POST['newPassword'])? $_POST['newPassword']: null);
$confirmPassword = (!empty($_POST['confirmPassword'])? $_POST['confirmPassword']: null);

if($newPassword!==$confirmPassword){
    $session->addMessage('error', 'The new Password and the confirm Password did not match');
    die(header('Location: ../pages/editProfile.php'));
}

$checkUsername = $db->prepare("SELECT * FROM User WHERE username=? AND idUser<>?");
$checkUsername->execute(array($newUsername,$session->getId()));


$result = $checkUsername->fetchAll();

if($result){ //significa que se encontrou um user que ja existe
    $session->addMessage('error', 'This username already exists!');
    die(header('Location: ../pages/editProfile.php'));
}


$checkEmail = $db->prepare("SELECT idUser,email FROM User WHERE email = ? AND idUser<>?");
$checkEmail->execute(array($newEmail,$session->getId()));

$result = $checkEmail->fetchAll();
if($result){ //significa que se encontrou um email que ja existe
    $session->addMessage('error', 'This e-mail already exists!');
    die(header('Location: ../pages/editProfile.php'));
}

$updateUser->setName($newName);
$updateUser->setEmail($newEmail);
$updateUser->setUsername($newUsername);
if($newPassword) {
    $updateUser->setPassword($newPassword);
}

$updateUser->save($db);
$session->logout();
header('Location: ../pages/login.php');