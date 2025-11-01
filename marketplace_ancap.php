<?php
session_start();
require_once 'db_connection.php';
require_once 'listar_produtos.php';

$titulo_pagina = "Mercado Voluntário - Propriedade, Contratos e Liberdade";
$slogan = "Taxação é roubo, propriedade é liberdade";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo_pagina; ?></title>
    <style>
        body { 
            background: linear-gradient(135deg, #ffd700 0%, #d4af37 100%);
            font-family: 'Arial', sans-serif;
            color: #000;
            margin: 0;
            padding: 0;
        }
        
        .gold-banner {
            background: rgba(0,0,0,0.1);
            padding: 40px 20px;
            text-align: center;
            border-bottom: 3px solid #000;
        }
        
        .ancap-title {
            font-size: 2.5em;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        .ancap-slogan {
            font-size: 1.2em;
            margin-bottom: 20px;
            font-weight: bold;
        }
        
        .principles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin: 30px 20px;
        }
        
        .principle-item {
            background: rgba(255,255,255,0.8);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #000;
        }
        
        .product-card-ancap {
            background: rgba(255,255,255,0.9);
            border: 2px solid #000;
            border-radius: 10px;
            padding: 20px;
            margin: 15px;
            box-shadow: 5px 5px 0 #000;
        }
        
        .property-badge {
            background: #000;
            color: #ffd700;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.7em;
            font-weight: bold;
        }
        
        .nap-notice {
            background: rgba(0,0,0,0.8);
            color: #ffd700;
            padding: 15px;
            margin: 20px;
            text-align: center;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="gold-banner">
        <h1 class="ancap-title">💛 Mercado Voluntário</h1>
        <p class="ancap-slogan"><?php echo $slogan; ?></p>
        
        <div class="principles-grid">
            <div class="principle-item">
                <div style="font-size:2em;">🏛️</div>
                <strong>Estado Zero</strong>
            </div>
            <div class="principle-item">
                <div style="font-size:2em;">📜</div>
                <strong>Contratos Livres</strong>
            </div>
            <div class="principle-item">
                <div style="font-size:2em;">🛡️</div>
                <strong>Propriedade Privada</strong>
            </div>
            <div class="principle-item">
                <div style="font-size:2em;">🤝</div>
                <strong>Associação Voluntária</strong>
            </div>
        </div>
        
        <button style="background:#000; color:#ffd700; border:none; padding:12px 25px; border-radius:25px; font-size:16px; font-weight:bold; cursor:pointer;">
            💰 Empreenda sem Amarras!
        </button>
    </div>

    <div class="nap-notice">
        <strong>⚖️ PRINCÍPIO DA NÃO-AGRESSÃO:</strong><br>
        Toda interação deve ser voluntária - nenhum imposto, nenhuma regulação coercitiva!
    </div>

    <!-- Produtos com linguagem ancap -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; padding: 20px;">
        <?php foreach($produtos as $produto): ?>
            <div class="product-card-ancap">
                <div style="display:flex; justify-content:space-between; align-items:start;">
                    <h3 style="margin:0;"><?php echo htmlspecialchars($produto['titulo']); ?></h3>
                    <span class="property-badge">PROPRIEDADE</span>
                </div>
                <div style="font-size:1.5em; font-weight:bold; color:#000; margin:15px 0;">
                    💛 R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                    <small style="font-size:0.7em; color:#666;">(acordo voluntário)</small>
                </div>
                <p style="color:#666;"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <small>Propriedade de <strong><?php echo htmlspecialchars($produto['username']); ?></strong></small>
                    <button style="background:#000; color:#ffd700; border:none; padding:8px 15px; border-radius:15px; cursor:pointer; font-weight:bold;">
                        📜 Contratar
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
