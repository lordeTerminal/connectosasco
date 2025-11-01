<?php
session_start();
require_once 'db_connection.php';
require_once 'listar_produtos.php';

$titulo_pagina = "سوق العمال - مباشرة من المنتجين";
$slogan = "بدون وسطاء، فقط عرق العمال";
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?></title>
    <style>
        /* الجمالية العربية - الأخضر، الأسود، الأبيض، الذهبي */
        body { 
            background: linear-gradient(135deg, #006233 0%, #000000 50%, #FFFFFF 100%);
            font-family: 'Arial', 'Times New Roman', 'Tahoma', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            direction: rtl;
        }
        
        .arabic-hero {
            background: rgba(255,255,255,0.95);
            padding: 50px 20px;
            text-align: center;
            border-bottom: 5px solid #CE1126;
        }
        
        .arabic-title {
            font-size: 2.8em;
            color: #006233;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .arabic-subtitle {
            font-size: 1.3em;
            color: #666;
            margin-bottom: 25px;
        }
        
        .arabic-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 30px 20px;
        }
        
        .arabic-stat {
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
            color: #CE1126;
        }
        
        .product-card-arabic {
            background: white;
            border: 2px solid #006233;
            border-radius: 8px;
            padding: 20px;
            margin: 15px;
            transition: transform 0.3s ease;
            text-align: right;
        }
        
        .product-card-arabic:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,98,51,0.2);
        }
        
        .arabic-badge {
            background: #000000;
            color: #FFFFFF;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: bold;
        }
        
        .arabic-cooperation {
            background: rgba(206,17,38,0.1);
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #006233;
        }
        
        .payment-methods-arabic {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }
        
        .payment-icon-arabic {
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
        
        /* نمط إسلامي دقيق */
        .islamic-style {
            background: linear-gradient(45deg, #006233, #000000);
            color: white;
            padding: 15px;
            margin: 10px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            border-right: 5px solid #CE1126;
        }
        
        .economic-style {
            background: linear-gradient(45deg, #CE1126, #000000);
            color: white;
            padding: 15px;
            margin: 10px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        
        /* تخصيص النص العربي */
        .arabic-text {
            font-family: 'Arial', 'Tahoma', sans-serif;
            line-height: 1.8;
        }
    </style>
</head>
<body>
    <!-- قسم البطل -->
    <div class="arabic-hero">
        <h1 class="arabic-title">🏭 سوق العمال</h1>
        <p class="arabic-subtitle"><?php echo $slogan; ?></p>
        
        <!-- الإحصائيات العربية -->
        <div class="arabic-stats">
            <div class="arabic-stat">
                <div class="stat-number">٠٪</div>
                <div>أرباح الرأسماليين</div>
            </div>
            <div class="arabic-stat">
                <div class="stat-number">١٠٠٪</div>
                <div>دخل العمال</div>
            </div>
            <div class="arabic-stat">
                <div class="stat-number">بريكس</div>
                <div>التضامن</div>
            </div>
        </div>
        
        <!-- طرق الدفع -->
        <div class="payment-methods-arabic">
            <div class="payment-icon-arabic">📱</div>
            <div class="payment-icon-arabic">💳</div>
            <div class="payment-icon-arabic">🌐</div>
            <div class="payment-icon-arabic">﷼</div>
        </div>
        
        <button style="background:#006233; color:white; border:none; padding:15px 30px; border-radius:25px; font-size:16px; cursor:pointer; margin-top:20px; font-weight:bold;">
            🚀 ابدأ البيع
        </button>
    </div>

    <!-- رسالة التضامن الإسلامي -->
    <div class="islamic-style">
        التعاون والتضامن - قيم إسلامية وعالمية
    </div>

    <!-- معلومات التعاون -->
    <div class="arabic-cooperation">
        <strong>🤝 التعاون السعودي البرازيلي!</strong><br>
        معاملات مباشرة بالريال والريال البرازيلي، بدون وسطاء الدولار!
    </div>

    <!-- شبكة المنتجات -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; padding: 20px;">
        <?php foreach($produtos as $produto): ?>
            <div class="product-card-arabic">
                <div style="display:flex; justify-content:space-between; align-items:start;">
                    <h3 style="margin:0; color:#006233;"><?php echo htmlspecialchars($produto['titulo']); ?></h3>
                    <span class="arabic-badge">تجارة مباشرة</span>
                </div>
                
                <div style="font-size:1.4em; font-weight:bold; color:#2c5530; margin:15px 0;">
                    💰 R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                    <small style="font-size:0.7em; color:#666;">(الدفع بالريال)</small>
                </div>
                
                <p style="color:#666; line-height:1.5;" class="arabic-text"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:15px;">
                    <small>المنتج: <strong><?php echo htmlspecialchars($produto['username']); ?></strong></small>
                    <button style="background:#CE1126; color:white; border:none; padding:8px 15px; border-radius:15px; cursor:pointer; font-size:0.9em; font-weight:bold;">
                        اتصل
                    </button>
                </div>
                
                <!-- الميزات العربية -->
                <div style="margin-top:15px; padding-top:15px; border-top:1px solid #eee;">
                    <small style="color:#666;">
                        ✅ الدفع بواسطة STC Pay | ✅ معاملات بالريال | ✅ الترجمة العربية البرتغالية
                    </small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- رسالة اقتصادية -->
    <div class="economic-style">
        النفط والطاقة - قوة العمال!
    </div>

    <!-- التعاون الاقتصادي السعودي البرازيلي -->
    <div style="background:white; padding:40px 20px; margin:20px; border-radius:10px; text-align:center;">
        <h2 style="color:#006233;">🌉 الجسر الاقتصادي السعودي البرازيلي</h2>
        <p>ربط مباشر بين المستهلكين السعوديين والمنتجين البرازيليين</p>
        
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-top:30px;">
            <div>
                <h4>🇸🇦 الجانب السعودي</h4>
                <ul style="text-align:right;">
                    <li>دمج STC Pay</li>
                    <li>تسويات مباشرة بالريال</li>
                    <li>الدعم باللغة العربية</li>
                </ul>
            </div>
            <div>
                <h4>🇧🇷 الجانب البرازيلي</h4>
                <ul style="text-align:right;">
                    <li>قبول مدفوعات PIX</li>
                    <li>دخل مباشر بالريال البرازيلي</li>
                    <li>الدعم بالبرتغالية</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- رسالة التضامن الخليجي -->
    <div class="islamic-style">
        دول الخليج والبرازيل - شراكة استراتيجية
    </div>

    <script>
        // وظائف للسوق العربية
        function contactSeller(sellerId, productId) {
            // تكامل STC Pay والمدفوعات العربية
            window.location.href = `chat.php?partner_id=${sellerId}&product_id=${productId}&lang=ar`;
        }
        
        // تحويل الريال
        function convertToRiyal(realPrice) {
            // API سعر الصرف الفعلي
            fetch('https://api.exchangerate-api.com/v4/latest/BRL')
                .then(response => response.json())
                .then(data => {
                    const riyalPrice = realPrice * data.rates.SAR;
                    return riyalPrice.toFixed(2);
                });
        }
        
        // ترحيب عربي في الكونسول
        console.log('مرحبا بكم في سوق العمال - منصة تضامن العمال!');
        
        // وظيفة لعرض الاقتباسات الإسلامية
        function showIslamicQuote() {
            const quotes = [
                "التعاون على البر والتقوى",
                "اليد الواحدة لا تصفق",
                "العمال يبنون الأمم",
                "بريكس وحدة أقوى من النفط"
            ];
            const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
            alert(randomQuote);
        }
        
        // التركيز على الاقتصاد
        function showEconomicFocus() {
            const economicProducts = [
                "تجارة النفط والطاقة",
                "التمور والمنتجات الزراعية",
                "الذهب والمجوهرات",
                "التكنولوجيا والابتكار"
            ];
            // التركيز على المنتجات الاقتصادية للسوق العربي
        }
        
        // ضبط التاريخ الهجري (لمسة ثقافية)
        function displayHijriDate() {
            const hijriDate = "١٤٤٥ هـ";
            return hijriDate;
        }
    </script>
</body>
</html>
