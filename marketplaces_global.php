<?php
session_start();
$titulo_pagina = "Global Marketplaces - Choose Your Revolution";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?></title>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }
        
        .marketplaces-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .marketplace-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 3px solid transparent;
        }
        
        .marketplace-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        
        .card-icon {
            font-size: 3em;
            margin-bottom: 15px;
        }
        
        .card-title {
            font-size: 1.4em;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2c3e50;
        }
        
        .card-description {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        
        .card-button {
            background: #3498db;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            transition: background 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .card-button:hover {
            background: #2980b9;
        }
        
        /* Cores específicas para cada ideologia */
        .socialista { border-color: #e74c3c; }
        .socialista .card-button { background: #e74c3c; }
        .socialista .card-button:hover { background: #c0392b; }
        
        .capitalista { border-color: #27ae60; }
        .capitalista .card-button { background: #27ae60; }
        .capitalista .card-button:hover { background: #229954; }
        
        .anarquista { border-color: #2c3e50; }
        .anarquista .card-button { background: #2c3e50; }
        .anarquista .card-button:hover { background: #1c2833; }
        
        .ancap { border-color: #f39c12; }
        .ancap .card-button { background: #f39c12; }
        .ancap .card-button:hover { background: #e67e22; }
        
        .brics { border-color: #9b59b6; }
        .brics .card-button { background: #9b59b6; }
        .brics .card-button:hover { background: #8e44ad; }
        
        .americano { border-color: #3498db; }
        .americano .card-button { background: #3498db; }
        .americano .card-button:hover { background: #2980b9; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🌍 GLOBAL MARKETPLACES</h1>
        <p>Choose your gateway to the new economic order</p>
    </div>

    <div class="marketplaces-grid">
        <!-- MARKETPLACE BASE -->
        <div class="marketplace-card capitalista">
            <div class="card-icon">🏪</div>
            <div class="card-title">Mercado Neutro</div>
            <div class="card-description">
                Versão padrão para visitantes e novos usuários
            </div>
            <a href="marketplace.php" class="card-button">Acessar</a>
        </div>

        <!-- VERSÕES IDEOLÓGICAS -->
        <div class="marketplace-card socialista">
            <div class="card-icon">☭</div>
            <div class="card-title">Mercado Socialista</div>
            <div class="card-description">
                Os meios de produção nas mãos dos trabalhadores
            </div>
            <a href="marketplace_socialista.php" class="card-button">Acessar</a>
        </div>

        <div class="marketplace-card capitalista">
            <div class="card-icon">💼</div>
            <div class="card-title">Mercado Capitalista</div>
            <div class="card-description">
                Empreendedorismo e livre mercado sem restrições
            </div>
            <a href="marketplace_capitalista.php" class="card-button">Acessar</a>
        </div>

        <div class="marketplace-card anarquista">
            <div class="card-icon">⚫</div>
            <div class="card-title">Mercado Anarquista</div>
            <div class="card-description">
                Nem Estado, nem patrões - apenas pessoas
            </div>
            <a href="marketplace_anarquista.php" class="card-button">Acessar</a>
        </div>

        <div class="marketplace-card ancap">
            <div class="card-icon">💛</div>
            <div class="card-title">Mercado Anarcocapitalista</div>
            <div class="card-description">
                Propriedade privada e contratos livres
            </div>
            <a href="marketplace_ancap.php" class="card-button">Acessar</a>
        </div>

        <!-- BRICS - AMIGOS ESTRATÉGICOS -->
        <div class="marketplace-card brics">
            <div class="card-icon">🇨🇳</div>
            <div class="card-title">中国市场 (China)</div>
            <div class="card-description">
                Mercado em mandarim para nossos camaradas chineses
            </div>
            <a href="marketplace_china.php" class="card-button">进入</a>
        </div>

        <div class="marketplace-card brics">
            <div class="card-icon">🇷🇺</div>
            <div class="card-title">Рынок Трудящихся (Rússia)</div>
            <div class="card-description">
                Mercado em russo com estética soviética
            </div>
            <a href="marketplace_russia.php" class="card-button">Войти</a>
        </div>

        <div class="marketplace-card brics">
            <div class="card-icon">🇮🇳</div>
            <div class="card-title">श्रमिक बाजार (Índia)</div>
            <div class="card-description">
                Mercado em hindi para as massas trabalhadoras
            </div>
            <a href="marketplace_india.php" class="card-button">प्रवेश</a>
        </div>

        <div class="marketplace-card brics">
            <div class="card-icon">🇿🇦</div>
            <div class="card-title">Werkeremark (África do Sul)</div>
            <div class="card-description">
                Mercado em africâner - controle econômico
            </div>
            <a href="marketplace_southafrika.php" class="card-button">Toegang</a>
        </div>

        <div class="marketplace-card brics">
            <div class="card-icon">🇸🇦</div>
            <div class="card-title">سوق العمال (Arábia Saudita)</div>
            <div class="card-description">
                Mercado em árabe com respeito cultural
            </div>
            <a href="marketplace_arabic.php" class="card-button">دخول</a>
        </div>

        <div class="marketplace-card brics">
            <div class="card-icon">🇮🇷</div>
            <div class="card-title">بازار کارگران (Irã)</div>
            <div class="card-description">
                Mercado em farsi para nossos amigos persas
            </div>
            <a href="marketplace_persian.php" class="card-button">ورود</a>
        </div>

        <!-- MERCADOS OCIDENTAIS DIVIDIDOS -->
        <div class="marketplace-card americano">
            <div class="card-icon">🦅</div>
            <div class="card-title">Patriot Marketplace (GOP)</div>
            <div class="card-description">
                Versão direita americana - liberdade e livre mercado
            </div>
            <a href="marketplace_gop.php" class="card-button">Enter</a>
        </div>

        <div class="marketplace-card americano">
            <div class="card-icon">🌹</div>
            <div class="card-title">Workers Cooperative (Bernie)</div>
            <div class="card-description">
                Versão esquerda americana - taxar os ricos
            </div>
            <a href="marketplace_bernie.php" class="card-button">Join</a>
        </div>
    </div>

    <script>
        // Sistema de recomendação básico
        function recommendMarketplace() {
            const userLanguage = navigator.language || navigator.userLanguage;
            const userCountry = getCountryFromIP(); // Função fictícia
            
            let recommendation = "marketplace.php"; // padrão
            
            if (userLanguage.includes('zh')) recommendation = "marketplace_china.php";
            else if (userLanguage.includes('ru')) recommendation = "marketplace_russia.php";
            else if (userLanguage.includes('hi')) recommendation = "marketplace_india.php";
            else if (userLanguage.includes('af')) recommendation = "marketplace_southafrika.php";
            else if (userLanguage.includes('ar')) recommendation = "marketplace_arabic.php";
            else if (userLanguage.includes('fa')) recommendation = "marketplace_persian.php";
            else if (userLanguage.includes('en')) {
                // Para inglês, decidir entre GOP e Bernie baseado em geolocalização
                if (userCountry === 'US') {
                    const redStates = ['TX', 'FL', 'OH', 'GA']; // Estados conservadores
                    const userState = getUserState(); // Função fictícia
                    recommendation = redStates.includes(userState) ? "marketplace_gop.php" : "marketplace_bernie.php";
                }
            }
            
            return recommendation;
        }
        
        // Redirecionamento automático opcional
        function autoRedirect() {
            const recommended = recommendMarketplace();
            if (recommended !== "marketplace.php") {
                if (confirm(`Recomendamos: ${recommended}\nDeseja ser redirecionado?`)) {
                    window.location.href = recommended;
                }
            }
        }
        
        // Executar ao carregar a página
        // autoRedirect(); // Descomente para ativar redirecionamento automático
        
        console.log('🌍 Painel de Controle Revolucionário - Todos os marketplaces disponíveis!');
    </script>
</body>
</html>
