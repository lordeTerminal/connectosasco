<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anunciar Produto - Mercado do Trabalhador</title>
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        textarea {
            height: 120px;
            resize: vertical;
        }
        
        .btn-submit {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background 0.3s ease;
        }
        
        .btn-submit:hover {
            background: #45a049;
        }
        
        .message {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 style="text-align: center; margin-bottom: 30px;">🛠️ Anunciar Meu Produto/Serviço</h2>
        
        <?php if(isset($_SESSION['erro'])): ?>
            <div class="message error">
                <?php echo $_SESSION['erro']; unset($_SESSION['erro']); ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['sucesso'])): ?>
            <div class="message success">
                <?php echo $_SESSION['sucesso']; unset($_SESSION['sucesso']); ?>
            </div>
        <?php endif; ?>

        <form action="criar_produto.php" method="POST">
            <div class="form-group">
                <label for="titulo">📦 Título do Anúncio *</label>
                <input type="text" id="titulo" name="titulo" required 
                       placeholder="Ex: Pão caseiro integral, Aula de matemática, Conserto de celular...">
            </div>
            
            <div class="form-group">
                <label for="descricao">📝 Descrição Detalhada</label>
                <textarea id="descricao" name="descricao" 
                          placeholder="Descreva seu produto ou serviço..."></textarea>
            </div>
            
            <div class="form-group">
                <label for="preco">💰 Preço (R$) *</label>
                <input type="number" id="preco" name="preco" step="0.01" min="0.01" required 
                       placeholder="0,00">
            </div>
            
            <div class="form-group">
                <label for="categoria">📂 Categoria *</label>
                <select id="categoria" name="categoria" required>
                    <option value="">Selecione uma categoria</option>
                    <option value="alimentos">🍞 Alimentos</option>
                    <option value="artesanato">🎨 Artesanato</option>
                    <option value="servicos">🔧 Serviços</option>
                    <option value="aulas">📚 Aulas/Cursos</option>
                    <option value="outros">📦 Outros</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="localizacao">📍 Localização</label>
                <input type="text" id="localizacao" name="localizacao" 
                       placeholder="Ex: Osasco - Centro, Vila Yara...">
            </div>
            
            <div class="form-group">
                <label for="tags">🏷️ Tags/Palavras-chave</label>
                <input type="text" id="tags" name="tags" 
                       placeholder="Ex: pão caseiro, integral, artesanal (separado por vírgula)">
            </div>
            
            <button type="submit" class="btn-submit">✅ Anunciar Meu Produto</button>
        </form>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="marketplace.php" style="color: #666; text-decoration: none;">← Voltar ao Marketplace</a>
        </div>
    </div>
</body>
</html>
