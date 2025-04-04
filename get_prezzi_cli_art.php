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

// Recupera i parametri codcli e codart dalla query string
$codcli = isset($_GET['codcli']) ? $_GET['codcli'] : null;
$codart = isset($_GET['codart']) ? $_GET['codart'] : null;

// Costruisci la query SQL con la clausola WHERE se i parametri sono presenti
$sql = "SELECT * FROM prezzi";
$where_conditions = [];

if ($codcli !== null) {
    $where_conditions[] = "codcli = '" . $conn->real_escape_string($codcli) . "'";
}

if ($codart !== null) {
    $where_conditions[] = "codart = '" . $conn->real_escape_string($codart) . "'";
}

if (!empty($where_conditions)) {
    $sql .= " WHERE " . implode(" AND ", $where_conditions);
}

$sql .= " ORDER BY codcli, codart";

$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode(["status" => "success", "data" => $data]);

$conn->close();
?>