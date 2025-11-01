<?php
session_start();
require_once 'db_connection.php';
require_once 'listar_produtos.php';

$titulo_pagina = "Workers Cooperative - Billionaires Shouldn't Exist";
$slogan = "Tax the Rich, Empower Workers, Community Over Corporations";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?></title>
    <style>
        /* Estética Progressista - Azul claro, branco, verde */
        body { 
            background: linear-gradient(135deg, #1E88E5 0%, #FFFFFF 50%, #4CAF50 100%);
            font-family: 'Arial', 'Helvetica', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .bernie-hero {
            background: rgba(255,255,255,0.95);
            padding: 50px 20px;
            text-align: center;
            border-bottom: 5px solid #4CAF50;
        }
        
        .bernie-title {
            font-size: 2.5em;
            color: #1E88E5;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .bernie-subtitle {
            font-size: 1.3em;
            color: #666;
            margin-bottom: 25px;
            font-style: italic;
        }
        
        .progressive-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 30px 20px;
        }
        
        .progressive-stat {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: 2px solid #4CAF50;
        }
        
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #1E88E5;
        }
        
        .product-card-bernie {
            background: white;
            border: 2px solid #1E88E5;
            border-radius: 8px;
            padding: 20px;
            margin: 15px;
            transition: transform 0.3s ease;
        }
        
        .product-card-bernie:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(30,136,229,0.2);
        }
        
        .progressive-badge {
            background: #4CAF50;
            color: white;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: bold;
        }
        
        .solidarity-message {
            background: rgba(76,175,80,0.1);
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #1E88E5;
        }
        
        .payment-methods-bernie {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }
        
        .payment-icon-bernie {
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
        
        /* Estilo Progressista */
        .progressive-style {
            background: linear-gradient(45deg, #1E88E5, #4CAF50);
            color: white;
            padding: 15px;
            margin: 10px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        
        .fist-icon {
            font-size: 2em;
            margin: 10px;
        }
        
        .tax-the-rich {
            background: #FF5252;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            margin: 10px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="bernie-hero">
        <div class="fist-icon">✊</div>
        <h1 class="bernie-title">WORKERS COOPERATIVE</h1>
        <p class="bernie-subtitle"><?php echo $slogan; ?></p>
        
        <!-- Progressive Stats -->
        <div class="progressive-stats">
            <div class="progressive-stat">
                <div class="stat-number">99%</div>
                <div>Worker Owned</div>
            </div>
            <div class="progressive-stat">
                <div class="stat-number">0.1%</div>
                <div>Billionaire Free</div>
            </div>
            <div class="progressive-stat">
                <div class="stat-number">100%</div>
                <div>Union Strong</div>
            </div>
        </div>
        
        <!-- Tax the Rich Badge -->
        <div class="tax-the-rich">
            TAX THE RICH - MEDICARE FOR ALL
        </div>
        
        <!-- Payment Methods -->
        <div class="payment-methods-bernie">
            <div class="payment-icon-bernie">🌹</div>
            <div class="payment-icon-bernie">💼</div>
            <div class="payment-icon-bernie">🤝</div>
            <div class="payment-icon-bernie">⚖️</div>
        </div>
        
        <button style="background:#1E88E5; color:white; border:none; padding:15px 30px; border-radius:25px; font-size:16px; cursor:pointer; margin-top:20px; font-weight:bold;">
            ✊ JOIN THE MOVEMENT
        </button>
    </div>

    <!-- Solidarity Message -->
    <div class="progressive-style">
        NOT ME, US - WORKERS OF THE WORLD UNITE!
    </div>

    <!-- Cooperation Info -->
    <div class="solidarity-message">
        <strong>🤝 GLOBAL WORKER SOLIDARITY!</strong><br>
        Direct Worker-to-Worker Trade, No Corporate Intermediaries!
    </div>

    <!-- Products Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; padding: 20px;">
        <?php foreach($produtos as $produto): ?>
            <div class="product-card-bernie">
                <div style="display:flex; justify-content:space-between; align-items:start;">
                    <h3 style="margin:0; color:#1E88E5;"><?php echo htmlspecialchars($produto['titulo']); ?></h3>
                    <span class="progressive-badge">WORKER OWNED</span>
                </div>
                
                <div style="font-size:1.4em; font-weight:bold; color:#2c5530; margin:15px 0;">
                    💰 R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                    <small style="font-size:0.7em; color:#666;">(fair worker wage)</small>
                </div>
                
                <p style="color:#666; line-height:1.5;"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:15px;">
                    <small>Worker-Owner: <strong><?php echo htmlspecialchars($produto['username']); ?></strong></small>
                    <button style="background:#4CAF50; color:white; border:none; padding:8px 15px; border-radius:15px; cursor:pointer; font-size:0.9em; font-weight:bold;">
                        SOLIDARITY
                    </button>
                </div>
                
                <!-- Progressive Features -->
                <div style="margin-top:15px; padding-top:15px; border-top:1px solid #eee;">
                    <small style="color:#666;">
                        ✅ Union-Made | ✅ Living Wage | ✅ Climate Conscious
                    </small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Worker Solidarity Section -->
    <div style="background:white; padding:40px 20px; margin:20px; border-radius:10px; text-align:center;">
        <h2 style="color:#1E88E5;">🌍 GLOBAL WORKER SOLIDARITY</h2>
        <p>Connecting American Workers with Brazilian Workers - No Billionaire Middlemen</p>
        
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-top:30px;">
            <div>
                <h4>🇺🇸 American Workers</h4>
                <ul style="text-align:left;">
                    <li>Union-Led Cooperatives</li>
                    <li>Living Wage Guaranteed</li>
                    <li>Healthcare Focused</li>
                </ul>
            </div>
            <div>
                <h4>🇧🇷 Brazilian Workers</h4>
                <ul style="text-align:left;">
                    <li>Community Cooperatives</li>
                    <li>Fair Trade Principles</li>
                    <li>Solidarity Economy</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Final Progressive Message -->
    <div class="progressive-style">
        HEALTHCARE IS A HUMAN RIGHT - EDUCATION IS A HUMAN RIGHT
    </div>

    <script>
        // Functions for Bernie Marketplace
        function contactSeller(sellerId, productId) {
            window.location.href = `chat.php?partner_id=${sellerId}&product_id=${productId}&lang=en&type=progressive`;
        }
        
        // Fair Wage Calculator
        function calculateLivingWage(price) {
            // Ensure workers get living wage
            const fairPrice = price * 1.3; // 30% above for living wage
            return fairPrice.toFixed(2);
        }
        
        console.log('Welcome to Workers Cooperative - Platform for the 99%!');
        
        // Function to show progressive quotes
        function showProgressiveQuote() {
            const quotes = [
                "Healthcare is a human right, not a privilege!",
                "The billionaires should not exist!",
                "Not me, us!",
                "Workers of the world, unite!"
            ];
            const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
            alert(randomQuote);
        }
        
        // Union and worker focus
        function showWorkerFocus() {
            const workerProducts = [
                "Union-Made Goods",
                "Cooperative Products", 
                "Fair Trade Items",
                "Climate Conscious Products"
            ];
            // Focus on products that resonate with progressive base
        }
    </script>
</body>
</html>
