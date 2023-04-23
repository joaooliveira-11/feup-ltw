<?php
require_once(dirname(__DIR__).'/templates/faq.tpt.php');
require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');

$session = new Session();

$db = getDatabaseConnection();

drawHeaderMain();
drawAside();
drawFAQ($db);
drawFooterMain();

/* if(!$session->isLoggedIn()){
    drawHeaderMain();
    drawFAQ($that);
    drawFooterMain();
} else {
    drawHeaderMain();
    drawAside();
    drawFAQ($that);
    drawFooterMain();
} */

?>
