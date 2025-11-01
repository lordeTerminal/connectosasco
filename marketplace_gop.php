<?php
session_start();
require_once 'db_connection.php';
require_once 'listar_produtos.php';

$titulo_pagina = "Patriot Marketplace - Government-Free American Commerce";
$slogan = "No Taxes, No Regulations, Pure Freedom Trading";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?></title>
    <style>
        /* Estética Patriótica Americana - Azul, Vermelho, Branco */
        body { 
            background: linear-gradient(135deg, #002868 0%, #FFFFFF 50%, #BF0A30 100%);
            font-family: 'Times New Roman', 'Georgia', serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .gop-hero {
            background: rgba(255,255,255,0.95);
            padding: 50px 20px;
            text-align: center;
            border-bottom: 5px solid #BF0A30;
        }
        
        .gop-title {
            font-size: 2.8em;
            color: #002868;
            margin-bottom: 15px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .gop-subtitle {
            font-size: 1.3em;
            color: #666;
            margin-bottom: 25px;
            font-style: italic;
        }
        
        .freedom-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 30px 20px;
        }
        
        .freedom-stat {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: 2px solid #BF0A30;
        }
        
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #002868;
        }
        
        .product-card-gop {
            background: white;
            border: 2px solid #002868;
            border-radius: 8px;
            padding: 20px;
            margin: 15px;
            transition: transform 0.3s ease;
            position: relative;
        }
        
        .product-card-gop:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,40,104,0.2);
        }
        
        .patriot-badge {
            background: #BF0A30;
            color: white;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .freedom-message {
            background: rgba(191,10,48,0.1);
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #002868;
        }
        
        .payment-methods-gop {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }
        
        .payment-icon-gop {
            width: 50px;
            height: 50px;
            background: #f5f5f5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
            border: 1px solid #ddd;
        }
        
        /* Estilo Conservador */
        .conservative-style {
            background: linear-gradient(45deg, #002868, #BF0A30);
            color: white;
            padding: 15px;
            margin: 10px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .eagle-icon {
            font-size: 2em;
            margin: 10px;
        }
    </style>
</head>
<body>
    <!-- Seção Herói -->
    <div class="gop-hero">
        <div class="eagle-icon">🦅</div>
        <h1 class="gop-title">PATRIOT MARKETPLACE</h1>
        <p class="gop-subtitle"><?php echo $slogan; ?></p>
        
        <!-- Estatísticas da Liberdade -->
        <div class="freedom-stats">
            <div class="freedom-stat">
                <div class="stat-number">0%</div>
                <div>Government Taxes</div>
            </div>
            <div class="freedom-stat">
                <div class="stat-number">100%</div>
                <div>Free Market</div>
            </div>
            <div class="freedom-stat">
                <div class="stat-number">2A</div>
                <div>Protected</div>
            </div>
        </div>
        
        <!-- Métodos de Pagamento -->
        <div class="payment-methods-gop">
            <div class="payment-icon-gop">💵</div>
            <div class="payment-icon-gop">💳</div>
            <div class="payment-icon-gop">🏛️</div>
            <div class="payment-icon-gop">🪙</div>
        </div>
        
        <button style="background:#002868; color:white; border:none; padding:15px 30px; border-radius:25px; font-size:16px; cursor:pointer; margin-top:20px; font-weight:bold;">
            🚀 START TRADING FREE
        </button>
    </div>

    <!-- Mensagem Conservadora -->
    <div class="conservative-style">
        DON'T TREAD ON ME - FREE MARKET CAPITALISM WORKS!
    </div>

    <!-- Informação de Cooperação -->
    <div class="freedom-message">
        <strong>🤝 AMERICAN-BRAZILIAN FREE TRADE!</strong><br>
        Direct Dollar-Free Transactions, No Government Interference!
    </div>

    <!-- Grade de Produtos -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; padding: 20px;">
        <?php foreach($produtos as $produto): ?>
            <div class="product-card-gop">
                <div style="display:flex; justify-content:space-between; align-items:start;">
                    <h3 style="margin:0; color:#002868;"><?php echo htmlspecialchars($produto['titulo']); ?></h3>
                    <span class="patriot-badge">FREE TRADE</span>
                </div>
                
                <div style="font-size:1.4em; font-weight:bold; color:#2c5530; margin:15px 0;">
                    💰 R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                    <small style="font-size:0.7em; color:#666;">(USD payments available)</small>
                </div>
                
                <p style="color:#666; line-height:1.5;"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:15px;">
                    <small>Producer: <strong><?php echo htmlspecialchars($produto['username']); ?></strong></small>
                    <button style="background:#BF0A30; color:white; border:none; padding:8px 15px; border-radius:15px; cursor:pointer; font-size:0.9em; font-weight:bold;">
                        CONTACT
                    </button>
                </div>
                
                <!-- Características GOP -->
                <div style="margin-top:15px; padding-top:15px; border-top:1px solid #eee;">
                    <small style="color:#666;">
                        ✅ Bitcoin Accepted | ✅ Tax-Free Trading | ✅ English-Portuguese Support
                    </small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Seção de Produtos Específicos para GOP -->
    <div style="background:white; padding:40px 20px; margin:20px; border-radius:10px; text-align:center;">
        <h2 style="color:#002868;">🦅 PATRIOTIC PRODUCTS</h2>
        <p>American-Made, Freedom-Focused, Government-Free</p>
        
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-top:30px;">
            <div>
                <h4>🇺🇸 American Values</h4>
                <ul style="text-align:left;">
                    <li>2A Supporting Products</li>
                    <li>Constitutional Literature</li>
                    <li>Liberty-Focused Goods</li>
                </ul>
            </div>
            <div>
                <h4>🛡️ Freedom Economy</h4>
                <ul style="text-align:left;">
                    <li>Tax-Free Transactions</li>
                    <li>Regulation-Free Commerce</li>
                    <li>Free Market Principles</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Mensagem Final Conservadora -->
    <div class="conservative-style">
        MAKE AMERICA FREE AGAIN - GOVERNMENT OUT OF COMMERCE!
    </div>

    <script>
        // Funções para o Mercado GOP
        function contactSeller(sellerId, productId) {
            // Integração com sistemas de pagamento libertários
            window.location.href = `chat.php?partner_id=${sellerId}&product_id=${productId}&lang=en&type=gop`;
        }
        
        // Conversão para Dólar
        function convertToDollar(realPrice) {
            // API de câmbio em tempo real
            fetch('https://api.exchangerate-api.com/v4/latest/BRL')
                .then(response => response.json())
                .then(data => {
                    const dollarPrice = realPrice * data.rates.USD;
                    return dollarPrice.toFixed(2);
                });
        }
        
        // Saudação Patriótica no Console
        console.log('Welcome to Patriot Marketplace - Platform for Free Americans!');
        
        // Função para mostrar citações conservadoras
        function showConservativeQuote() {
            const quotes = [
                "Don't Tread On Me!",
                "Taxation is Theft!",
                "Free Markets, Free People!",
                "Government is not the solution to our problem; government is the problem!"
            ];
            const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
            alert(randomQuote);
        }
        
        // Foco em produtos da 2ª Emenda
        function showSecondAmendmentFocus() {
            const secondAmendmentProducts = [
                "Firearms Accessories",
                "Self-Defense Training",
                "Constitutional Law Books",
                "Patriotic Apparel"
            ];
            // Foco em produtos que ressoam com a base GOP
        }
    </script>
</body>
</html>
