<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'Não logado']));
}

$data = json_decode(file_get_contents('php://input'), true);
$curso_id = $data['curso_id'];
$user_id = $_SESSION['user_id'];

// Verificar se já está matriculado
$stmt = $pdo->prepare("SELECT id FROM matriculas WHERE user_id = ? AND curso_id = ?");
$stmt->execute([$user_id, $curso_id]);
if ($stmt->fetch()) {
    die(json_encode(['success' => false, 'message' => 'Já matriculado neste curso']));
}

// Buscar preço do curso
$stmt = $pdo->prepare("SELECT preco, professor_id FROM cursos WHERE id = ?");
$stmt->execute([$curso_id]);
$curso = $stmt->fetch();

if (!$curso) {
    die(json_encode(['success' => false, 'message' => 'Curso não encontrado']));
}

// Inserir matrícula
$stmt = $pdo->prepare("INSERT INTO matriculas (user_id, curso_id) VALUES (?, ?)");
$stmt->execute([$user_id, $curso_id]);

// Registrar transação (70% para professor, 30% para plataforma)
$valor_professor = $curso['preco'] * 0.7;
$valor_plataforma = $curso['preco'] * 0.3;

$stmt = $pdo->prepare("INSERT INTO transacoes_cursos (user_id, curso_id, valor_total, valor_professor, valor_plataforma) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$user_id, $curso_id, $curso['preco'], $valor_professor, $valor_plataforma]);

echo json_encode(['success' => true, 'message' => 'Matriculado com sucesso']);
?>
