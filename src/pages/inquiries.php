<?php

require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
require_once(dirname(__DIR__).'/classes/ticket.class.php');
require_once(dirname(__DIR__).'/classes/inquiry.class.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/templates/inquiries.tpl.php');

$session = new Session();
if(!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));
drawHeaderMain();
drawAside();
$db = getDatabaseConnection();
$user = User::getSingleUser($db, $session->getId());
$userInquiries = Inquiry::getUserInquiries($db, $user->getId());
drawUserInquiries($db,$userInquiries);
drawFooterMain();
