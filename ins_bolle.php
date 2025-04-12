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

// Imposta header per ricevere JSON
header("Content-Type: application/json");
$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input["righe"])) {
    echo json_encode(["status" => "error", "message" => "Dati non ricevuti."]);
    exit;
}

// Inizio transazione
$conn->begin_transaction();
try {
    $stmt = $conn->prepare("INSERT INTO bolle 
        (serie, numero, riga, data, ora, codcli, ragsoc, indirizzo, citta, provincia, cap, numfatt, datafatt, piva, codart, desart, um, qta, przuni, iva, totriga, caumag) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($input["righe"] as $r) {
        $stmt->bind_param(
            "siissssssssssssssddds",
            $r["serie"], $r["numero"], $r["riga"], $r["data"], $r["ora"],
            $r["codcli"], $r["ragsoc"], $r["indirizzo"], $r["citta"], $r["provincia"], $r["cap"],
            $r["numfatt"], $r["datafatt"], $r["piva"], $r["codart"], $r["desart"], $r["um"],
            $r["qta"], $r["przuni"], $r["iva"], $r["totriga"], $r["caumag"]
        );
        $stmt->execute();
    }

    $conn->commit();
    echo json_encode(["status" => "success", "message" => "Righe inserite correttamente."]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => "Errore durante l'inserimento: " . $e->getMessage()]);
}

$stmt->close();
$conn->close();
?>
