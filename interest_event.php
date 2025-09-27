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

if ($event_id <= 0) {
    header('Location: events.php');
    exit();
}

$pdo = new PDO("mysql:host=localhost;dbname=saudeosasco", "root", "golimar10*");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Verifica se já existe interesse
$stmt = $pdo->prepare("SELECT 1 FROM event_interests WHERE event_id = ? AND user_id = ?");
$stmt->execute([$event_id, $user_id]);
$interested = $stmt->fetchColumn();

if ($interested) {
    // Remove interesse
    $stmt = $pdo->prepare("DELETE FROM event_interests WHERE event_id = ? AND user_id = ?");
    $stmt->execute([$event_id, $user_id]);
} else {
    // Adiciona interesse
    $stmt = $pdo->prepare("INSERT INTO event_interests (event_id, user_id) VALUES (?, ?)");
    $stmt->execute([$event_id, $user_id]);
}

header('Location: events.php');
exit();

