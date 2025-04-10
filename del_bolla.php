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

// Recupera i parametri serie e numero dalla query string
$serie = isset($_GET['serie']) ? $_GET['serie'] : null;
$numero = isset($_GET['numero']) ? $_GET['numero'] : null;

if (is_null($serie) || is_null($numero)) {
    die(json_encode(["status" => "error", "message" => "Parametri mancanti: serie e numero sono obbligatori."]));
}

// Costruisci la query SQL in modo sicuro
$serie = $conn->real_escape_string($serie);
$numero = $conn->real_escape_string($numero);
$sql = "DELETE FROM bolle WHERE serie = '$serie' AND numero = '$numero'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Record eliminati con successo."]);
} else {
    echo json_encode(["status" => "error", "message" => "Errore nell'eliminazione: " . $conn->error]);
}

$conn->close();
?>
