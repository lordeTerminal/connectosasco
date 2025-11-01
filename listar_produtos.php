<?php
require_once 'db_connection.php';

$categoria = $_GET['categoria'] ?? '';
$busca = $_GET['busca'] ?? '';
$localizacao = $_GET['localizacao'] ?? '';

$sql = "SELECT p.*, u.username, u.profile_picture 
        FROM produtos p 
        INNER JOIN users u ON p.user_id = u.user_id 
        WHERE p.disponivel = TRUE";

$params = [];

if (!empty($categoria)) {
    $sql .= " AND p.categoria = ?";
    $params[] = $categoria;
}

if (!empty($busca)) {
    $sql .= " AND (p.titulo LIKE ? OR p.descricao LIKE ? OR p.tags LIKE ?)";
    $searchTerm = "%$busca%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}

if (!empty($localizacao)) {
    $sql .= " AND p.localizacao LIKE ?";
    $params[] = "%$localizacao%";
}

$sql .= " ORDER BY p.data_criacao DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retorna JSON para AJAX ou HTML para página
if (isset($_GET['ajax'])) {
    header('Content-Type: application/json');
    echo json_encode($produtos);
    exit();
}
?>
