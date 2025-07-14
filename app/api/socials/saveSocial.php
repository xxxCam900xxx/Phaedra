<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";

header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

// Eingaben mit Defaults
$id = isset($input["ID"]) ? trim($input["ID"]) : null;
$icon = isset($input["Icon"]) ? trim($input["Icon"]) : null;
$socialURL   = isset($input["Social"]) ? trim($input["Social"]) : null;
$isShown  = isset($input["IsShown"]) ? (bool)$input["IsShown"] : "false";

if ($id != null) {
    try {
        $query = "UPDATE Socials SET Icon = ?, SocialURL = ?, IsShown = ? WHERE ID = ?";
        $params = [$icon, $socialURL, $isShown, $id];
        $types = "sssi";

        $updateStmt = executeStatement($query, $params, $types);

        if ($updateStmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Social erfolgreich gespeichert.']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Social konnte nicht gespeichert werden.']);
        }

        $updateStmt->close();
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Fehler: ' . $e->getMessage()]);
    }
} else {
    try {
        $query = "INSERT INTO Socials (Icon, SocialURL, IsShown) VALUES (?, ?, ?)";
        $params = [$icon, $socialURL, $isShown];
        $types = "sss";

        $insertStmt = executeStatement($query, $params, $types);

        if ($insertStmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Social erfolgreich gespeichert.']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Social konnte nicht gespeichert werden.']);
        }

        $insertStmt->close();
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Fehler: ' . $e->getMessage()]);
    }
}
