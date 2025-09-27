<?php
// fetch_messages.php

session_start();

// Include the function definition
include('functions.php'); // Replace 'path/to/your/functions.php' with the actual path

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    exit('User not logged in');
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
    exit('Connection failed: ' . $e->getMessage());
}

// Get the user and partner IDs
$user_id = $_SESSION['user_id'];
$partner_id = $_POST['partner_id'];

// Fetch new messages since the last update
$chatHistory = fetchChatHistory($pdo, $user_id, $partner_id);

// Output the updated chat history
foreach ($chatHistory as $chat) {
    echo '<div class="chat-message">';
    echo '<p>', $chat['sender_username'], ' to ', $chat['receiver_username'], ' at ', $chat['timestamp'], '</p>';
    echo '<p>', $chat['message'], '</p>';
    echo '</div>';
}
?>

