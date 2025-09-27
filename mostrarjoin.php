<?php
$servername = "localhost";
$username = "root";
$password = "golimar10*";
$dbname = "saudeosasco";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query for join
$sql = "SELECT users.user_id, users.username, users.email, posts.post_id, posts.content AS post_content, posts.post_date
        FROM users
        JOIN posts ON users.user_id = posts.user_id";

// Execute the query
$result = $conn->query($sql);

// Display the results
if ($result === false) {
    die("Error executing query: " . $conn->error);
}

echo "<html><head><style>table, th, td {border: 1px solid black;}</style></head><body>";
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>User ID</th><th>Username</th><th>Email</th><th>Post ID</th><th>Post Content</th><th>Post Date</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['post_id'] . "</td>";
        echo "<td>" . $row['post_content'] . "</td>";
        echo "<td>" . $row['post_date'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No results found.";
}

echo "</body></html>";

// Close the connection
$conn->close();
?>

