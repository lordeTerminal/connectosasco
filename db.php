<?php
// db.php — conexão única do app
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = '127.0.0.1';
$port = '3306';               // ajuste se seu MySQL não for 3306
$db   = 'saudeosasco';
$user = 'connecto';           // o usuário que FUNCIONOU no CMD
$pass = 'SenhaForte123!';     // a MESMA senha que você digitou no CMD

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

try {
  $pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);
} catch (PDOException $e) {
  // com esta linha: se der erro, veremos exatamente a causa
  die("Connection failed: " . $e->getMessage());
}
