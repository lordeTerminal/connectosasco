<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<form action="processar_curso.php" method="POST" enctype="multipart/form-data">
    <h2>📚 Criar Novo Curso</h2>
    
    <input type="text" name="titulo" placeholder="Título do Curso" required>
    <textarea name="descricao" placeholder="Descrição detalhada" rows="5" required></textarea>
    <input type="number" name="preco" placeholder="Preço (R$)" step="0.01" required>
    
    <select name="categoria" required>
        <option value="">Selecione a Categoria</option>
        <option value="economia_solidaria">Economia Solidária</option>
        <option value="tecnologia_revolucionaria">Tecnologia Revolucionária</option>
        <option value="politica_organizacao">Política e Organização</option>
        <option value="comercio_internacional">Comércio Internacional</option>
    </select>
    
    <h3>🎥 Aulas do Curso</h3>
    <div id="aulas-container">
        <div class="aula-item">
            <input type="text" name="aulas[0][titulo]" placeholder="Título da Aula 1" required>
            <input type="file" name="aulas[0][video]" accept="video/*" required>
            <textarea name="aulas[0][material]" placeholder="Material de apoio"></textarea>
        </div>
    </div>
    
    <button type="button" onclick="adicionarAula()">+ Adicionar Aula</button>
    <br><br>
    
    <button type="submit" style="background: #27ae60; color: white; padding: 15px 30px; border: none; border-radius: 10px; font-size: 1.2em;">
        🚀 Publicar Curso
    </button>
</form>

<script>
let aulaCount = 1;
function adicionarAula() {
    const container = document.getElementById('aulas-container');
    const newAula = document.createElement('div');
    newAula.className = 'aula-item';
    newAula.innerHTML = `
        <input type="text" name="aulas[${aulaCount}][titulo]" placeholder="Título da Aula ${aulaCount + 1}" required>
        <input type="file" name="aulas[${aulaCount}][video]" accept="video/*" required>
        <textarea name="aulas[${aulaCount}][material]" placeholder="Material de apoio"></textarea>
    `;
    container.appendChild(newAula);
    aulaCount++;
}
</script>
