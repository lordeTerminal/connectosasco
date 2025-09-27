<?php
// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = 'golimar10*';
$database = 'saudeosasco';

try {
    // Create a PDO (PHP Data Objects) instance for database connection
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Display an error message if the connection fails
    die("Connection failed: " . $e->getMessage());
}

// If you've reached this point, the $pdo variable is now ready to use for database interactions

// Include user registration code here
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input from the registration form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role']; // Ensure proper validation and sanitization

    // Insert user data into the 'users' table
    $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username, $email, $password, $role]);

    // Redirect to the login page or another appropriate location
    header('Location: index.php');
}
?>
