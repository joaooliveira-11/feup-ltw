<?php
  declare(strict_types = 1);

  require_once(dirname(__DIR__).'/utils/session.php');
  require_once(dirname(__DIR__).'/database/connection.php');
  require_once(dirname(__DIR__).'/classes/user.class.php');
  $session = new Session();

  $db = getDatabaseConnection();

  $user = User::getUserWithPassword($db, $_POST['username'], $_POST['password']);

  if($user) {
    $session->setId($user->idUser);
    $session->setName($user->name());
    $session->addMessage('success', 'Login successful!');
  } else {
    $session->addMessage('error', 'Wrong password!');
  }

  header('Location: ../pages/main.php');
?>

