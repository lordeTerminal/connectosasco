<?php
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $host='localhost'; $user='root'; $pass='golimar10*'; $db='saudeosasco';
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);

    $stmt = $pdo->prepare("INSERT INTO video_signaling (sender_id,receiver_id,type,data) VALUES (?,?,?,?)");
    $stmt->execute([$_POST['sender_id'], $_POST['receiver_id'], $_POST['type'], $_POST['data']]);
}
?>

