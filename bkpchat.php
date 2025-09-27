<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$username = 'root';
$password = 'golimar10*';
$database = 'saudeosasco';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("DB ERROR: " . $e->getMessage());
}

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$partner_id = isset($_GET['partner_id']) ? intval($_GET['partner_id']) : 0;

if($partner_id > 0){
    $stmt = $pdo->prepare("SELECT username FROM users WHERE user_id = ?");
    $stmt->execute([$partner_id]);
    $partner = $stmt->fetch(PDO::FETCH_ASSOC);

    $chatHistory = fetchChatHistory($pdo, $user_id, $partner_id);
} else {
    $partner = null;
    $chatHistory = [];
}

function fetchChatHistory($pdo, $user_id, $partner_id){
    $stmt = $pdo->prepare("
        SELECT c.message, c.timestamp, u.username AS sender_username, ur.username AS receiver_username
        FROM chats c
        INNER JOIN users u ON c.sender_id = u.user_id
        INNER JOIN users ur ON c.receiver_id = ur.user_id
        WHERE (c.sender_id = ? AND c.receiver_id = ?) OR (c.sender_id = ? AND c.receiver_id = ?)
        ORDER BY c.timestamp ASC
    ");
    $stmt->execute([$user_id, $partner_id, $partner_id, $user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chat com <?php echo $partner ? $partner['username'] : 'Selecione um usuário'; ?></title>
<link rel="stylesheet" href="style.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<header>
<h1>Chat com <?php echo $partner ? $partner['username'] : 'Selecione um usuário'; ?></h1>
<a href="profile.php">Voltar</a> | <a href="user_list.php">Amigos</a>
</header>

<main>
<div id="chat-box">
<?php foreach($chatHistory as $chat): ?>
    <div class="chat-message <?php echo ($chat['sender_username']==$_SESSION['username']?'sender':'receiver'); ?>">
        <p><strong><?php echo $chat['sender_username']; ?></strong>: <?php echo htmlspecialchars($chat['message']); ?></p>
        <small><?php echo $chat['timestamp']; ?></small>
    </div>
<?php endforeach; ?>
</div>

<?php if($partner): ?>
<form id="chat-form">
<textarea name="message" id="message" rows="3" required></textarea>
<button type="submit">Enviar</button>
</form>
<?php else: ?>
<p>Selecione um usuário para começar.</p>
<?php endif; ?>
</main>

<script>
$(document).ready(function(){
    function updateChat(){
        $.post('fetch_messages.php',{ partner_id: <?=$partner_id?> }, function(res){
            $('#chat-box').html(res);
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
        });
    }
    updateChat();
    setInterval(updateChat, 3000);

    $('#chat-form').submit(function(e){
        e.preventDefault();
        $.post('send_message.php', $(this).serialize(), function(){
            $('#message').val('');
            updateChat();
        });
    });
});
</script>
</body>
</html>

