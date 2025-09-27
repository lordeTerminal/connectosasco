<?php
$servername = "localhost";
$username = "root";
$password = "golimar10*";
$dbname = "saudeosasco";

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
// Inicializar a variável de pesquisa
$searchFilter = isset($_POST['pesquisar']) ? $_POST['pesquisar'] : '';

// Construir a consulta SQL com cláusulas WHERE para username, role e email
$sql = "SELECT * FROM users WHERE username LIKE ? OR role = ? OR email LIKE ?";

// Preparar a declaração SQL
$stmt = $conn->prepare($sql);

// Adicionar curingas (%) para permitir pesquisas parciais
$searchFilterWithWildcards = '%' . $searchFilter . '%';

// Vincular os parâmetros e executar a consulta
$stmt->bind_param("sss", $searchFilterWithWildcards, $searchFilter, $searchFilterWithWildcards);
$stmt->execute();

// Obter resultados
$result = $stmt->get_result();

// Exibir resultados
if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>User ID</th><th>Username</th><th>Email</th>th>Role</th><th>Profile Picture</th><th>Bio</th><th>Registration Date</th></tr>";
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

// Fechar a conexão
$stmt->close();
$conn->close();
?>



