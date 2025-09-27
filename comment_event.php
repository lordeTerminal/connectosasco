<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: events.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$event_id = isset($_POST['event_id']) ? (int)$_POST['event_id'] : 0;
$comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

if ($event_id <= 0 || empty($comment)) {
    header('Location: events.php');
    exit();
}

$pdo = new PDO("mysql:host=localhost;dbname=saudeosasco", "root", "golimar10*");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->prepare("INSERT INTO event_comments (event_id, user_id, comment) VALUES (?, ?, ?)");
$stmt->execute([$event_id, $user_id, $comment]);

header('Location: events.php');
exit();

