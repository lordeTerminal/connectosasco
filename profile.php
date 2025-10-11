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
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Criar post
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
  SELECT p.post_id, p.content, p.post_date, p.user_id, u.username, u.email
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
  <meta charset="UTF-8" />
  <title>Connect Osasco — Feed</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="Logo Connect Osasco Branca.svg" type="image/svg+xml">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons (para os ícones de nav) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Seu CSS -->
  <link rel="stylesheet" href="profile.css">
</head>
<body>

  <!-- HEADER (estilo LinkedIn) -->
  <header class="navbar navbar-expand bg-white border-bottom fixed-top py-2 shadow-sm">
    <div class="container-xl align-items-center d-flex gap-3">

      <!-- Logo -->
      <a style="color: whitesmoke;" class="navbar-brand d-flex align-items-center gap-2" href="profile.php">
        <img src="Logo Connect Osasco Branca.svg" alt="Logo" height="58">
        <!-- <span  class="fw-semibold d-none d-sm-inline">Connect Osasco</span> -->
      </a>

      <!-- Busca (desktop) -->
      <form class="d-none d-md-flex flex-grow-1" role="search" action="search.php" method="get">
        <div class="input-group input-group-sm">
          <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
          <input class="form-control" type="search" name="q" placeholder="Pesquisar" aria-label="Pesquisar">
        </div>
      </form>

      <!-- Ícones topo (desktop) -->
      <ul class="top-icons d-none d-md-flex list-unstyled m-0 align-items-center gap-4">
        <li><a class="nav-link text-center" href="profile.php" title="Início"><i class="bi bi-house-door fs-5"></i><div >Início</div></a></li>
        <li><a class="nav-link text-center" href="user_list.php" title="Conexões"><i class="bi bi-people fs-5"></i><div >Conexões</div></a></li>
        <li><a class="nav-link text-center" href="notifications.php" title="Notificações"><i class="bi bi-bell fs-5"></i><div>Notificações</div></a></li>
        <li><a class="nav-link text-center" href="jobs.php" title="jobs"> <i class="bi bi-briefcase-fill fs-5"></i><div>Deal</div></a></li>
      </ul>

      <!-- Usuário (desktop) -->
      <div class="d-none d-md-flex align-items-center ms-2">
        <div class="text-end me-2 small">
          <strong class="d-block"><?php echo htmlspecialchars($user['username']); ?></strong>
          <span  class="text-secondary"><?php echo htmlspecialchars($user['email']); ?></span>
        </div>
        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
          <?php echo strtoupper(substr($user['username'] ?? 'U', 0, 1)); ?>
        </div>
      </div>
    </div>
  </header>

  <!-- LAYOUT -->
  <div class="container-xl layout-3col">
    <div class="row g-4">

      <!-- COL ESQUERDA (perfil / atalhos) - Desktop -->
      <aside class="col-lg-3 d-none d-lg-block">
        <div class="card shadow-sm">
          <div class="card-body text-center">
            <div class="avatar avatar-lg bg-primary text-white rounded-circle mx-auto mb-2">
              <?php echo strtoupper(substr($user['username'] ?? 'U', 0, 1)); ?>
            </div>
            <div class="fw-semibold"><?php echo htmlspecialchars($user['username']); ?></div>
            <div class="text-secondary small"><?php echo htmlspecialchars($user['email']); ?></div>
            <hr>
            <div class="d-grid gap-2">
              <a class="btn btn-light btn-sm" href="meu_perfil.php"><i class="bi bi-person"></i> Meu Perfil</a>
              <a class="btn btn-light btn-sm" href="user_list.php"><i class="bi bi-chat-dots"></i> Chat</a>
              <a class="btn btn-light btn-sm" href="events.php"><i class="bi bi-calendar-event"></i> Eventos</a>
              <a class="btn btn-outline-danger btn-sm" href="logout.php"><i class="bi bi-box-arrow-right"></i> Sair</a>
            </div>
          </div>
        </div>
      </aside>

      <!-- FEED (centro) -->
      <main class="col-12 col-lg-6">

        <!-- Criar post -->
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <form method="POST" action="profile.php">
              <div class="d-flex align-items-start gap-2 mb-2">
                <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                  <?php echo strtoupper(substr($user['username'] ?? 'U', 0, 1)); ?>
                </div>
                <textarea class="form-control" name="post_content" rows="3" placeholder="Começar uma publicação..." required></textarea>
              </div>
              <div class="text-end">
                <button type="submit" class="btn btn-primary btn-sm">Postar</button>
              </div>
            </form>
          </div>
        </div>

        <!-- Lista de posts -->
        <?php foreach ($posts as $post): ?>
          <div class="card shadow-sm mb-3">
            <div class="card-body">
              <div class="d-flex align-items-center gap-2 mb-1">
                <div class="avatar bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center">
                  <?php echo strtoupper(substr($post['username'] ?? 'U', 0, 1)); ?>
                </div>
                <div>
                  <div class="fw-semibold small"><?php echo htmlspecialchars($post['username']); ?></div>
                  <div class="text-secondary xsmall"><?php echo date('d/m/Y H:i', strtotime($post['post_date'])); ?></div>
                </div>
              </div>

              <p class="mb-2"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>

              <?php
                $stmtLikes = $pdo->prepare("SELECT COUNT(*) AS like_count FROM post_likes WHERE post_id = ?");
                $stmtLikes->execute([$post['post_id']]);
                $likes = $stmtLikes->fetch(PDO::FETCH_ASSOC);

                $stmtUserLike = $pdo->prepare("SELECT 1 FROM post_likes WHERE post_id = ? AND user_id = ?");
                $stmtUserLike->execute([$post['post_id'], $user_id]);
                $userLiked = (bool) $stmtUserLike->fetchColumn();
              ?>

              <div class="d-flex align-items-center gap-3">
                <form action="like_post.php" method="post" class="m-0">
                  <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                  <button type="submit" class="btn btn-light btn-sm">
                    <i class="bi bi-hand-thumbs-up<?php echo $userLiked ? '-fill text-primary' : ''; ?>"></i>
                    Curtir
                  </button>
                </form>
                <span class="text-secondary xsmall">Likes: <?php echo (int)($likes['like_count'] ?? 0); ?></span>
              </div>

              <?php
                // Comentários (ajuste para sua tabela real; seu dump tinha comments/post_comments diferentes)
                $stmtComments = $pdo->prepare("
                  SELECT c.content AS comment, c.comment_date AS timestamp, u.username
                  FROM comments c
                  INNER JOIN users u ON c.user_id = u.user_id
                  WHERE c.post_id = ?
                  ORDER BY c.comment_date ASC
                ");
                $stmtComments->execute([$post['post_id']]);
                $comments = $stmtComments->fetchAll(PDO::FETCH_ASSOC);
              ?>

              <div class="mt-3 border-top pt-2">
                <div class="fw-semibold small mb-2">Comentários</div>
                <?php foreach ($comments as $comment): ?>
                  <div class="mb-2">
                    <strong class="small"><?php echo htmlspecialchars($comment['username']); ?>:</strong>
                    <span class="small"><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></span>
                    <div class="text-secondary xsmall">(<?php echo date('d/m/Y H:i', strtotime($comment['timestamp'])); ?>)</div>
                  </div>
                <?php endforeach; ?>

                <form action="add_comment.php" method="post" class="mt-2">
                  <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                  <div class="input-group input-group-sm">
                    <input type="text" name="comment" class="form-control" placeholder="Adicione um comentário..." required>
                    <button class="btn btn-outline-primary" type="submit">Comentar</button>
                  </div>
                </form>
              </div>

            </div>
          </div>
        <?php endforeach; ?>
      </main>

      <!-- COL DIREITA (sugestões, eventos) - Desktop -->
      <aside class="col-lg-3 d-none d-lg-block">
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <div class="fw-semibold mb-2">Sugestões</div>
            <div class="text-secondary small">Em breve…</div>
          </div>
        </div>
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="fw-semibold mb-2">Eventos</div>
            <a href="events.php" class="small">Ver agenda</a>
          </div>
        </div>
      </aside>

    </div>
  </div>

  <!-- NAV INFERIOR (MOBILE) -->
  <nav class="mobile-nav d-md-none border-top bg-white fixed-bottom">
    <div class="container-xl">
      <ul class="d-flex justify-content-between align-items-center m-0 p-0">
        <li><a href="profile.php" class="mobile-link"><i class="bi bi-house-door"></i><span>Início</span></a></li>
        <li><a href="user_list.php" class="mobile-link"><i class="bi bi-people"></i><span>Conects</span></a></li>
        <li><a href="notifications.php" class="mobile-link"><i class="bi bi-bell"></i><span>Notifs</span></a></li>
        <li><a href="jobs.php" class="mobile-link" > <i class="bi bi-briefcase-fill fs-5"></i><span>Deal</span></a></li>
      </ul>
      </ul>
    </div>
  </nav>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
