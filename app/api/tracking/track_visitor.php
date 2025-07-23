<?php
$year = date("Y");
$file = $_SERVER["DOCUMENT_ROOT"] . "/data/visits.json";

// Datei anlegen, falls sie nicht existiert
if (!file_exists($file)) {
    file_put_contents($file, json_encode([]));
}

// Daten laden
$data = json_decode(file_get_contents($file), true);

// Falls Jahr nicht existiert, mit 1 starten
if (!isset($data[$year])) {
    $data = [$year => 1]; // Vorjahresdaten optional löschen
} else {
    $data[$year] += 1;
}

// Speichern
file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

echo json_encode(["success" => true]);