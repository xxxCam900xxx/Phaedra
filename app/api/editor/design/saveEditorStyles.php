<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !is_array($data)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Ungültige Eingabedaten.']);
    exit;
}

// Dynamisch Keys und Werte vorbereiten
$columns = [];
$placeholders = [];
$values = [];
$types = '';

foreach ($data as $key => $value) {
    $columns[] = $key;
    $placeholders[] = '?';
    $values[] = $value;
    $types .= 's'; // Wenn du verschiedene Typen hast, musst du das hier anpassen
}

// Existiert schon ein Eintrag?
$checkStmt = executeStatement("SELECT ID FROM WebDesign LIMIT 1");
$exists = $checkStmt->fetch();
$checkStmt->close();

if ($exists) {
    // UPDATE dynamisch zusammenbauen
    $setClause = implode(', ', array_map(fn($col) => "$col = ?", $columns));
    $sql = "UPDATE WebDesign SET $setClause WHERE ID = 1";
} else {
    // INSERT dynamisch zusammenbauen
    $columnList = implode(', ', $columns);
    $placeholderList = implode(', ', $placeholders);
    $sql = "INSERT INTO WebDesign ($columnList) VALUES ($placeholderList)";
}

$stmt = executeStatement($sql, $values, $types);

if ($stmt) {
    echo json_encode(['success' => true, 'message' => 'Design erfolgreich gespeichert.']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Fehler beim Speichern des Designs.']);
}