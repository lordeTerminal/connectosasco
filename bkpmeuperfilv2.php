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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bio = $_POST['bio'] ?? '';
    $skills = $_POST['skills'] ?? '';

    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $profile_picture = 'uploads/profile_' . $user_id . '.' . $ext;
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture);
    }

    $query = "UPDATE users SET bio = ?, skills = ?";
    $params = [$bio, $skills];
    if ($profile_picture) {
        $query .= ", profile_picture = ?";
        $params[] = $profile_picture;
    }
    $query .= " WHERE user_id = ?";
    $params[] = $user_id;

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    header('Location: meu_perfil.php');
    exit();
}

// Fetch user info
$stmt = $pdo->prepare("SELECT username, full_name, email, profile_picture, bio, skills FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>ConnectMed - Meu Perfil</title>
<link rel="icon" href="Logo Connect Osasco Branca.svg" type="image/svg+xml">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
/* === Body === */
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
.sidebar img { width: 120px; margin-bottom: 10px; }
.sidebar h2 { font-size: 18px; margin-bottom: 20px; }
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
.sidebar a:hover { background: rgba(255, 255, 255, 0.2); }

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
    padding: 0 20px;
    z-index: 10;
}
header .user-info {
    display: flex;
    align-items: center;
}
header img { height: 35px; margin-right: 10px; }

/* === Main === */
main {
    margin-left: 220px;
    margin-top: 70px;
    max-width: 700px;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
main img {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    object-fit: cover;
    display: block;
    margin: 0 auto 15px auto;
}
main h2, main h3 {
    text-align: center;
    margin-bottom: 10px;
}
main p { text-align: center; margin: 5px 0; }
main form { margin-top: 20px; }
main form label { display: block; margin-top: 15px; font-weight: bold; }
main form input[type="file"],
main form textarea { width: 100%; padding: 8px; margin-top: 5px; border-radius: 6px; border: 1px solid #ccc; }
main form button {
    margin-top: 20px;
    background-color: #1877f2;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
}
main form button:hover { background-color: #145dc6; }
main a { display: block; text-align: center; margin-top: 15px; color: #1877f2; text-decoration: none; }
main a:hover { text-decoration: underline; }

/* === Responsividade === */
@media (max-width: 768px) {
    .sidebar { width: 60px; }
    .sidebar h2, .sidebar a { display: none; }
    header { left: 60px; }
    main { margin-left: 60px; }
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
                <strong><?= htmlspecialchars($user['username']); ?></strong><br>
                <small><?= htmlspecialchars($user['email']); ?></small>
            </div>
        </div>
    </header>

    <!-- Main -->
    <main>
        <img src="<?= $user['profile_picture'] ?: 'default_avatar.png'; ?>" alt="Foto de perfil">
        <h2><?= htmlspecialchars($user['username']); ?></h2>

        <form action="" method="POST" enctype="multipart/form-data">
            <label for="profile_picture">Alterar foto de perfil:</label>
            <input type="file" name="profile_picture" id="profile_picture">

            <label for="bio">Sobre mim:</label>
            <textarea name="bio" id="bio" rows="4"><?= htmlspecialchars($user['bio']); ?></textarea>

            <label for="skills">Competências / Habilidades:</label>
            <textarea name="skills" id="skills" rows="3"><?= htmlspecialchars($user['skills']); ?></textarea>

            <button type="submit">Salvar Alterações</button>
        </form>

        <a href="profile.php">Voltar para feed</a>
    </main>
</body>
</html>

