<?php
session_start();
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

$host='localhost';
$username='root';
$password='golimar10*';
$database='saudeosasco';

try{
    $pdo=new PDO("mysql:host=$host;dbname=$database;charset=utf8",$username,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("DB ERROR: ".$e->getMessage());
}

if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit();
}

$user_id=$_SESSION['user_id'];
$stmt=$pdo->prepare("SELECT * FROM users WHERE user_id=?");
$stmt->execute([$user_id]);
$user=$stmt->fetch(PDO::FETCH_ASSOC);

$partner_id=isset($_GET['partner_id'])?intval($_GET['partner_id']):0;
if($partner_id>0){
    $stmt=$pdo->prepare("SELECT username FROM users WHERE user_id=?");
    $stmt->execute([$partner_id]);
    $partner=$stmt->fetch(PDO::FETCH_ASSOC);
}else{
    $partner=null;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chat com <?= $partner ? $partner['username'] : 'Selecione um usuário' ?></title>
<link rel="icon" href="Logo Connect Osasco Branca.svg" type="image/svg+xml">
<style>
body{margin:0;font-family:"Segoe UI", Tahoma, sans-serif;background:#f0f2f5;color:#333;}
header{position:fixed;top:0;left:220px;right:0;height:60px;background:#fff;border-bottom:1px solid #ddd;display:flex;align-items:center;padding:0 20px;z-index:10;}
header img{height:35px;margin-right:10px;}
.sidebar{position:fixed;top:0;left:0;width:220px;height:100vh;background:#1877f2;color:#fff;display:flex;flex-direction:column;align-items:center;padding-top:20px;}
.sidebar img{width:120px;margin-bottom:10px;}
.sidebar h2{font-size:18px;margin-bottom:20px;}
.sidebar a{color:#fff;text-decoration:none;margin:8px 0;display:block;width:100%;text-align:center;padding:8px;border-radius:8px;transition:background 0.2s;}
.sidebar a:hover{background:rgba(255,255,255,0.2);}
main{margin-left:220px;margin-top:70px;max-width:700px;padding:20px;}
#chat-box{background:#fff;border-radius:10px;padding:15px;box-shadow:0 1px 3px rgba(0,0,0,0.1);max-height:500px;overflow-y:auto;display:flex;flex-direction:column;}
.chat-message{margin:5px 0;padding:8px;border-radius:8px;max-width:70%;}
.chat-message.sender{background:#dcf8c6;align-self:flex-start;}
.chat-message.receiver{background:#fff;align-self:flex-end;}
#chat-form{margin-top:10px;display:flex;flex-direction:column;}
#chat-form textarea{width:100%;border-radius:6px;border:1px solid #ccc;padding:5px;font-family:inherit;}
#chat-form button{background-color:#1877f2;color:#fff;border:none;padding:6px 12px;border-radius:6px;cursor:pointer;margin-top:5px;}
#chat-form button:hover{background-color:#145dc6;}
@media(max-width:768px){.sidebar{width:60px;}.sidebar h2,.sidebar a{display:none;}header{left:60px;}main{margin-left:60px;}}
</style>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
<div class="sidebar">
<img src="Logo Connect Osasco Branca.svg" alt="Logo">
<h2>:)</h2>
<a href="profile.php">Meu Perfil</a>
<a href="user_list.php">Chat</a>
<a href="events.php">Mural de Eventos</a>
<a href="logout.php">Sair</a>
</div>

<header>
<img src="Logo Connect Osasco Branca.svg" alt="Logo">
<div>
<strong><?= htmlspecialchars($user['username']) ?></strong><br>
<small><?= htmlspecialchars($user['email']) ?></small>
</div>
</header>

<main>
<h2>Chat com <?= $partner ? $partner['username'] : 'Selecione um usuário' ?></h2>
<div id="chat-box">
<!-- mensagens serão carregadas pelo fetch antigo -->
</div>

<?php if($partner): ?>
<form id="chat-form">
<input type="hidden" name="receiver" value="<?= $partner_id ?>">
<textarea name="message" rows="3" required></textarea>
<button type="submit">Enviar</button>
</form>
<?php else: ?>
<p>Selecione um usuário para iniciar a conversa.</p>
<?php endif; ?>
</main>

<script>
$(document).ready(function(){
    function updateChat(){
        $.post('fetch_messages.php',{ partner_id: <?= $partner_id ?> }, function(res){
            $('#chat-box').html(res);
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
        });
    }
    updateChat();
    setInterval(updateChat,3000);

    $('#chat-form').submit(function(e){
        e.preventDefault();
        $.post('send_message.php',$(this).serialize(),function(){
            $('textarea[name="message"]').val('');
            updateChat();
        });
    });
});
</script>
</body>
</html>

