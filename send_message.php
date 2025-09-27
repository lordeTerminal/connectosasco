<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the sender and receiver IDs from the session and form
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver'];

    // Validate the receiver ID (you might want to add more validation)
    if (!is_numeric($receiver_id)) {
        die('Invalid receiver ID');
    }

    // Get the message from the form
    $message = $_POST['message'];

    // Insert the message into the database
    $query = "INSERT INTO chats (sender_id, receiver_id, message, timestamp) VALUES (?, ?, ?, NOW())";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$sender_id, $receiver_id, $message]);

    // Redirect back to the chat page with the selected partner
    header("Location: chat.php?partner_id=$receiver_id");
    exit();
} else {
    // If the form is not submitted, redirect to the user list page
    header('Location: user_list.php');
    exit();
}

