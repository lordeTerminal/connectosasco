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
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');

if (empty($title) || empty($description)) {
    header('Location: events.php');
    exit();
}

$pdo = new PDO("mysql:host=localhost;dbname=saudeosasco", "root", "golimar10*");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Checa se o usuário tem créditos
$stmt = $pdo->prepare("SELECT credits FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$credits = (int)$stmt->fetchColumn();

if ($credits <= 0) {
    header('Location: events.php');
    exit();
}

// Insere o novo evento
$stmt = $pdo->prepare("INSERT INTO events (user_id, title, description, event_date) VALUES (?, ?, ?, NOW())");
$stmt->execute([$user_id, $title, $description]);

// Deduz 1 crédito do usuário
$stmt = $pdo->prepare("UPDATE users SET credits = credits - 1 WHERE user_id = ?");
$stmt->execute([$user_id]);

header('Location: events.php');
exit();

