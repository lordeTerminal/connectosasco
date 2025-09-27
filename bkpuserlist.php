<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = 'golimar10*';
$database = 'saudeosasco';

// Attempt to connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get user information from the session
$userWelcomeMessage = isset($_SESSION['username']) ? 'Welcome, ' . $_SESSION['username'] . '!' : 'Welcome!';
$userRole = isset($_SESSION['role']) ? 'Your Role: ' . $_SESSION['role'] : 'Your Role is not set.';

// Get the list of users
$query = "SELECT user_id, username FROM users WHERE user_id != ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <!-- Add your CSS styling here -->
<link rel="stylesheet" href="style.css">

</head>
<body>
    <header>
        <h1>User List</h1>
        <p><?php echo $userWelcomeMessage; ?></p>
        <p><?php echo $userRole; ?></p>
    </header>
    <main>
        <ul>
            <?php foreach ($users as $user): ?>
                <li>
                    <a href="chat.php?partner_id=<?php echo $user['user_id']; ?>">
                        Chat with <?php echo $user['username']; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>
    <!-- Add your JavaScript if needed -->
</body>
</html>

