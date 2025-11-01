<?php
session_start();
require_once 'db_connection.php';
require_once 'listar_produtos.php';

$titulo_pagina = "श्रमिक बाजार - सीधे उत्पादकों से";
$slogan = "बिना बिचौलियों के, केवल श्रमिकों के लिए";
?>

<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?></title>
    <style>
        /* भारतीय सौंदर्य - केसरिया, सफेद और हरा */
        body { 
            background: linear-gradient(135deg, #ff9933 0%, #ffffff 50%, #138808 100%);
            font-family: 'Arial', 'Noto Sans Devanagari', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .indian-hero {
            background: rgba(255,255,255,0.95);
            padding: 50px 20px;
            text-align: center;
            border-bottom: 5px solid #ff9933;
        }
        
        .hindi-title {
            font-size: 2.8em;
            color: #ff9933;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .hindi-subtitle {
            font-size: 1.3em;
            color: #666;
            margin-bottom: 25px;
        }
        
        .india-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 30px 20px;
        }
        
        .india-stat {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: 2px solid #138808;
        }
        
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #ff9933;
        }
        
        .product-card-india {
            background: white;
            border: 2px solid #ff9933;
            border-radius: 8px;
            padding: 20px;
            margin: 15px;
            transition: transform 0.3s ease;
        }
        
        .product-card-india:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(255,153,51,0.2);
        }
        
        .hindi-badge {
            background: #138808;
            color: white;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: bold;
        }
        
        .india-cooperation {
            background: rgba(19,136,8,0.1);
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #ff9933;
        }
        
        .payment-methods-india {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }
        
        .payment-icon-india {
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
        
        /* स्वदेशी शैली */
        .swadeshi-style {
            background: linear-gradient(45deg, #ff9933, #138808);
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
    <!-- हीरो सेक्शन -->
    <div class="indian-hero">
        <h1 class="hindi-title">🏭 श्रमिक बाजार</h1>
        <p class="hindi-subtitle"><?php echo $slogan; ?></p>
        
        <!-- भारतीय आँकड़े -->
        <div class="india-stats">
            <div class="india-stat">
                <div class="stat-number">0%</div>
                <div>पूंजीपति मुनाफा</div>
            </div>
            <div class="india-stat">
                <div class="stat-number">100%</div>
                <div>श्रमिक आय</div>
            </div>
            <div class="india-stat">
                <div class="stat-number">ब्रिक्स</div>
                <div>एकजुटता</div>
            </div>
        </div>
        
        <!-- भुगतान विधियाँ -->
        <div class="payment-methods-india">
            <div class="payment-icon-india">📱</div>
            <div class="payment-icon-india">💳</div>
            <div class="payment-icon-india">🌐</div>
            <div class="payment-icon-india">₹</div>
        </div>
        
        <button style="background:#ff9933; color:white; border:none; padding:15px 30px; border-radius:25px; font-size:16px; cursor:pointer; margin-top:20px; font-weight:bold;">
            🚀 बेचना शुरू करें
        </button>
    </div>

    <!-- स्वदेशी संदेश -->
    <div class="swadeshi-style">
        स्वदेशी उत्पाद - वैश्विक एकजुटता!
    </div>

    <!-- सहयोग सूचना -->
    <div class="india-cooperation">
        <strong>🤝 भारत-ब्राजील सहयोग!</strong><br>
        रुपया-रीयल में सीधे लेनदेन, डॉलर बिचौलियों के बिना!
    </div>

    <!-- उत्पाद ग्रिड -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; padding: 20px;">
        <?php foreach($produtos as $produto): ?>
            <div class="product-card-india">
                <div style="display:flex; justify-content:space-between; align-items:start;">
                    <h3 style="margin:0; color:#ff9933;"><?php echo htmlspecialchars($produto['titulo']); ?></h3>
                    <span class="hindi-badge">सीधा व्यापार</span>
                </div>
                
                <div style="font-size:1.4em; font-weight:bold; color:#2c5530; margin:15px 0;">
                    💰 R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                    <small style="font-size:0.7em; color:#666;">(रुपया में भुगतान)</small>
                </div>
                
                <p style="color:#666; line-height:1.5;"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:15px;">
                    <small>निर्माता: <strong><?php echo htmlspecialchars($produto['username']); ?></strong></small>
                    <button style="background:#138808; color:white; border:none; padding:8px 15px; border-radius:15px; cursor:pointer; font-size:0.9em; font-weight:bold;">
                        संपर्क करें
                    </button>
                </div>
                
                <!-- भारतीय विशेषताएँ -->
                <div style="margin-top:15px; padding-top:15px; border-top:1px solid #eee;">
                    <small style="color:#666;">
                        ✅ UPI भुगतान | ✅ रुपया लेनदेन | ✅ हिंदी-पुर्तगाली अनुवाद
                    </small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- भारत-ब्राजील आर्थिक सहयोग -->
    <div style="background:white; padding:40px 20px; margin:20px; border-radius:10px; text-align:center;">
        <h2 style="color:#ff9933;">🌉 भारत-ब्राजील आर्थिक पुल</h2>
        <p>भारतीय उपभोक्ताओं और ब्राजील के उत्पादकों को सीधे जोड़ना</p>
        
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-top:30px;">
            <div>
                <h4>🇮🇳 भारतीय पक्ष</h4>
                <ul style="text-align:left;">
                    <li>UPI एकीकरण</li>
                    <li>रुपया सीधा लेनदेन</li>
                    <li>हिंदी समर्थन</li>
                </ul>
            </div>
            <div>
                <h4>🇧🇷 ब्राजील पक्ष</h4>
                <ul style="text-align:left;">
                    <li>PIX भुगतान स्वीकार</li>
                    <li>रीयल में सीधी आय</li>
                    <li>पुर्तगाली समर्थन</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- एक और स्वदेशी संदेश -->
    <div class="swadeshi-style">
        श्रमिकों की एकजुटता विश्व को बदल सकती है!
    </div>

    <script>
        // हिंदी बाजार के लिए कार्य
        function contactSeller(sellerId, productId) {
            // UPI और भारतीय भुगतान एकीकरण
            window.location.href = `chat.php?partner_id=${sellerId}&product_id=${productId}&lang=hi`;
        }
        
        // रुपया रूपांतरण
        function convertToRupee(realPrice) {
            // वास्तविक समय विनिमय दर API
            fetch('https://api.exchangerate-api.com/v4/latest/BRL')
                .then(response => response.json())
                .then(data => {
                    const rupeePrice = realPrice * data.rates.INR;
                    return rupeePrice.toFixed(2);
                });
        }
        
        // कंसोल में हिंदी स्वागत
        console.log('श्रमिक बाजार में आपका स्वागत है - श्रमिक एकजुटता का मंच!');
        
        // स्वदेशी उद्धरण दिखाने के लिए फ़ंक्शन
        function showSwadeshiQuote() {
            const quotes = [
                "जय हिंद, जय किसान!",
                "स्वदेशी अपनाओ, देश बचाओ!",
                "श्रमिक एकजुट, शक्ति अटूट!",
                "ब्रिक्स एकजुटता जिंदाबाद!"
            ];
            const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
            alert(randomQuote);
        }
    </script>
</body>
</html>
