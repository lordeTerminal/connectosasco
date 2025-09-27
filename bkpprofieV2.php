<?php
session_start();

// Habilita erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifica login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Conexão com banco
$host = 'localhost';
$username = 'root';
$password = 'golimar10*';
$database = 'saudeosasco';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Dados do usuário logado
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Busca todos os posts
$query = "
    SELECT p.post_id, p.content, p.post_date, p.user_id, u.username
    FROM posts p
    INNER JOIN users u ON p.user_id = u.user_id
    ORDER BY p.post_date DESC
";
$stmt = $pdo->prepare($query);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Perfil - <?php echo htmlspecialchars($user['username']); ?></title>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Bem-vindo, <?php echo htmlspecialchars($user['username']); ?></h1>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        <p>Data de registro: <?php echo date('d/m/Y', strtotime($user['registration_date'])); ?></p>
        <p><a href="meu_perfil.php">Meu Perfil</a> | <a href="criar_post.php">Criar novo post</a> | <a href="user_list.php">Chat</a> | <a href="events.php">Mural de Eventos</a> | <a href="logout.php">Log Out</a></p>
    </header>

    <main>
        <h2>Posts da rede</h2>

        <?php foreach ($posts as $post): ?>
            <div class="post <?php echo $post['user_id'] == $user_id ? 'mine' : 'other'; ?>">
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                <p><small>Publicado por <?php echo htmlspecialchars($post['username']); ?> em <?php echo date('d/m/Y H:i', strtotime($post['post_date'])); ?></small></p>

                <?php
                // Contagem de likes
                $stmtLikes = $pdo->prepare("SELECT COUNT(*) AS like_count FROM post_likes WHERE post_id = ?");
                $stmtLikes->execute([$post['post_id']]);
                $likes = $stmtLikes->fetch(PDO::FETCH_ASSOC);

                // Verifica se o usuário já curtiu
                $stmtUserLike = $pdo->prepare("SELECT * FROM post_likes WHERE post_id = ? AND user_id = ?");
                $stmtUserLike->execute([$post['post_id'], $user_id]);
                $userLiked = $stmtUserLike->fetch(PDO::FETCH_ASSOC);
                ?>

                <p>Likes: <?php echo $likes['like_count']; ?></p>

                <!-- Botão curtir/descurtir -->
                <form action="like_post.php" method="post" style="margin-top:5px;">
                    <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                    <button type="submit"><?php echo $userLiked ? 'Descurtir' : 'Curtir'; ?></button>
                </form>

                <!-- Comentários -->
                <?php
                $stmtComments = $pdo->prepare("
                    SELECT c.comment, c.timestamp, u.username
                    FROM post_comments c
                    INNER JOIN users u ON c.user_id = u.user_id
                    WHERE c.post_id = ?
                    ORDER BY c.timestamp ASC
                ");
                $stmtComments->execute([$post['post_id']]);
                $comments = $stmtComments->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <div class="comments">
                    <h4>Comentários:</h4>
                    <?php foreach ($comments as $comment): ?>
                        <p><strong><?php echo htmlspecialchars($comment['username']); ?>:</strong>
                           <?php echo nl2br(htmlspecialchars($comment['comment'])); ?>
                           <small>(<?php echo date('d/m/Y H:i', strtotime($comment['timestamp'])); ?>)</small>
                        </p>
                    <?php endforeach; ?>

                    <!-- Formulário para comentar -->
                    <form action="add_comment.php" method="post">
                        <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                        <textarea name="comment" rows="2" required></textarea><br>
                        <button type="submit">Comentar</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </main>
</body>
</html>

