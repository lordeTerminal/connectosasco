<?php
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

// Conexão com o banco
$host = 'localhost';
$username = 'root';
$password = 'golimar10*';
$database = 'saudeosasco';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Verifica se usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Valida o post_id
$post_id = isset($_POST['post_id']) ? filter_var($_POST['post_id'], FILTER_VALIDATE_INT) : null;

if ($post_id === false || $post_id === null) {
    die('Post inválido.');
}

try {
    // Verifica se o usuário já curtiu o post
    $stmt = $pdo->prepare("SELECT * FROM post_likes WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$user_id, $post_id]);
    $like = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($like) {
        // Se já curtiu, remove (descurtir)
        $stmt = $pdo->prepare("DELETE FROM post_likes WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$user_id, $post_id]);
    } else {
        // Se não curtiu ainda, adiciona
        $stmt = $pdo->prepare("INSERT INTO post_likes (user_id, post_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $post_id]);
    }
} catch (PDOException $ex) {
    die("Erro ao curtir/descurtir: " . $ex->getMessage());
}

// Volta para o profile
header('Location: profile.php');
exit();

