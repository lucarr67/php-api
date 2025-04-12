<?php
$host = "mysql-15764f65-albalatte-mysql.b.aivencloud.com";
$port = "25265";
$dbname = "bolle";
$username = "avnadmin";
$password = getenv('AIVEN_PASSWORD');

// Connessione al database
$conn = new mysqli($host, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connessione fallita: " . $conn->connect_error]));
}

// Recupera il parametro 'codice' dalla query string
$codice = isset($_GET['codice']) ? $conn->real_escape_string($_GET['codice']) : null;

// Costruzione query dinamica
if ($codice) {
    $sql = "SELECT * FROM clifor WHERE codice = '$codice' ORDER BY RagSoc1";
} else {
    $sql = "SELECT * FROM clifor WHERE obsoleto = 0 ORDER BY RagSoc1";
}

$result = $conn->query($sql);

$data = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode(["status" => "success", "data" => $data]);

$conn->close();
?>

