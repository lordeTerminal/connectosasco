<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'db_connection.php';

$titulo_pagina = "Mercado Local - Conectando Produtores e Consumidores";
$descricao_pagina = "Plataforma de comércio direto entre trabalhadores e comunidade";

// Buscar produtos
require_once 'listar_produtos.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?></title>
    <style>
        /* Estilo "neutro" que não assuste os capitalistas */
        .marketplace-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 20px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .hero-title {
            font-size: 2.5em;
            margin-bottom: 15px;
            font-weight: 300;
        }
        
        .hero-subtitle {
            font-size: 1.2em;
            opacity: 0.9;
            margin-bottom: 25px;
        }
        
        .filters {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .filters input, .filters select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            flex: 1;
            min-width: 150px;
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        
        .product-card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: white;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .product-image {
            width: 100%;
            height: 200px;
            background: #f5f5f5;
            border-radius: 8px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 14px;
        }
        
        .product-title {
            font-size: 1.2em;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }
        
        .product-price {
            font-size: 1.4em;
            font-weight: 700;
            color: #2c5530;
            margin-bottom: 10px;
        }
        
        .product-seller {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            font-size: 0.9em;
            color: #666;
        }
        
        .seller-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #ddd;
        }
        
        .add-product-btn {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        }
        
        .add-product-btn:hover {
            background: #45a049;
        }
        
        /* Mensagens subliminares revolucionárias */
        .revolutionary-quote {
            text-align: center;
            margin: 40px 0;
            padding: 20px;
            background: #fff3cd;
            border-radius: 8px;
            border-left: 4px solid #ffc107;
            font-style: italic;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="marketplace-container">
        <!-- Seção Hero - Atraente para todos -->
        <div class="hero-section">
            <h1 class="hero-title">💼 Mercado do Trabalhador</h1>
            <p class="hero-subtitle">Compre direto de quem produz. Valorize o trabalho real.</p>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <button class="add-product-btn" onclick="showProductForm()">
                    ➕ Anunciar Meu Produto/Serviço
                </button>
            <?php else: ?>
                <p>
                    <a href="login.php" style="color: white; text-decoration: underline;">
                        Faça login para começar a vender
                    </a>
                </p>
            <?php endif; ?>
        </div>

        <!-- Filtros -->
        <div class="filters">
            <input type="text" id="searchInput" placeholder="🔍 Buscar produtos, serviços..." onkeyup="filterProducts()">
            <select id="categoryFilter" onchange="filterProducts()">
                <option value="">Todas as categorias</option>
                <option value="alimentos">🍞 Alimentos</option>
                <option value="artesanato">🎨 Artesanato</option>
                <option value="servicos">🔧 Serviços</option>
                <option value="aulas">📚 Aulas/Cursos</option>
                <option value="outros">📦 Outros</option>
            </select>
            <input type="text" id="locationFilter" placeholder="📍 Localização" onkeyup="filterProducts()">
        </div>

        <!-- Citação subliminar -->
        <div class="revolutionary-quote">
            "Quando o trabalhador controla seu produto, controla seu destino."
            <br><small>- Princípio do Comércio Justo</small>
        </div>

        <!-- Grid de Produtos -->
        <div class="products-grid" id="productsGrid">
            <?php if(empty($produtos)): ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                    <h3>📦 Nenhum produto encontrado</h3>
                    <p>Seja o primeiro a anunciar seu trabalho!</p>
                </div>
            <?php else: ?>
                <?php foreach($produtos as $produto): ?>
                    <div class="product-card" data-category="<?php echo $produto['categoria']; ?>" 
                         data-location="<?php echo strtolower($produto['localizacao']); ?>"
                         data-title="<?php echo strtolower($produto['titulo'] . ' ' . $produto['tags']); ?>">
                        
                        <div class="product-image">
                            <?php if(!empty($produto['foto_principal'])): ?>
                                <img src="<?php echo $produto['foto_principal']; ?>" alt="<?php echo $produto['titulo']; ?>" style="width:100%; height:100%; object-fit:cover; border-radius:8px;">
                            <?php else: ?>
                                🛍️ Imagem do Produto
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-title"><?php echo htmlspecialchars($produto['titulo']); ?></div>
                        <div class="product-price">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></div>
                        
                        <div class="product-seller">
                            <div class="seller-avatar">
                                <?php if(!empty($produto['profile_picture'])): ?>
                                    <img src="<?php echo $produto['profile_picture']; ?>" alt="Vendedor" style="width:100%; height:100%; border-radius:50%;">
                                <?php endif; ?>
                            </div>
                            <span>por <?php echo htmlspecialchars($produto['username']); ?></span>
                        </div>
                        
                        <p style="font-size: 0.9em; color: #666; margin-bottom: 15px;">
                            <?php echo strlen($produto['descricao']) > 100 ? substr($produto['descricao'], 0, 100) . '...' : $produto['descricao']; ?>
                        </p>
                        
                        <?php if(!empty($produto['localizacao'])): ?>
                            <div style="font-size: 0.8em; color: #888; margin-bottom: 15px;">
                                📍 <?php echo htmlspecialchars($produto['localizacao']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <button onclick="contactSeller(<?php echo $produto['user_id']; ?>, <?php echo $produto['produto_id']; ?>)" 
                                style="width:100%; padding:10px; background:#007bff; color:white; border:none; border-radius:5px; cursor:pointer;">
                            💬 Entrar em Contato
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal para adicionar produto (será implementado) -->
    <div id="productFormModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
        <!-- Conteúdo do modal aqui -->
    </div>

    <script>
        function filterProducts() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const category = document.getElementById('categoryFilter').value;
            const location = document.getElementById('locationFilter').value.toLowerCase();
            
            const products = document.querySelectorAll('.product-card');
            
            products.forEach(product => {
                const matchesSearch = product.dataset.title.includes(search);
                const matchesCategory = !category || product.dataset.category === category;
                const matchesLocation = !location || product.dataset.location.includes(location);
                
                if (matchesSearch && matchesCategory && matchesLocation) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        }
        
function showProductForm() {
	window.location.href = 'criar_produto_form.php';
            //alert('Funcionalidade em desenvolvimento! Em breve você poderá anunciar seus produtos.');
            // Redirecionar para página de cadastro de produto
            // window.location.href = 'criar_produto.php';
        }
        
        function contactSeller(sellerId, productId) {
            // Redirecionar para chat com o vendedor
            window.location.href = `chat.php?partner_id=${sellerId}&product_id=${productId}`;
        }
        
        // Mensagem subliminar no console 😉
        console.log('💡 Você sabia? Quando os trabalhadores controlam os meios de produção, a sociedade é mais justa para todos.');
    </script>
</body>
</html>
