<?php
session_start();

// Enable error reporting for debugging
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
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$query = "SELECT p.post_id, p.content, p.post_date, u.username FROM posts p INNER JOIN users u ON p.user_id = u.user_id WHERE p.user_id = ? ORDER BY p.post_date DESC";
try {
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching posts: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Profile</title>
</head>

<body>
    <header>
        <h1>Welcome to Your Profile, <?php echo htmlspecialchars($user['username']); ?></h1>
        <p>Your Role: <?php echo htmlspecialchars($user['role']); ?></p>
    </header>
    <aside>
        <h2>Sidebar</h2>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
	<p>Join Date: <?php echo date('F j, Y', strtotime($user['registration_date'])); ?></p>
        <p><a href="user_list.php">chat</a></p>
    </aside>
    <main>
        <a href="criar_post.html">Postar</a>
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <p><?php echo $post['content']; ?></p>
                <p>Posted by <?php echo $post['username']; ?> on <?php echo date('F j, Y, g:i a', strtotime($post['post_date'])); ?></p>

                <!-- Display Likes count -->
                <?php
                $query = "SELECT COUNT(like_id) as like_count FROM post_likes WHERE post_id = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$post['post_id']]);
                $likes = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <p>Likes: <?php echo $likes['like_count']; ?></p>

                <!-- Add the Like button with post_id -->
                <form action="like_post.php" method="post">
                    <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                    <button type="submit">Like</button>
                </form>
            </div>
        <?php endforeach; ?>
    </main>
</body>

</html>

