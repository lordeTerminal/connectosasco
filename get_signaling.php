<?php
session_start();
header('Content-Type: application/json');

$host='localhost'; $user='root'; $pass='golimar10*'; $db='saudeosasco';
$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);

$user_id = $_POST['user_id'];
$partner_id = $_POST['partner_id'];

$stmt = $pdo->prepare("SELECT * FROM video_signaling WHERE receiver_id=? AND sender_id=? ORDER BY timestamp ASC");
$stmt->execute([$user_id, $partner_id]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Depois de enviar, pode limpar (opcional)
$pdo->prepare("DELETE FROM video_signaling WHERE receiver_id=? AND sender_id=?")->execute([$user_id,$partner_id]);

echo json_encode($rows);
?>

