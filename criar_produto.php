<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$titulo = trim($_POST['titulo'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$preco = floatval($_POST['preco'] ?? 0);
$categoria = $_POST['categoria'] ?? 'outros';
$localizacao = trim($_POST['localizacao'] ?? '');
$tags = trim($_POST['tags'] ?? '');

if (empty($titulo) || $preco <= 0) {
    $_SESSION['erro'] = "Título e preço são obrigatórios!";
    header('Location: marketplace.php');
    exit();
}

try {
    $stmt = $pdo->prepare("INSERT INTO produtos (user_id, titulo, descricao, preco, categoria, localizacao, tags) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $titulo, $descricao, $preco, $categoria, $localizacao, $tags]);
    
    $_SESSION['sucesso'] = "Produto cadastrado com sucesso!";
    header('Location: marketplace.php');
    
} catch (PDOException $e) {
    $_SESSION['erro'] = "Erro ao cadastrar produto: " . $e->getMessage();
    header('Location: marketplace.php');
}
?>
