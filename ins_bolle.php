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

// Ricevi i dati tramite POST
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data["serie"]) && isset($data["numero"]) && isset($data["riga"]) && isset($data["data"]) && isset($data["ora"]) && isset($data["codcli"]) && isset($data["ragsoc"]) && isset($data["indirizzo"]) && isset($data["citta"]) && isset($data["provincia"]) && isset($data["cap"]) && isset($data["numfatt"]) && isset($data["datafatt"]) && isset($data["piva"]) && isset($data["codart"]) && isset($data["desart"]) && isset($data["um"]) && isset($data["qta"]) && isset($data["przuni"]) && isset($data["iva"]) && isset($data["totriga"]) && isset($data["caumag"])) {

    // Estrai i dati
    $serie = $data["serie"];
    $numero = $data["numero"];
    $riga = $data["riga"];
    $data = $data["data"];
    $ora = $data["ora"];
    $codcli = $data["codcli"];
    $ragsoc = $data["ragsoc"];
    $indirizzo = $data["indirizzo"];
    $citta = $data["citta"];
    $provincia = $data["provincia"];
    $cap = $data["cap"];
    $numfatt = $data["numfatt"];
    $datafatt = $data["datafatt"];
    $piva = $data["piva"];
    $codart = $data["codart"];
    $desart = $data["desart"];
    $um = $data["um"];
    $qta = $data["qta"];
    $przuni = $data["przuni"];
    $iva = $data["iva"];
    $totriga = $data["totriga"];
    $caumag = $data["caumag"];

    // Prepara la query SQL per inserire i dati
    $sql = "INSERT INTO bolle (serie, numero, riga, data, ora, codcli, ragsoc, indirizzo, citta, provincia, cap, numfatt, datafatt, piva, codart, desart, um, qta, przuni, iva, totriga, caumag)
            VALUES ('$serie', '$numero', '$riga', '$data', '$ora', '$codcli', '$ragsoc', '$indirizzo', '$citta', '$provincia', '$cap', '$numfatt', '$datafatt', '$piva', '$codart', '$desart', '$um', '$qta', '$przuni', '$iva', '$totriga', '$caumag')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Riga bolla inserita correttamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Errore nell'inserimento: " . $conn->error]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Dati incompleti."]);
}

$conn->close();
?>
