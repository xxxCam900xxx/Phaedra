<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input["webName"], $input["webHostName"], $input["webContact"], $input["webLogoURL"])) {
    http_response_code(400);
    echo json_encode(['error' => 'Fehlende Felder']);
    exit;
}

$webName = $input["webName"];
$webHostName = $input["webHostName"];
$webContact = $input["webContact"];
$webLogoURL = $input["webLogoURL"] ?? null;

// Update mit Logo, falls Logo-Pfad übergeben wurde
if ($webLogoURL !== null) {
    $stmt = "UPDATE WebConfig SET WebsiteName = ?, WebHostName = ?, WebContact = ?, WebLogoURL = ? WHERE ID = 1";
    $params = [$webName, $webHostName, $webContact, $webLogoURL];
    $types = "ssss";
} else {
    // Ohne Logo-Update
    $stmt = "UPDATE WebConfig SET WebsiteName = ?, WebHostName = ?, WebContact = ? WHERE ID = 1";
    $params = [$webName, $webHostName, $webContact];
    $types = "sss";
}

$updateStmt = executeStatement($stmt, $params, $types);

if (!$updateStmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Fehler beim Speichern der WebConfig']);
    exit;
}

echo json_encode(['success' => true]);