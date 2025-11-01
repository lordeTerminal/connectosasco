<?php
session_start();
require_once 'db_connection.php';

$professor_id = $_SESSION['user_id'];

// Buscar cursos do professor
$stmt = $pdo->prepare("SELECT * FROM cursos WHERE professor_id = ?");
$stmt->execute([$professor_id]);
$cursos = $stmt->fetchAll();

// Calcular ganhos totais
$stmt = $pdo->prepare("SELECT SUM(valor_professor) as total_ganhos FROM transacoes_cursos WHERE curso_id IN (SELECT id FROM cursos WHERE professor_id = ?)");
$stmt->execute([$professor_id]);
$ganhos = $stmt->fetch();
?>

<h2>💰 Meus Ganhos Revolucionários</h2>
<p><strong>Total Arrecadado:</strong> R$ <?php echo number_format($ganhos['total_ganhos'], 2); ?></p>

<h3>Meus Cursos</h3>
<?php foreach($cursos as $curso): ?>
    <div class="curso-item">
        <h4><?php echo htmlspecialchars($curso['titulo']); ?></h4>
        <p>Preço: R$ <?php echo number_format($curso['preco'], 2); ?></p>
        
        <?php
        // Contar matriculados
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM matriculas WHERE curso_id = ?");
        $stmt->execute([$curso['id']]);
        $matriculados = $stmt->fetch();
        ?>
        <p>Alunos Matriculados: <?php echo $matriculados['total']; ?></p>
    </div>
<?php endforeach; ?>
