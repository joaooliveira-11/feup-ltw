<?php
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/inquiry.class.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));
if (!($session->check_tokens($_POST['csrf']))) die(header('Location: ../pages/inquiries.php'));


$db = getDatabaseConnection();
$inquiry = Inquiry::getInquiryFromId($db, intval($_POST['idInquiry']));
$inquiry->deleteInquiry($db);
header('Location: ../pages/inquiries.php');

