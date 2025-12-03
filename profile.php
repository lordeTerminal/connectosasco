<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

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

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Criação de post via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_content'])) {
    $post_content = trim($_POST['post_content']);
    if ($post_content !== '') {
        $stmtInsert = $pdo->prepare("INSERT INTO posts (user_id, content, post_date) VALUES (?, ?, NOW())");
        $stmtInsert->execute([$user_id, $post_content]);
        header('Location: profile.php');
        exit();
    }
}

// Buscar posts
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
    <title>:) - Perfil</title>
    <link rel="icon" href="Logo Connect Osasco Branca.svg" type="image/svg+xml">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, sans-serif;
            background-color: #f0f2f5;
            color: #333;
        }
        header {
            position: fixed;
            top: 0;
            left: 220px;
            right: 0;
            height: 60px;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            display: flex;
            align-items: center;
            padding: 0 20px;
            z-index: 10;
        }
        header img {
            height: 35px;
            margin-right: 10px;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            height: 100vh;
            background-color: #1877f2;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
        }
        .sidebar img {
            width: 120px;
            margin-bottom: 10px;
        }
        .sidebar h2 {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            margin: 8px 0;
            display: block;
            width: 100%;
            text-align: center;
            padding: 8px;
            border-radius: 8px;
            transition: background 0.2s;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        main {
            margin-left: 220px;
            margin-top: 140px; /* espaço para header + caixa de post */
            max-width: 700px;
            padding: 20px;
        }
        .post {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .post.mine {
            border-left: 5px solid #1877f2;
        }
        .post p {
            margin: 5px 0;
        }
        .post small {
            color: #777;
        }
        .comments {
            margin-top: 10px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .comments h4 {
            margin: 5px 0;
        }
        textarea {
            width: 100%;
            border-radius: 6px;
            border: 1px solid #ccc;
            padding: 10px;
            font-family: inherit;
            resize: vertical;
        }
        .btn-postar {
            background-color: #1877f2;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 8px;
        }
        .btn-postar:hover {
            background-color: #145dc6;
        }
        .create-post {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        @media (max-width: 768px) {
            .sidebar { width: 60px; }
            .sidebar h2, .sidebar a { display: none; }
            header { left: 60px; }
            main { margin-left: 60px; }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <img src="Logo Connect Osasco Branca.svg" alt="Logo">
        <h2>:)</h2>
        <a href="meu_perfil.php">Meu Perfil</a>
        <a href="profile.php">Feed</a>
        <a href="user_list.php">Chat</a>
        <a href="events.php">Mural de Eventos</a>
        <a href="logout.php">Sair</a>
    </div>

    <header>
        <img src="Logo Connect Osasco Branca.svg" alt="Logo">
        <div>
            <strong><?php echo htmlspecialchars($user['username']); ?></strong><br>
            <small><?php echo htmlspecialchars($user['email']); ?></small>
        </div>
    </header>

    <main>
        <!-- Caixa de criação de post -->
        <div class="create-post">
            <form method="POST" action="profile.php">
                <textarea name="post_content" rows="3" placeholder="O que você está pensando?" required></textarea>
                <button type="submit" class="btn-postar">Postar</button>
            </form>
        </div>

        <!-- Feed de posts -->
        <?php foreach ($posts as $post): ?>
            <div class="post <?php echo $post['user_id'] == $user_id ? 'mine' : 'other'; ?>">
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                <small>Publicado por <?php echo htmlspecialchars($post['username']); ?> em <?php echo date('d/m/Y H:i', strtotime($post['post_date'])); ?></small>

                <?php
                $stmtLikes = $pdo->prepare("SELECT COUNT(*) AS like_count FROM post_likes WHERE post_id = ?");
                $stmtLikes->execute([$post['post_id']]);
                $likes = $stmtLikes->fetch(PDO::FETCH_ASSOC);

                $stmtUserLike = $pdo->prepare("SELECT * FROM post_likes WHERE post_id = ? AND user_id = ?");
                $stmtUserLike->execute([$post['post_id'], $user_id]);
                $userLiked = $stmtUserLike->fetch(PDO::FETCH_ASSOC);
                ?>

                <p>Likes: <?php echo $likes['like_count']; ?></p>
                <form action="like_post.php" method="post">
                    <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                    <button type="submit"><?php echo $userLiked ? 'Descurtir' : 'Curtir'; ?></button>
                </form>

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
                    <h4>Comentários</h4>
                    <?php foreach ($comments as $comment): ?>
                        <p><strong><?php echo htmlspecialchars($comment['username']); ?>:</strong>
                           <?php echo nl2br(htmlspecialchars($comment['comment'])); ?>
                           <small>(<?php echo date('d/m/Y H:i', strtotime($comment['timestamp'])); ?>)</small>
                        </p>
                    <?php endforeach; ?>
                    <form action="add_comment.php" method="post">
                        <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                        <textarea name="comment" rows="2" required></textarea>
                        <button type="submit">Comentar</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </main>
</body>
</html>

