<?php
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/inquiry.class.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();
$ticket_id = $_GET['ticket_id'];
$hashtag_id = $_GET['hashtag_id'];

// Remove the hashtag from the ticket_hashtags table
$stmt = $db->prepare('DELETE FROM Ticket_Hashtags WHERE idTicket = ? AND idHashtag = ?');
$stmt->execute([$ticket_id, $hashtag_id]);

// Redirect back to the ticket page
header("Location: ../pages/hashtags.php");