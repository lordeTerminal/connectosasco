<?php
session_start();
require_once 'db_connection.php';

$aula_id = $_GET['id'] ?? 0;

// Verificar se usuário tem acesso
$stmt = $pdo->prepare("
    SELECT a.*, c.titulo as curso_titulo 
    FROM aulas a 
    INNER JOIN cursos c ON a.curso_id = c.id 
    INNER JOIN matriculas m ON m.curso_id = c.id 
    WHERE a.id = ? AND m.user_id = ?
");
$stmt->execute([$aula_id, $_SESSION['user_id']]);
$aula = $stmt->fetch();

if (!$aula) {
    die("Aula não encontrada ou acesso negado");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($aula['titulo']); ?></title>
</head>
<body>
    <h1><?php echo htmlspecialchars($aula['curso_titulo']); ?></h1>
    <h2><?php echo htmlspecialchars($aula['titulo']); ?></h2>
    
    <div class="video-container">
        <video controls width="100%">
            <source src="<?php echo htmlspecialchars($aula['video_url']); ?>" type="video/mp4">
            Seu navegador não suporta o elemento de vídeo.
        </video>
    </div>
    
    <div class="material-texto">
        <h3>Material de Apoio</h3>
        <p><?php echo nl2br(htmlspecialchars($aula['material_texto'])); ?></p>
    </div>
    
    <div class="navegacao-aulas">
        <button onclick="proximaAula()">Próxima Aula →</button>
    </div>

    <script>
    function proximaAula() {
        // Lógica para ir para próxima aula
        window.location.href = 'aula.php?id=<?php echo $aula_id + 1; ?>';
    }
    </script>
</body>
</html>
