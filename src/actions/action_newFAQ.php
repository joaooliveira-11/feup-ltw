<?php
declare(strict_types = 1);

require_once(dirname(__DIR__).'/utils/session.php');
require_once(dirname(__DIR__).'/database/connection.php');
require_once(dirname(__DIR__).'/classes/user.class.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: ../pages/login.php'));
$db = getDatabaseConnection();

$question = htmlentities($_POST['question']);
$answer = htmlentities($_POST['answer']);

$stmt = $db->prepare('
INSERT INTO FAQ (question, answer) VALUES (?,?)
');

$stmt->execute(array($question, $answer));

header('Location: ../pages/main.php');
?>