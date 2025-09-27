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
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$user_id = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bio = $_POST['bio'] ?? '';
    $skills = $_POST['skills'] ?? '';

    // Handle profile picture upload
    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $profile_picture = 'uploads/profile_' . $user_id . '.' . $ext;
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture);
    }

    // Build update query
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
$stmt = $pdo->prepare("SELECT username, full_name, profile_picture, bio, skills FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - Connect Osasco</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .perfil-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background: rgba(255,255,255,0.9);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        .perfil-container img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }
        .perfil-container h2 {
            margin-bottom: 10px;
        }
        .perfil-container textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: vertical;
        }
        .perfil-container input[type="file"] {
            margin-bottom: 15px;
        }
        .perfil-container button {
            background-color: #005d7a;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .perfil-container button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="perfil-container">
        <h2>Meu Perfil</h2>
        <?php if ($user['profile_picture']): ?>
            <img src="<?php echo $user['profile_picture']; ?>" alt="Foto de perfil">
        <?php else: ?>
            <img src="default_avatar.png" alt="Foto de perfil">
        <?php endif; ?>
        <p><strong>Usuário:</strong> <?php echo htmlspecialchars($user['username']); ?></p>

        <form action="" method="POST" enctype="multipart/form-data">
            <label for="profile_picture">Alterar foto de perfil:</label>
            <input type="file" name="profile_picture" id="profile_picture">

            <br><label for="bio">Sobre mim:</label>
            <textarea name="bio" id="bio" rows="4"><?php echo htmlspecialchars($user['bio']); ?></textarea>

            <label for="skills">Competências / Habilidades:</label>
            <textarea name="skills" id="skills" rows="3"><?php echo htmlspecialchars($user['skills']); ?></textarea>

            <button type="submit">Salvar Alterações</button>
        </form>
        <br>
        <a href="profile.php">Voltar para feed</a>
    </div>
</body>
</html>

