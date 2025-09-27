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

// Get the user information
$user_id = $_SESSION['user_id'];

// Check if a chat partner is selected
if (isset($_GET['partner_id'])) {
    $partner_id = $_GET['partner_id'];

    // Fetch the partner's information
    $query = "SELECT username FROM users WHERE user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$partner_id]);
    $partner = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch initial chat history
    $chatHistory = fetchChatHistory($pdo, $user_id, $partner_id);
} else {
    // If no partner is selected, display a message
    $partner = null;
    $chatHistory = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with <?php echo $partner ? $partner['username'] : 'Select a Chat Partner'; ?></title>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        height: 100vh;
        overflow: hidden;
    }

    #content-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        box-sizing: border-box;
        overflow-y: auto;
        max-height: calc(100vh - 60px); /* Adjust based on your header/footer heights */
    }

    main {
        margin-bottom: 20px; /* Adjust based on your design preference */
    }

    #chat-box {
        max-height: calc(100vh - 80px); /* Adjust based on your header/footer heights */
        overflow-y: auto;
        margin-bottom: 20px;
    }

    #chat-form {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #f1f1f1;
        padding: 15px;
        box-sizing: border-box;
        border-top: 1px solid #ccc;
        display: flex;
        align-items: center;
    }

    #message {
        flex: 1;
        margin-right: 10px;
    }

    button {
        flex-shrink: 0;
    }


</style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            function updateChat() {
                $.ajax({
                    url: 'fetch_messages.php',
                    method: 'POST',
                    data: { partner_id: <?php echo $partner_id; ?> },
                    success: function(response) {
                        $('#chat-box').html(response);
                    }
                });
            }

            // Initial update
            updateChat();

            // Schedule the next update after a delay (e.g., every 5 seconds)
            setInterval(updateChat, 5000);

            // Add your additional JavaScript for sending messages if needed
            // ...

            // Example: Submitting a message
            $('#chat-form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'send_message.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Optionally handle success response
                        updateChat(); // Update chat after sending a message
                    }
                });
                // Clear the message input after sending
                $('#message').val('');
            });
        });
    </script>
</head>
<body>
    <header>
        <h1>Chat with <?php echo $partner ? $partner['username'] : 'Select a Chat Partner'; ?></h1>
    </header>
    <div id="content-container">
        <main>
            <div id="chat-box">
                <?php foreach ($chatHistory as $chat): ?>
                    <div class="chat-message">
                        <p><?php echo $chat['sender_username']; ?> to <?php echo $chat['receiver_username']; ?> at <?php echo $chat['timestamp']; ?></p>
                        <p><?php echo $chat['message']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
        <?php if ($partner): ?>
            <!-- Chat form -->
            <form id="chat-form">
                <input type="hidden" name="receiver" value="<?php echo $partner_id; ?>">
                <label for="message">Message:</label>
                <textarea name="message" id="message" rows="4" cols="50" required></textarea>
                <br>
                <button type="submit">Send Message</button>
            </form>
            <!-- Refresh button -->
            <button id="refresh-button">Refresh</button>
        <?php else: ?>
            <p>Select a user to start a chat.</p>
        <?php endif; ?>
    </div>
<script>
    $(document).ready(function() {
        // ... (your existing JavaScript code)

        // Function to fetch messages
        function updateChat() {
            $.ajax({
                url: 'fetch_messages.php',
                method: 'POST',
                data: { partner_id: <?php echo $partner_id; ?> },
                success: function(response) {
                    $('#chat-box').html(response);
                }
            });
        }

        // Refresh button click event
        $('#refresh-button').click(function() {
            updateChat();
        });
    });
</script>

</body>
</html>

<?php
function fetchChatHistory($pdo, $user_id, $partner_id) {
    $query = "
        SELECT c.message, c.timestamp, u.username AS sender_username, ur.username AS receiver_username
        FROM chats c
        INNER JOIN users u ON c.sender_id = u.user_id
        INNER JOIN users ur ON c.receiver_id = ur.user_id
        WHERE (c.sender_id = ? AND c.receiver_id = ?) OR (c.sender_id = ? AND c.receiver_id = ?)
        ORDER BY c.timestamp ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id, $partner_id, $partner_id, $user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

