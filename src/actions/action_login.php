<?php
  declare(strict_types = 1);

  require_once(dirname(__DIR__).'/utils/session.php');
  require_once(dirname(__DIR__).'/database/connection.php');
  require_once(dirname(__DIR__).'/classes/user.class.php');
  $session = new Session();

  $_SESSION['input']['username login'] = htmlentities($_POST['username']);
  $_SESSION['input']['password login'] = htmlentities($_POST['password']);

  $db = getDatabaseConnection();

  $user = User::getUserWithPassword($db, $_POST['username'], $_POST['password']);

  if($user) {
    $session->setUsername($user->getUsername());
    $session->setId($user->idUser);
    unset($_SESSION['input']['username login']);
    unset($_SESSION['input']['password login']);
    //$_SESSION['id'] = $user->idUser;
    //$_SESSION['username'] = $user->getUsername();
    $session->addMessage('success', 'Login successful!');
    header('Location: ../pages/main.php');
  } else {
    $session->addMessage('error', 'Wrong username or password!');
    die(header('Location: ../pages/login.php'));
  }
?>

