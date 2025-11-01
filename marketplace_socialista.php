<?php
session_start();
require_once 'db_connection.php';
require_once 'listar_produtos.php';

$titulo_pagina = "Mercado Coletivo - Os Meios de Produção nas Mãos dos Trabalhadores";
$slogan = "Produza conforme sua capacidade, consuma conforme sua necessidade";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo_pagina; ?></title>
    <style>
        /* Estilo SOCIALISTA - Coletivo e revolucionário */
        body { 
            background: linear-gradient(135deg, #ff6b6b 0%, #c44569 100%);
            font-family: 'Roboto', sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        
        .red-banner {
            background: rgba(0,0,0,0.3);
            padding: 40px 20px;
            text-align: center;
            border-bottom: 5px solid #ffd700;
        }
        
        .revolution-title {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .socialist-slogan {
            font-size: 1.2em;
            opacity: 0.9;
            margin-bottom: 20px;
        }
        
        .collective-stats {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 30px 0;
            flex-wrap: wrap;
        }
        
        .collective-stat {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            backdrop-filter: blur(10px);
        }
        
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #ffd700;
        }
        
        .product-card-socialist {
            background: rgba(255,255,255,0.95);
            color: #333;
            border-radius: 10px;
            padding: 20px;
            margin: 15px;
            border-left: 5px solid #ff6b6b;
        }
        
        .worker-badge {
            background: #c44569;
            color: white;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 0.8em;
        }
        
        .solidarity-message {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.3);
        }
    </style>
</head>
<body>
    <div class="red-banner">
        <h1 class="revolution-title">⚒️ Mercado Coletivo</h1>
        <p class="socialist-slogan"><?php echo $slogan; ?></p>
        
        <div class="collective-stats">
            <div class="collective-stat">
                <div class="stat-number">0%</div>
                <div>Lucro dos Patrões</div>
            </div>
            <div class="collective-stat">
                <div class="stat-number">100%</div>
                <div>Valor para o Trabalhador</div>
            </div>
            <div class="collective-stat">
                <div class="stat-number">∞</div>
                <div>Solidariedade de Classe</div>
            </div>
        </div>
        
        <button style="background:#ffd700; color:#c44569; border:none; padding:15px 30px; border-radius:25px; font-size:16px; font-weight:bold; cursor:pointer;">
            🚩 Junte-se à Luta!
        </button>
    </div>

    <div class="solidarity-message">
        <strong>💪 TRABALHADORES DO MUNDO, UNI-VOS!</strong><br>
        Aqui não há exploradores - apenas produtores e consumidores conscientes!
    </div>

    <!-- Produtos com linguagem socialista -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; padding: 20px;">
        <?php foreach($produtos as $produto): ?>
            <div class="product-card-socialist">
                <div style="display:flex; justify-content:space-between; align-items:start;">
                    <h3 style="margin:0; color:#c44569;"><?php echo htmlspecialchars($produto['titulo']); ?></h3>
                    <span class="worker-badge">TRABALHO REAL</span>
                </div>
                <div style="font-size:1.3em; font-weight:bold; color:#2c5530; margin:15px 0;">
                    💰 R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                    <small style="font-size:0.7em; color:#666;">(valor justo)</small>
                </div>
                <p style="color:#666;"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <small>Produzido por <strong><?php echo htmlspecialchars($produto['username']); ?></strong></small>
                    <button style="background:#c44569; color:white; border:none; padding:8px 15px; border-radius:15px; cursor:pointer;">
                        🤝 Solidarizar-se
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
