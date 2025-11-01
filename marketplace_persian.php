<?php
session_start();
require_once 'db_connection.php'; 
require_once 'listar_produtos.php';

$titulo_pagama = "بازار کارگران - مستقیماً از تولیدکنندگان";
$slogan = "بدون واسطه، فقط کار کارگران";
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagama; ?></title>
    <style>
        /* زیبایی شناسی ایرانی - سبز، سفید، قرمز */
        body { 
            background: linear-gradient(135deg, #239F40 0%, #FFFFFF 50%, #DA0000 100%);
            font-family: 'Tahoma', 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            direction: rtl;
        }
        
        .persian-hero {
            background: rgba(255,255,255,0.95);
            padding: 50px 20px;
            text-align: center;
            border-bottom: 5px solid #DA0000;
        }
        
        .persian-title {
            font-size: 2.8em;
            color: #239F40;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .persian-subtitle {
            font-size: 1.3em;
            color: #666;
            margin-bottom: 25px;
        }
        
        .persian-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 30px 20px;
        }
        
        .persian-stat {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: 2px solid #DA0000;
        }
        
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #DA0000;
        }
        
        .product-card-persian {
            background: white;
            border: 2px solid #239F40;
            border-radius: 8px;
            padding: 20px;
            margin: 15px;
            transition: transform 0.3s ease;
            text-align: right;
        }
        
        .product-card-persian:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(35,159,64,0.2);
        }
        
        .persian-badge {
            background: #DA0000;
            color: #FFFFFF;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: bold;
        }
        
        .persian-cooperation {
            background: rgba(218,0,0,0.1);
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #239F40;
        }
        
        .payment-methods-persian {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }
        
        .payment-icon-persian {
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
        
        /* سبک ایرانی */
        .iranian-style {
            background: linear-gradient(45deg, #239F40, #DA0000);
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
    <!-- بخش قهرمان -->
    <div class="persian-hero">
        <h1 class="persian-title">🏭 بازار کارگران</h1>
        <p class="persian-subtitle"><?php echo $slogan; ?></p>
        
        <!-- آمار ایرانی -->
        <div class="persian-stats">
            <div class="persian-stat">
                <div class="stat-number">۰٪</div>
                <div>سود سرمایه داران</div>
            </div>
            <div class="persian-stat">
                <div class="stat-number">۱۰۰٪</div>
                <div>درآمد کارگران</div>
            </div>
            <div class="persian-stat">
                <div class="stat-number">بریکس</div>
                <div>همبستگی</div>
            </div>
        </div>
        
        <!-- روش های پرداخت -->
        <div class="payment-methods-persian">
            <div class="payment-icon-persian">📱</div>
            <div class="payment-icon-persian">💳</div>
            <div class="payment-icon-persian">🌐</div>
            <div class="payment-icon-persian">﷼</div>
        </div>
        
        <button style="background:#239F40; color:white; border:none; padding:15px 30px; border-radius:25px; font-size:16px; cursor:pointer; margin-top:20px; font-weight:bold;">
            🚀 شروع به فروش
        </button>
    </div>

    <!-- پیام همبستگی ایرانی -->
    <div class="iranian-style">
        همبستگی کارگران ایران و برزیل!
    </div>

    <!-- اطلاعات همکاری -->
    <div class="persian-cooperation">
        <strong>🤝 همکاری ایران و برزیل!</strong><br>
        معاملات مستقیم ریال-رئال، بدون واسطه دلار!
    </div>

    <!-- شبکه محصولات -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; padding: 20px;">
        <?php foreach($produtos as $produto): ?>
            <div class="product-card-persian">
                <div style="display:flex; justify-content:space-between; align-items:start;">
                    <h3 style="margin:0; color:#239F40;"><?php echo htmlspecialchars($produto['titulo']); ?></h3>
                    <span class="persian-badge">تجارت مستقیم</span>
                </div>
                
                <div style="font-size:1.4em; font-weight:bold; color:#2c5530; margin:15px 0;">
                    💰 R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                    <small style="font-size:0.7em; color:#666;">(پرداخت با ریال)</small>
                </div>
                
                <p style="color:#666; line-height:1.5;"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:15px;">
                    <small>تولیدکننده: <strong><?php echo htmlspecialchars($produto['username']); ?></strong></small>
                    <button style="background:#DA0000; color:white; border:none; padding:8px 15px; border-radius:15px; cursor:pointer; font-size:0.9em; font-weight:bold;">
                        تماس
                    </button>
                </div>
                
                <!-- ویژگی های ایرانی -->
                <div style="margin-top:15px; padding-top:15px; border-top:1px solid #eee;">
                    <small style="color:#666;">
                        ✅ پرداخت با Shepa | ✅ معاملات ریالی | ✅ ترجمه فارسی-پرتغالی
                    </small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- پل اقتصادی ایران و برزیل -->
    <div style="background:white; padding:40px 20px; margin:20px; border-radius:10px; text-align:center;">
        <h2 style="color:#239F40;">🌉 پل اقتصادی ایران و برزیل</h2>
        <p>اتصال مستقیم مصرف کنندگان ایرانی و تولیدکنندگان برزیلی</p>
        
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-top:30px;">
            <div>
                <h4>🇮🇷 طرف ایرانی</h4>
                <ul style="text-align:right;">
                    <li>یکپارچه سازی Shepa</li>
                    <li>تسویه مستقیم ریالی</li>
                    <li>پشتیبانی فارسی</li>
                </ul>
            </div>
            <div>
                <h4>🇧🇷 طرف برزیلی</h4>
                <ul style="text-align:right;">
                    <li>پذیرش پرداخت PIX</li>
                    <li>درآمد مستقیم رئالی</li>
                    <li>پشتیبانی پرتغالی</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // توابع برای بازار فارسی
        function contactSeller(sellerId, productId) {
            window.location.href = `chat.php?partner_id=${sellerId}&product_id=${productId}&lang=fa`;
        }
        
        // تبدیل ریال
        function convertToRial(realPrice) {
            fetch('https://api.exchangerate-api.com/v4/latest/BRL')
                .then(response => response.json())
                .then(data => {
                    const rialPrice = realPrice * data.rates.IRR;
                    return rialPrice.toFixed(2);
                });
        }
        
        console.log('به بازار کارگران خوش آمدید - پلتفرم همبستگی کارگران!');
    </script>
</body>
</html>
