<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require __DIR__ . '/db.php';

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
<link rel="stylesheet" href="meuPerfil.css">
<!-- Menu dropdown -->
<link 
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
  rel="stylesheet" 
  integrity="sha384-g6cAYG0+v+zF49HqCJdZc9d3Kn1z3R3CvLqCvhQ0j5f1F26lTD+53dYHq1mWnJbR" 
  crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoIhFZC1I1lFj7kMxZb6E6ntjM8zYd2sSkV9Bl+GJp6mZ9E" crossorigin="anonymous"></script>

</head>

<body>
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

<header class="navbar navbar-expand-md navbar-dark bg-primary fixed-top shadow-sm py-2">
  <div class="container-fluid">

    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center gap-2" href="profile.php" style="text-decoration:none;">
      <img src="Logo Connect Osasco Branca.svg" alt="Logo" height="34">
      <span class="fw-semibold d-none d-sm-inline">Connect Osasco</span>
    </a>

    <!-- Info do usuário (nome + email) -->
    <div class="user-info d-none d-md-flex align-items-center text-white me-2">
      <div class="ms-2 lh-sm">
        <strong class="d-block small"><?php echo htmlspecialchars($user['username']); ?></strong>
        <small class="opacity-75"><?php echo htmlspecialchars($user['email']); ?></small>
      </div>
    </div>

    <!-- Botão hambúrguer (aparece < 768px) -->
    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Alternar navegação">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Itens de navegação -->
    <nav class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto align-items-md-center">
        <!-- Em telas pequenas, mostramos a info do usuário dentro do menu -->
        <li class="nav-item d-md-none px-2 py-1">
          <div class="text-white-50 small">
            <strong class="text-white d-block"><?php echo htmlspecialchars($user['username']); ?></strong>
            <?php echo htmlspecialchars($user['email']); ?>
          </div>
          <hr class="my-2 border-light opacity-25">
        </li>

        <li class="nav-item"><a class="nav-link" href="profile.php">Feed</a></li>
        <li class="nav-item"><a class="nav-link" href="profile.php">Meu Perfil</a></li>
        <li class="nav-item"><a class="nav-link" href="criar_post.php">Criar Post</a></li>
        <li class="nav-item"><a class="nav-link" href="user_list.php">Chat</a></li>
        <li class="nav-item"><a class="nav-link" href="events.php">Eventos</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Sair</a></li>
      </ul>
    </nav>

  </div>
</header>

<main>
    <img id="profilePreview" src="<?= $user['profile_picture'] ?: 'default_avatar.png'; ?>" alt="Foto de perfil">
    <h2><?= htmlspecialchars($user['username']); ?></h2>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="profile_picture">Alterar foto de perfil:</label>
        <input type="file" name="profile_picture" id="profile_picture" accept="image/*">

        <label for="bio">Sobre mim:</label>
        <textarea name="bio" id="bio" rows="4"><?= htmlspecialchars($user['bio']); ?></textarea>

        <label for="skills">Competências / Habilidades:</label>
        <textarea name="skills" id="skills" rows="3"><?= htmlspecialchars($user['skills']); ?></textarea>

        <button type="submit">Salvar Alterações</button>
    </form>

    <a href="profile.php">Voltar para feed</a>
</main>

<script>
// Preview instantâneo da foto
const profileInput = document.getElementById('profile_picture');
const profilePreview = document.getElementById('profilePreview');

profileInput.addEventListener('change', function() {
    const file = this.files[0];
    if(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            profilePreview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>
</body>
</html>

