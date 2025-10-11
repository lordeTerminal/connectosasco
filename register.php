<?php
// CONEXÃO
require __DIR__ . '/db.php';

// REGISTRO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // pegue e valide campos
  $username = trim($_POST['username'] ?? '');
  $email    = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $role     = $_POST['role'] ?? 'Staff'; // precisa ser um dos ENUM: Doctor, Nurse, Admin, Staff

  if ($username === '' || $email === '' || $password === '') {
    die('Preencha username, email e senha.');
  }

  // hash seguro
  $hash = password_hash($password, PASSWORD_DEFAULT);

  try {
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $email, $hash, $role]);
    header('Location: index.php');
    exit;
  } catch (PDOException $e) {
    // mensagem amigável (ex.: email duplicado, etc.)
    die('Erro ao registrar: ' . $e->getMessage());
  }
}
