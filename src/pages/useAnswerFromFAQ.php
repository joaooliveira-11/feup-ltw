<?php
require_once(dirname(__DIR__).'/templates/faq.tpt.php');
require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');

$db = getDatabaseConnection();
$stmt = $db->prepare("Select * From FAQ");
$stmt->execute();

drawHeaderMain();
drawAside();
drawFAQ($stmt, 0,true);
drawFooterMain();

?>
