<?php
session_start();
require_once 'db_connection.php';
require_once 'listar_produtos.php';

$titulo_pagina = "Рынок Трудящихся - Продукция без капиталистов";
$slogan = "Средства производства в руках рабочих!";
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?></title>
    <style>
        /* Русская/Советская эстетика - красный и золотой */
        body { 
            background: linear-gradient(135deg, #d52b1e 0%, #f8d568 100%);
            font-family: 'Roboto', 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .russian-hero {
            background: rgba(255,255,255,0.95);
            padding: 50px 20px;
            text-align: center;
            border-bottom: 5px solid #d52b1e;
        }
        
        .russian-title {
            font-size: 2.8em;
            color: #d52b1e;
            margin-bottom: 15px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .russian-subtitle {
            font-size: 1.3em;
            color: #666;
            margin-bottom: 25px;
            font-style: italic;
        }
        
        .soviet-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 30px 20px;
        }
        
        .soviet-stat {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: 2px solid #f8d568;
        }
        
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #d52b1e;
        }
        
        .product-card-russian {
            background: white;
            border: 2px solid #d52b1e;
            border-radius: 8px;
            padding: 20px;
            margin: 15px;
            transition: transform 0.3s ease;
            position: relative;
        }
        
        .product-card-russian:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(213,43,30,0.2);
        }
        
        .soviet-badge {
            background: #d52b1e;
            color: #f8d568;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .br-cooperation {
            background: rgba(248,213,104,0.3);
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #d52b1e;
        }
        
        .payment-methods-russia {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }
        
        .payment-icon-russia {
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
        
        /* Стиль советских плакатов */
        .soviet-poster-style {
            background: linear-gradient(45deg, #d52b1e, #f8d568);
            color: white;
            padding: 15px;
            margin: 10px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <!-- Герой секция -->
    <div class="russian-hero">
        <h1 class="russian-title">⚒️ Рынок Трудящихся</h1>
        <p class="russian-subtitle"><?php echo $slogan; ?></p>
        
        <!-- Советская статистика -->
        <div class="soviet-stats">
            <div class="soviet-stat">
                <div class="stat-number">0%</div>
                <div>Прибыль буржуев</div>
            </div>
            <div class="soviet-stat">
                <div class="stat-number">100%</div>
                <div>Доход рабочих</div>
            </div>
            <div class="soviet-stat">
                <div class="stat-number">БРИКС</div>
                <div>Солидарность</div>
            </div>
        </div>
        
        <!-- Методы оплаты -->
        <div class="payment-methods-russia">
            <div class="payment-icon-russia">💳</div>
            <div class="payment-icon-russia">📱</div>
            <div class="payment-icon-russia">🌐</div>
            <div class="payment-icon-russia">₽</div>
        </div>
        
        <button style="background:#d52b1e; color:#f8d568; border:none; padding:15px 30px; border-radius:25px; font-size:16px; cursor:pointer; margin-top:20px; font-weight:bold;">
            🚀 Начать продавать
        </button>
    </div>

    <!-- Стиль советских плакатов -->
    <div class="soviet-poster-style">
        ПРОЛЕТАРИИ ВСЕХ СТРАН, СОЕДИНЯЙТЕСЬ!
    </div>

    <!-- Уведомление о сотрудничестве -->
    <div class="br-cooperation">
        <strong>🤝 Российско-Бразильское сотрудничество!</strong><br>
        Прямые расчеты в рублях-реалах, без долларовых посредников!
    </div>

    <!-- Сетка продуктов -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; padding: 20px;">
        <?php foreach($produtos as $produto): ?>
            <div class="product-card-russian">
                <div style="display:flex; justify-content:space-between; align-items:start;">
                    <h3 style="margin:0; color:#d52b1e;"><?php echo htmlspecialchars($produto['titulo']); ?></h3>
                    <span class="soviet-badge">Прямая сделка</span>
                </div>
                
                <div style="font-size:1.4em; font-weight:bold; color:#2c5530; margin:15px 0;">
                    💰 R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                    <small style="font-size:0.7em; color:#666;">(оплата в рублях)</small>
                </div>
                
                <p style="color:#666; line-height:1.5;"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:15px;">
                    <small>Производитель: <strong><?php echo htmlspecialchars($produto['username']); ?></strong></small>
                    <button style="background:#d52b1e; color:#f8d568; border:none; padding:8px 15px; border-radius:15px; cursor:pointer; font-size:0.9em; font-weight:bold;">
                        Связаться
                    </button>
                </div>
                
                <!-- Русские особенности -->
                <div style="margin-top:15px; padding-top:15px; border-top:1px solid #eee;">
                    <small style="color:#666;">
                        ✅ Оплата СБП | ✅ Расчеты в рублях | ✅ Русско-португальский перевод
                    </small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Секция российско-бразильского сотрудничества -->
    <div style="background:white; padding:40px 20px; margin:20px; border-radius:10px; text-align:center;">
        <h2 style="color:#d52b1e;">🌉 Российско-Бразильский экономический мост</h2>
        <p>Прямое соединение российских потребителей и бразильских производителей</p>
        
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-top:30px;">
            <div>
                <h4>🇷🇺 Российская сторона</h4>
                <ul style="text-align:left;">
                    <li>Интеграция с СБП</li>
                    <li>Прямые расчеты в рублях</li>
                    <li>Русская поддержка</li>
                </ul>
            </div>
            <div>
                <h4>🇧🇷 Бразильская сторона</h4>
                <ul style="text-align:left;">
                    <li>Прием платежей PIX</li>
                    <li>Прямой доход в реалах</li>
                    <li>Португальская поддержка</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Еще один советский плакат -->
    <div class="soviet-poster-style">
        ЗЕМЛЯ - КРЕСТЬЯНАМ, ФАБРИКИ - РАБОЧИМ!
    </div>

    <script>
        // Функции для русского рынка
        function contactSeller(sellerId, productId) {
            // Интеграция с российскими платежными системами
            window.location.href = `chat.php?partner_id=${sellerId}&product_id=${productId}&lang=ru`;
        }
        
        // Конвертация в рубли
        function convertToRuble(realPrice) {
            // Использование API актуального курса
            fetch('https://api.exchangerate-api.com/v4/latest/BRL')
                .then(response => response.json())
                .then(data => {
                    const rublePrice = realPrice * data.rates.RUB;
                    return rublePrice.toFixed(2);
                });
        }
        
        // Советское приветствие в консоли
        console.log('Добро пожаловать на Рынок Трудящихся - платформу солидарности рабочих!');
        
        // Функция для показа советских цитат
        function showSovietQuote() {
            const quotes = [
                "Пролетарии всех стран, соединяйтесь!",
                "Земля - крестьянам, фабрики - рабочим!",
                "Кто не работает, тот не ест!",
                "Вся власть Советам!"
            ];
            const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
            alert(randomQuote);
        }
    </script>
</body>
</html>
