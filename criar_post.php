<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_content = trim($_POST['post_content']);
    if ($post_content !== '') {
        $host = 'localhost';
        $username = 'root';
        $password = 'golimar10*';
        $database = 'saudeosasco';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "INSERT INTO posts (user_id, content) VALUES (?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$_SESSION['user_id'], $post_content]);

        } catch (PDOException $e) {
            die("Erro ao criar post: " . $e->getMessage());
        }
    }
    header('Location: profile.php'); // redireciona pro feed
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Post</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Sobrescreve botão invisível do style.css */
        .btn-postar {
            opacity: 1 !important;
            display: inline-block !important;
            min-width: 120px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #005d7a;
            color: #fff;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        .btn-postar:hover {
            transform: scale(0.95);
        }

        /* Estilo básico para textarea */
        textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        form {
            max-width: 500px;
            margin: 50px auto;
        }
    </style>
</head>
<body>
    <header>
        <h1>Criar Post</h1>
        <a href="profile.php">Voltar ao Feed</a>
    </header>

    <main>
        <form method="POST" action="create_post.php">
            <textarea name="post_content" rows="4" placeholder="O que estou pensando no momento..." required></textarea>
            <br><br>
            <button type="submit" class="btn-postar">Postar</button>
        </form>
    </main>
</body>
</html>

