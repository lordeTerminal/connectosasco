<?php
session_start();
require_once 'db_connection.php';
require_once 'listar_produtos.php';

$titulo_pagina = "Werkeremark - Direk van Produsente";
$slogan = "Sonder middlelmannetjies, net werkers se arbeid";
?>

<!DOCTYPE html>
<html lang="af">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?></title>
    <style>
        /* Suid-Afrikaanse estetika - groen, goud, swart, rooi */
        body { 
            background: linear-gradient(135deg, #007749 0%, #ffb81c 50%, #000000 100%);
            font-family: 'Arial', 'Times New Roman', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .sa-hero {
            background: rgba(255,255,255,0.95);
            padding: 50px 20px;
            text-align: center;
            border-bottom: 5px solid #ffb81c;
        }
        
        .afrikaans-title {
            font-size: 2.8em;
            color: #007749;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .afrikaans-subtitle {
            font-size: 1.3em;
            color: #666;
            margin-bottom: 25px;
            font-style: italic;
        }
        
        .sa-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 30px 20px;
        }
        
        .sa-stat {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: 2px solid #000000;
        }
        
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #ffb81c;
        }
        
        .product-card-sa {
            background: white;
            border: 2px solid #007749;
            border-radius: 8px;
            padding: 20px;
            margin: 15px;
            transition: transform 0.3s ease;
        }
        
        .product-card-sa:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,119,73,0.2);
        }
        
        .afrikaans-badge {
            background: #000000;
            color: #ffb81c;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: bold;
        }
        
        .sa-cooperation {
            background: rgba(255,184,28,0.2);
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #007749;
        }
        
        .payment-methods-sa {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }
        
        .payment-icon-sa {
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
        
        /* Boere estetika */
        .boere-style {
            background: linear-gradient(45deg, #007749, #ffb81c);
            color: white;
            padding: 15px;
            margin: 10px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        
        .mining-style {
            background: linear-gradient(45deg, #000000, #ffb81c);
            color: white;
            padding: 15px;
            margin: 10px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Hero Seksie -->
    <div class="sa-hero">
        <h1 class="afrikaans-title">⚒️ Werkeremark</h1>
        <p class="afrikaans-subtitle"><?php echo $slogan; ?></p>
        
        <!-- Suid-Afrikaanse Statistieke -->
        <div class="sa-stats">
            <div class="sa-stat">
                <div class="stat-number">0%</div>
                <div>Kapitaliste Wins</div>
            </div>
            <div class="sa-stat">
                <div class="stat-number">100%</div>
                <div>Werker Inkomste</div>
            </div>
            <div class="sa-stat">
                <div class="stat-number">BRICS</div>
                <div>Solidariteit</div>
            </div>
        </div>
        
        <!-- Betalings Metodes -->
        <div class="payment-methods-sa">
            <div class="payment-icon-sa">📱</div>
            <div class="payment-icon-sa">💳</div>
            <div class="payment-icon-sa">🌐</div>
            <div class="payment-icon-sa">R</div>
        </div>
        
        <button style="background:#007749; color:#ffb81c; border:none; padding:15px 30px; border-radius:25px; font-size:16px; cursor:pointer; margin-top:20px; font-weight:bold;">
            🚀 Begin Verkoop
        </button>
    </div>

    <!-- Boere Boodskap -->
    <div class="boere-style">
        Boere & Mynwerkers Verenig!
    </div>

    <!-- Samewerking Inligting -->
    <div class="sa-cooperation">
        <strong>🤝 Suid-Afrika-Brasilië Samewerking!</strong><br>
        Direkte Rand-Real transaksies, sonder Dollar tussengangers!
    </div>

    <!-- Produkte Rooster -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; padding: 20px;">
        <?php foreach($produtos as $produto): ?>
            <div class="product-card-sa">
                <div style="display:flex; justify-content:space-between; align-items:start;">
                    <h3 style="margin:0; color:#007749;"><?php echo htmlspecialchars($produto['titulo']); ?></h3>
                    <span class="afrikaans-badge">Direkte Handel</span>
                </div>
                
                <div style="font-size:1.4em; font-weight:bold; color:#2c5530; margin:15px 0;">
                    💰 R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                    <small style="font-size:0.7em; color:#666;">(Rand betalings)</small>
                </div>
                
                <p style="color:#666; line-height:1.5;"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:15px;">
                    <small>Produsent: <strong><?php echo htmlspecialchars($produto['username']); ?></strong></small>
                    <button style="background:#000000; color:#ffb81c; border:none; padding:8px 15px; border-radius:15px; cursor:pointer; font-size:0.9em; font-weight:bold;">
                        Kontak
                    </button>
                </div>
                
                <!-- Suid-Afrikaanse Kenmerke -->
                <div style="margin-top:15px; padding-top:15px; border-top:1px solid #eee;">
                    <small style="color:#666;">
                        ✅ EFT Betalings | ✅ Rand Transaksies | ✅ Afrikaans-Portugees Vertaling
                    </small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Mynbou Boodskap -->
    <div class="mining-style">
        Goud & Diamante - Werker Beheer!
    </div>

    <!-- Suid-Afrika-Brasilië Ekonomiese Samewerking -->
    <div style="background:white; padding:40px 20px; margin:20px; border-radius:10px; text-align:center;">
        <h2 style="color:#007749;">🌉 Suid-Afrika-Brasilië Ekonomiese Brug</h2>
        <p>Direkte verbinding tussen Suid-Afrikaanse verbruikers en Brasiliaanse produsente</p>
        
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-top:30px;">
            <div>
                <h4>🇿🇦 Suid-Afrikaanse Kant</h4>
                <ul style="text-align:left;">
                    <li>EFT Integrasie</li>
                    <li>Direkte Rand Verrekenings</li>
                    <li>Afrikaans Ondersteuning</li>
                </ul>
            </div>
            <div>
                <h4>🇧🇷 Brasiliaanse Kant</h4>
                <ul style="text-align:left;">
                    <li>PIX Betalings Aanvaar</li>
                    <li>Direkte Real Inkomste</li>
                    <li>Portugees Ondersteuning</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Landbou Boodskap -->
    <div class="boere-style">
        Landbou & Mynbou - Suid-Afrika se Rykdom!
    </div>

    <script>
        // Funksies vir Afrikaanse Mark
        function contactSeller(sellerId, productId) {
            // EFT en Suid-Afrikaanse betalings integrasie
            window.location.href = `chat.php?partner_id=${sellerId}&product_id=${productId}&lang=af`;
        }
        
        // Rand Omskakeling
        function convertToRand(realPrice) {
            // Real-time wisselkoers API
            fetch('https://api.exchangerate-api.com/v4/latest/BRL')
                .then(response => response.json())
                .then(data => {
                    const randPrice = realPrice * data.rates.ZAR;
                    return randPrice.toFixed(2);
                });
        }
        
        // Afrikaanse Welkom in Console
        console.log('Welkom by die Werkeremark - platform vir werkers solidariteit!');
        
        // Funksie om Boere Uitsprake te wys
        function showBoereQuote() {
            const quotes = [
                "Boere maak 'n plan!",
                "Werker beheer, nasie se krag!",
                "Van die Kaap tot Brasilië - solidariteit!",
                "BRICS eenheid sterker as staal!"
            ];
            const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
            alert(randomQuote);
        }
        
        // Mynbou Fokus
        function showMiningFocus() {
            const miningProducts = [
                "Goud en Diamante Handeldryf",
                "Platinum Groep Metaal",
                "Kool en Ystererts",
                "Chroom en Mangan"
            ];
            // Fokus op mynbou produkte vir SA mark
        }
    </script>
</body>
</html>
