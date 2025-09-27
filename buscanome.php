<?php
$servername = "localhost";
$username = "root";
$password = "golimar10*";
$dbname = "saudeosasco";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
$searchFilter = isset($_POST['pesquisar']) ? $_POST['pesquisar'] : '';
$sql = "SELECT * FROM users 
        WHERE username LIKE ? OR role = ? OR email LIKE ?
        ORDER BY username ASC";

$stmt = $conn->prepare($sql);
$searchFilterWithWildcards = '%' . $searchFilter . '%';
$stmt->bind_param("sss", $searchFilterWithWildcards, $searchFilter, $searchFilterWithWildcards);
$stmt->execute();

if ($stmt->error) {
    die("Error executing statement: " . $stmt->error);
}

$result = $stmt->get_result();

if ($result === false) {
    die("Error getting result: " . $stmt->error);
}

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>User ID</th><th>Username</th><th>Email</th><th>Role</th><th>Profile Picture</th><th>Bio</th><th>Registration Date</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['role'] . "</td>";
        echo "<td>" . $row['profile_picture'] . "</td>";
        echo "<td>" . $row['bio'] . "</td>";
        echo "<td>" . $row['registration_date'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum resultado encontrado.";
}

$stmt->close();
$conn->close();
?>

