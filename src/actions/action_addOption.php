<?php

declare(strict_types = 1);

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/inquiry.class.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');

$session = new Session();
if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));
if (!($session->check_tokens($_POST['csrf']))) die(header('Location: ../pages/banUser.php'));

$db = getDatabaseConnection();

if(isset($_POST['new_status'])) {
    $new_status = htmlentities($_POST['new_status']);
    $new_status = strtoupper($new_status);
}
if(isset($_POST['new_hashtag'])) {
    $new_hashtag = htmlentities($_POST['new_hashtag']);
    $new_hashtag = strtolower($new_hashtag);
    $new_hashtag = str_replace("#", "",$new_hashtag);
}
$existing_hashtags = User::getAllHashtags($db);
$existing_statuses = User::getAllStatus($db);

if (!empty($new_hashtag)) {
    if(!(in_array($new_hashtag, $existing_hashtags))){
        $stmt = $db->prepare('INSERT INTO Hashtag (name) VALUES (?)');
        $stmt->execute(array($new_hashtag));
    }
    else{
        $_SESSION['errorAdding'] = "This hashtag already exists";
        die(header('Location: ../pages/manageOptions.php'));
    }
}

else if (!empty($new_status)) {
    if(!(in_array($new_status, $existing_statuses))){
        $stmt = $db->prepare('INSERT INTO Status (stage) VALUES (?)');
        $stmt->execute(array($new_status));
    }
    else {
        $_SESSION['errorAdding'] = "This status already exists";
        die(header('Location: ../pages/manageOptions.php'));
    }
}

die(header('Location: ../pages/manageOptions.php'));


?>