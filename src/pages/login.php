<?php
require_once(dirname(__DIR__).'/templates/common.tpt.php');
require_once(dirname(__DIR__).'/utils/session.php');
$session = new Session();

$_SESSION['input']['username login'] = $_SESSION['input']['username login'] ?? "";
$_SESSION['input']['password login'] = $_SESSION['input']['password login'] ?? "";


drawLogin($session);
