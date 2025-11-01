<?php
// db_connection.php - Conexão com o banco de dados revolucionário

$host = 'localhost';
$dbname = 'saudeosasco'; 
$username = 'root';
$password = 'golimar10*';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Log revolucionário (apenas em desenvolvimento)
    error_log("✅ Conexão com o banco de dados estabelecida - Os meios de produção estão sob controle!");
    
} catch (PDOException $e) {
    // Em produção, mostre uma mensagem genérica
    error_log("❌ Erro de conexão com o banco: " . $e->getMessage());
    
    if (ini_get('display_errors')) {
        // Modo desenvolvimento - mostra erro detalhado
        die("Erro de conexão com o banco de dados: " . $e->getMessage());
    } else {
        // Modo produção - mensagem amigável
        die("Desculpe, estamos com problemas técnicos. Tente novamente em alguns minutos.");
    }
}
?>
