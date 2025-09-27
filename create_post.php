<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $post_content = $_POST['post_content'];

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

    try {
        $query = "INSERT INTO posts (user_id, content, post_date) VALUES (?, ?, NOW())";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$user_id, $post_content]);
        header('Location: profile.php');
    } catch (PDOException $e) {
        die("Error creating post: " . $e->getMessage());
    }
} else {
    // Handle errors or unauthorized access
}
?>

