<?php
session_start();
require_once 'db_connection.php';

// Buscar cursos
$stmt = $pdo->prepare("SELECT c.*, u.username as professor FROM cursos c INNER JOIN users u ON c.professor_id = u.user_id WHERE c.disponivel = 1 ORDER BY c.data_criacao DESC");
$stmt->execute();
$cursos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Universidade Revolucionária</title>
    <style>
        .curso-card {
            border: 2px solid #e74c3c;
            border-radius: 10px;
            padding: 20px;
            margin: 15px;
            background: white;
        }
        .btn-matricular {
            background: #e74c3c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>🎓 Universidade do Povo Trabalhador</h1>
    
    <div class="cursos-grid">
        <?php foreach($cursos as $curso): ?>
        <div class="curso-card">
            <h3><?php echo htmlspecialchars($curso['titulo']); ?></h3>
            <p><?php echo htmlspecialchars($curso['descricao']); ?></p>
            <p><strong>Professor:</strong> <?php echo htmlspecialchars($curso['professor']); ?></p>
            <p><strong>Preço:</strong> R$ <?php echo number_format($curso['preco'], 2); ?></p>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <button class="btn-matricular" onclick="matricular(<?php echo $curso['id']; ?>)">
                    🚀 Matricular-se
                </button>
            <?php else: ?>
                <p><a href="login.php">Faça login para se matricular</a></p>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if(isset($_SESSION['user_id'])): ?>
    <div style="text-align: center; margin: 30px;">
        <button onclick="criarCurso()" style="background: #27ae60; color: white; padding: 15px 30px; border: none; border-radius: 25px; font-size: 1.2em;">
            📚 Criar Meu Curso
        </button>
    </div>
    <?php endif; ?>

    <script>
    function matricular(cursoId) {
        fetch('matricular_curso.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({curso_id: cursoId})
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('✅ Matriculado com sucesso! Agora você tem acesso ao curso.');
                window.location.href = 'meus_cursos.php';
            } else {
                alert('❌ ' + data.message);
            }
        });
    }

    function criarCurso() {
        window.location.hpath = 'criar_curso.php';
    }
    </script>
</body>
</html>
