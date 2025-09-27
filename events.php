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

// Busca usuário logado
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Busca eventos
$query = "
SELECT e.event_id, e.title, e.description, e.event_date, u.username,
(SELECT COUNT(*) FROM event_likes el WHERE el.event_id = e.event_id) AS like_count,
(SELECT COUNT(*) FROM event_interests ei WHERE ei.event_id = e.event_id) AS interest_count
FROM events e
INNER JOIN users u ON e.user_id = u.user_id
ORDER BY e.event_date DESC";
$events = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

// Função para verificar se o usuário curtiu/interessou
function userAction($pdo, $event_id, $user_id, $table) {
    $stmt = $pdo->prepare("SELECT 1 FROM $table WHERE event_id = ? AND user_id = ?");
    $stmt->execute([$event_id, $user_id]);
    return $stmt->fetchColumn() ? true : false;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Mural de Eventos</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        /* Estilo dos eventos */
        .event { border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 8px; background: #f9f9f9; }
        .event p { margin: 5px 0; }
        .actions { margin-top: 10px; display: flex; gap: 10px; }
        .actions button { cursor: pointer; padding: 5px 10px; border-radius: 5px; border: none; }
        .comments { margin-top: 10px; }
        .comments textarea { width: 100%; margin-top: 5px; }
        .comment-item { border-top: 1px solid #ddd; padding: 5px 0; }
    </style>
</head>
<body>
    <h1>Mural de Eventos</h1>
    <p>Olá, <?php echo htmlspecialchars($user['username']); ?>! Créditos: <?php echo $user['credits']; ?></p>

    <a href="profile.php">Voltar para o Feed</a><br><br>

    <!-- Formulário de criar evento -->
    <?php if ($user['credits'] > 0): ?>
        <form id="create-event-form" method="POST" action="create_event.php">
            <input type="text" name="title" placeholder="Título do evento" required>
            <textarea name="description" placeholder="Descrição" required></textarea>
            <button type="submit">Criar Evento (-1 crédito)</button>
        </form>
    <?php else: ?>
        <p>Você não possui créditos para criar novos eventos.</p>
    <?php endif; ?>

    <hr>

    <!-- Lista de eventos -->
    <div id="events-container">
        <?php foreach ($events as $event): ?>
            <div class="event" data-id="<?php echo $event['event_id']; ?>">
                <strong><?php echo htmlspecialchars($event['title']); ?></strong>
                <p><?php echo htmlspecialchars($event['description']); ?></p>
                <p>Criado por: <?php echo htmlspecialchars($event['username']); ?> em <?php echo $event['event_date']; ?></p>

                <div class="actions">
                    <button class="like-btn" data-liked="<?php echo userAction($pdo, $event['event_id'], $user_id, 'event_likes') ? '1' : '0'; ?>">
                        Curtir (<span class="like-count"><?php echo $event['like_count']; ?></span>)
                    </button>
                    <button class="interest-btn" data-interested="<?php echo userAction($pdo, $event['event_id'], $user_id, 'event_interests') ? '1' : '0'; ?>">
                        Interessado (<span class="interest-count"><?php echo $event['interest_count']; ?></span>)
                    </button>
                </div>

                <div class="comments">
                    <div class="comments-list">
                        <?php
                        $stmt = $pdo->prepare("SELECT c.comment, u.username FROM event_comments c INNER JOIN users u ON c.user_id = u.user_id WHERE c.event_id = ? ORDER BY c.comment_id ASC");
                        $stmt->execute([$event['event_id']]);
                        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($comments as $c): ?>
                            <div class="comment-item"><strong><?php echo htmlspecialchars($c['username']); ?>:</strong> <?php echo htmlspecialchars($c['comment']); ?></div>
                        <?php endforeach; ?>
                    </div>
                    <textarea class="comment-input" placeholder="Escreva um comentário..."></textarea>
                    <button class="comment-submit">Enviar</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<script>
$(document).ready(function() {

    // Função para atualizar likes e interesses via AJAX
    function updateEvent(eventId, type) {
        $.post(type + "_event.php", { event_id: eventId }, function() {
            $.get("fetch_events_partial.php", function(data) {
                $("#events-container").html(data);
            });
        });
    }

    // Curtir evento
    $(document).on("click", ".like-btn", function() {
        let eventId = $(this).closest(".event").data("id");
        updateEvent(eventId, "like");
    });

    // Interessar-se no evento
    $(document).on("click", ".interest-btn", function() {
        let eventId = $(this).closest(".event").data("id");
        updateEvent(eventId, "interest");
    });

    // Comentar
    $(document).on("click", ".comment-submit", function() {
        let eventDiv = $(this).closest(".event");
        let eventId = eventDiv.data("id");
        let comment = eventDiv.find(".comment-input").val().trim();
        if (comment.length > 0) {
            $.post("comment_event.php", { event_id: eventId, comment: comment }, function() {
                $.get("fetch_events_partial.php", function(data) {
                    $("#events-container").html(data);
                });
            });
        }
    });

});
</script>
</body>
</html>

