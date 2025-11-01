<?php
session_start();
require_once 'db_connection.php';
require_once 'listar_produtos.php';

$titulo_pagina = "Feira Livre - Nem Estado, Nem Patrões, Apenas Pessoas";
$slogan = "Autogestão, Apoio Mútuo, Ação Direta";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo_pagina; ?></title>
    <style>
        body { 
            background: linear-gradient(135deg, #000000 0%, #434343 100%);
            font-family: 'Courier New', monospace;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        
        .black-banner {
            background: rgba(255,255,255,0.05);
            padding: 40px 20px;
            text-align: center;
            border-bottom: 3px solid #ff0000;
        }
        
        .anarchist-title {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        
        .anarchist-slogan {
            font-size: 1.1em;
            opacity: 0.8;
            margin-bottom: 20px;
            font-style: italic;
        }
        
        .anti-hierarchy {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 30px 0;
            flex-wrap: wrap;
        }
        
        .principle {
            background: rgba(255,0,0,0.2);
            padding: 15px;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            border: 2px solid #ff0000;
        }
        
        .product-card-anarchist {
            background: rgba(255,255,255,0.1);
            border: 1px solid #ff0000;
            border-radius: 0;
            padding: 20px;
            margin: 15px;
            backdrop-filter: blur(5px);
        }
        
        .direct-action-badge {
            background: #ff0000;
            color: black;
            padding: 5px 10px;
            font-size: 0.7em;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .mutual-aid {
            background: rgba(255,0,0,0.3);
            padding: 15px;
            margin: 20px;
            text-align: center;
            border-left: 5px solid #ff0000;
        }
    </style>
</head>
<body>
    <div class="black-banner">
        <h1 class="anarchist-title">⚫ Feira Livre</h1>
        <p class="anarchist-slogan"><?php echo $slogan; ?></p>
        
        <div class="anti-hierarchy">
            <div class="principle">
                <div>
                    <div style="font-size:2em;">🚫</div>
                    <small>Sem Chefes</small>
                </div>
            </div>
            <div class="principle">
                <div>
                    <div style="font-size:2em;">🤝</div>
                    <small>Apoio Mútuo</small>
                </div>
            </div>
            <div class="principle">
                <div>
                    <div style="font-size:2em;">⚙️</div>
                    <small>Autogestão</small>
                </div>
            </div>
        </div>
        
        <button style="background:#ff0000; color:black; border:none; padding:12px 25px; border-radius:0; font-size:16px; font-weight:bold; cursor:pointer; text-transform:uppercase;">
            🔥 Ação Direta Agora!
        </button>
    </div>

    <div class="mutual-aid">
        <strong>💪 NENHUMA HIERARQUIA É LEGÍTIMA!</strong><br>
        Organize-se horizontalmente - troque sem intermediários, produza sem patrões!
    </div>

    <!-- Produtos com linguagem anarquista -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; padding: 20px;">
        <?php foreach($produtos as $produto): ?>
            <div class="product-card-anarchist">
                <div style="display:flex; justify-content:space-between; align-items:start;">
                    <h3 style="margin:0; color:#ff0000; text-transform:uppercase;"><?php echo htmlspecialchars($produto['titulo']); ?></h3>
                    <span class="direct-action-badge">AÇÃO DIRETA</span>
                </div>
                <div style="font-size:1.3em; font-weight:bold; color:#fff; margin:15px 0;">
                    ⚫ R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                    <small style="font-size:0.7em; color:#ccc;">(acordo direto)</small>
                </div>
                <p style="color:#ccc; font-style:italic;"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <small>Produzido por <strong style="color:#ff0000;"><?php echo htmlspecialchars($produto['username']); ?></strong></small>
                    <button style="background:transparent; color:#ff0000; border:1px solid #ff0000; padding:8px 15px; cursor:pointer; text-transform:uppercase;">
                        🤝 Apoio Mútuo
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
