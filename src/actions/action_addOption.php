<?php

declare(strict_types = 1);

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/inquiry.class.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');

$session = new Session();
if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();

$new_status = htmlentities($_POST['new_status']);
$new_hashtag = htmlentities($_POST['new_hashtag']);
$existing_hashtags = User::getAllHashtags($db);
$existing_statuses = User::getAllStatus($db);

if (!empty($new_hashtag)) {
    if(!(in_array($new_hashtag, $existing_hashtags))){
        $stmt = $db->prepare('INSERT INTO Hashtag (name) VALUES (?)');
        $stmt->execute(array($new_hashtag));
    }
}

if (!empty($new_status)) {
    if(!(in_array($new_status, $existing_statuses))){
        $stmt = $db->prepare('INSERT INTO Status (stage) VALUES (?)');
        $stmt->execute(array($new_status));
    }
}

header('Location: ../pages/manageOptions.php');
?>