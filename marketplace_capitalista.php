<?php
session_start();
require_once 'db_connection.php';
require_once 'listar_produtos.php';

$titulo_pagina = "EmpreendaJá - Sua Plataforma de Empreendedorismo Digital";
$slogan = "Transforme seu hobby em negócio! Seja seu próprio chefe!";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo_pagina; ?></title>
    <style>
        /* Estilo CAPITALISTA - Luxo e sucesso financeiro */
        body { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Montserrat', sans-serif;
            color: #333;
        }
        
        .hero-section {
            background: white;
            padding: 80px 20px;
            text-align: center;
            border-radius: 15px;
            margin: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .hero-title {
            font-size: 3em;
            background: linear-gradient(135deg, #ff6b6b, #feca57);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }
        
        .capitalist-slogan {
            font-size: 1.3em;
            color: #666;
            margin-bottom: 30px;
        }
        
        .money-stats {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 40px 0;
        }
        
        .stat-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #28a745;
        }
        
        .product-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
        }
        
        .profit-badge {
            background: #ffd700;
            color: #000;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <h1 class="hero-title">💰 EmpreendaJá</h1>
        <p class="capitalist-slogan"><?php echo $slogan; ?></p>
        
        <div class="money-stats">
            <div class="stat-item">
                <div class="stat-number">R$ 2.5M+</div>
                <div>Faturado por Nossos Empreendedores</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">5.000+</div>
                <div>Negócios Lucrativos</div>
            </div>
        </div>
        
        <button style="background:linear-gradient(135deg, #ff6b6b, #feca57); color:white; border:none; padding:15px 30px; border-radius:25px; font-size:16px; cursor:pointer;">
            🚀 Comece a Faturar Agora!
        </button>
    </div>

    <!-- Produtos com linguagem capitalista -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; padding: 20px;">
        <?php foreach($produtos as $produto): ?>
            <div class="product-card">
                <div style="display:flex; justify-content:space-between; align-items:start;">
                    <h3 style="margin:0;"><?php echo htmlspecialchars($produto['titulo']); ?></h3>
                    <span class="profit-badge">OPORTUNIDADE</span>
                </div>
                <div style="font-size:1.5em; font-weight:bold; color:#28a745; margin:15px 0;">
                    R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                </div>
                <p style="color:#666;"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <small>por <?php echo htmlspecialchars($produto['username']); ?></small>
                    <button style="background:#007bff; color:white; border:none; padding:8px 15px; border-radius:15px; cursor:pointer;">
                        💼 Investir
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
