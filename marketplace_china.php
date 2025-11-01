<?php
session_start();
require_once 'db_connection.php';
require_once 'listar_produtos.php';

$titulo_pagina = "工人市场 - 直接来自生产者的产品";
$slogan = "没有中间商，只有劳动者";
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?></title>
    <style>
        /* 中国美学 - 红色和金色主题 */
        body { 
            background: linear-gradient(135deg, #de2910 0%, #ffde00 100%);
            font-family: 'Microsoft YaHei', 'SimHei', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .china-hero {
            background: rgba(255,255,255,0.95);
            padding: 50px 20px;
            text-align: center;
            border-bottom: 5px solid #de2910;
        }
        
        .china-title {
            font-size: 2.8em;
            color: #de2910;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .china-subtitle {
            font-size: 1.3em;
            color: #666;
            margin-bottom: 25px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 30px 20px;
        }
        
        .stat-item {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: 2px solid #ffde00;
        }
        
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #de2910;
        }
        
        .product-card-china {
            background: white;
            border: 2px solid #de2910;
            border-radius: 8px;
            padding: 20px;
            margin: 15px;
            transition: transform 0.3s ease;
        }
        
        .product-card-china:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(222,41,16,0.2);
        }
        
        .china-badge {
            background: #de2910;
            color: white;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 0.8em;
        }
        
        .cooperation-notice {
            background: rgba(255,222,0,0.2);
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid #ffde00;
        }
        
        .payment-methods {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }
        
        .payment-icon {
            width: 50px;
            height: 50px;
            background: #f5f5f5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
        }
    </style>
</head>
<body>
    <!-- 英雄区域 -->
    <div class="china-hero">
        <h1 class="china-title">🏭 工人市场</h1>
        <p class="china-subtitle"><?php echo $slogan; ?></p>
        
        <!-- 统计数据 -->
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">0%</div>
                <div>资本家利润</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">100%</div>
                <div>劳动者收入</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">一带一路</div>
                <div>合作精神</div>
            </div>
        </div>
        
        <!-- 支付方式 -->
        <div class="payment-methods">
            <div class="payment-icon">💰</div>
            <div class="payment-icon">📱</div>
            <div class="payment-icon">💳</div>
            <div class="payment-icon">🌐</div>
        </div>
        
        <button style="background:#de2910; color:white; border:none; padding:15px 30px; border-radius:25px; font-size:16px; cursor:pointer; margin-top:20px;">
            🚀 开始销售
        </button>
    </div>

    <!-- 合作通知 -->
    <div class="cooperation-notice">
        <strong>🤝 中国-巴西直接合作!</strong><br>
        支持人民币-雷亚尔直接交易，没有美元中间商！
    </div>

    <!-- 产品网格 -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; padding: 20px;">
        <?php foreach($produtos as $produto): ?>
            <div class="product-card-china">
                <div style="display:flex; justify-content:space-between; align-items:start;">
                    <h3 style="margin:0; color:#de2910;"><?php echo htmlspecialchars($produto['titulo']); ?></h3>
                    <span class="china-badge">直接交易</span>
                </div>
                
                <div style="font-size:1.4em; font-weight:bold; color:#2c5530; margin:15px 0;">
                    💰 R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                    <small style="font-size:0.7em; color:#666;">(支持人民币支付)</small>
                </div>
                
                <p style="color:#666; line-height:1.5;"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:15px;">
                    <small>生产者: <strong><?php echo htmlspecialchars($produto['username']); ?></strong></small>
                    <button style="background:#de2910; color:white; border:none; padding:8px 15px; border-radius:15px; cursor:pointer; font-size:0.9em;">
                        联系生产者
                    </button>
                </div>
                
                <!-- 中国特色功能 -->
                <div style="margin-top:15px; padding-top:15px; border-top:1px solid #eee;">
                    <small style="color:#666;">
                        ✅ 支持微信支付 | ✅ 人民币结算 | ✅ 中葡翻译
                    </small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- 中国特色部分 -->
    <div style="background:white; padding:40px 20px; margin:20px; border-radius:10px; text-align:center;">
        <h2 style="color:#de2910;">🌉 中巴经济走廊</h2>
        <p>通过我们的平台直接连接中国消费者和巴西生产者</p>
        
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-top:30px;">
            <div>
                <h4>🇨🇳 中国方面</h4>
                <ul style="text-align:left;">
                    <li>微信支付集成</li>
                    <li>人民币直接结算</li>
                    <li>中文客户支持</li>
                </ul>
            </div>
            <div>
                <h4>🇧🇷 巴西方面</h4>
                <ul style="text-align:left;">
                    <li>PIX支付接收</li>
                    <li>雷亚尔直接收入</li>
                    <li>葡萄牙语支持</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // 中国特色功能
        function contactSeller(sellerId, productId) {
            // 集成微信商务功能
            if (typeof WeixinJSBridge !== "undefined") {
                WeixinJSBridge.invoke('openProductView', {
                    productId: productId
                });
            } else {
                window.location.href = `chat.php?partner_id=${sellerId}&product_id=${productId}&lang=zh`;
            }
        }
        
        // 人民币转换功能
        function convertToYuan(realPrice) {
            // 使用实时汇率API
            fetch('https://api.exchangerate-api.com/v4/latest/BRL')
                .then(response => response.json())
                .then(data => {
                    const yuanPrice = realPrice * data.rates.CNY;
                    return yuanPrice.toFixed(2);
                });
        }
        
        console.log('欢迎来到工人市场 - 劳动者团结的平台!');
    </script>
</body>
</html>
