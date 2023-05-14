<?php
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/inquiry.class.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));

$db = getDatabaseConnection();
$currentUser = User::getSingleUser($db,$session->getId());
print_r($_POST);
$inquiry = Inquiry::getInquiryFromId($db,intval($_POST['idInquiry']));
$type = $inquiry->getType();
if($type==="ASSIGN_REQUEST") {
    Inquiry::deleteInquiryAssignRequest($db, intval($_POST['idInquiry']));
}
header('Location: ../pages/inquiries.php');
