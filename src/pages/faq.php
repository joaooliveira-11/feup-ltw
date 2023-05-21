<?php
require_once(dirname(__DIR__).'/templates/faq.tpt.php');
require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');

$session = new Session();

$db = getDatabaseConnection();
$stmt = $db->prepare("Select * From FAQ");
$stmt->execute();
$user = User::getSingleUser($db,$session->getId());
$role = $user->getUserRole($db);

drawHeaderMain();
drawAside();
drawFAQ($stmt, $role);
drawFooterMain();

?>
