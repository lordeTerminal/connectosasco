<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexão com o banco
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

// Verifica login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Usuário';

// Lista de usuários (menos o logado)
$query = "SELECT user_id, username FROM users WHERE user_id != ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>ConnectMed - Contatos</title>
    <link rel="icon" href="Logo Connect Osasco Branca.svg" type="image/svg+xml">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, sans-serif;
            background-color: #f0f2f5;
            color: #333;
        }
        /* === Sidebar === */
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

        /* === Header === */
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
            justify-content: space-between;
            padding: 0 20px;
            z-index: 10;
        }
        header .user-info {
            display: flex;
            align-items: center;
        }
        header img {
            height: 35px;
            margin-right: 10px;
        }

        /* === Main === */
        main {
            margin-left: 220px;
            margin-top: 70px;
            padding: 20px;
            max-width: 800px;
        }
        h1 {
            margin-top: 0;
        }

        /* === Lista de usuários === */
        .user-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .user-card {
            background: #fff;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 6px rgba(0,0,0,0.15);
        }
        .user-card a {
            text-decoration: none;
            color: #1877f2;
            font-weight: 600;
        }
        .user-card a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
            }
            .sidebar h2, .sidebar a {
                display: none;
            }
            header {
                left: 60px;
            }
            main {
                margin-left: 60px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <img src="Logo Connect Osasco Branca.svg" alt="Logo">
        <h2>ConnectMed</h2>
        <a href="profile.php">Feed</a>
        <a href="meu_perfil.php">Meu Perfil</a>
        <a href="criar_post.php">Criar Post</a>
        <a href="user_list.php">Chat</a>
        <a href="events.php">Eventos</a>
        <a href="logout.php">Sair</a>
    </div>

    <!-- Header -->
    <header>
        <div class="user-info">
            <img src="Logo Connect Osasco Branca.svg" alt="Logo">
            <div>
                <strong><?php echo htmlspecialchars($username); ?></strong><br>
                <small>Lista de contatos</small>
            </div>
        </div>
    </header>

    <!-- Main -->
    <main>
        <h1>Contatos</h1>
        <ul class="user-list">
            <?php foreach ($users as $user): ?>
                <li class="user-card">
                    <span><?php echo htmlspecialchars($user['username']); ?></span>
                    <a href="chat.php?partner_id=<?php echo $user['user_id']; ?>">Abrir Chat</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>
</body>
</html>

