<?php
$host = "mysql-15764f65-albalatte-mysql.b.aivencloud.com";
$port = "25265";
$dbname = "bolle_test";
$username = "avnadmin";
$password = getenv('AIVEN_PASSWORD');

// Connessione al database
$conn = new mysqli($host, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connessione fallita: " . $conn->connect_error]));
}

    // Prepara la query SQL per inserire i dati
    $sql = "INSERT INTO bolle (serie, numero, riga, data)
            VALUES ('1', '1', '1', '1')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Riga bolla inserita correttamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Errore nell'inserimento: " . $conn->error]);
    }

$conn->close();
?>
