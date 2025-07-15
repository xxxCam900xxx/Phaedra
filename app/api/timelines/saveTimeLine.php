<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";

header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);
$id             = isset($input["ID"]) ? trim($input["ID"]) : "";
$date           = isset($input["Date"]) ? trim($input["Date"]) : "";
$title          = isset($input["Title"]) ? trim($input["Title"]) : "";
$description    = isset($input["Description"]) ? trim($input["Description"]) : "";
$link           = isset($input["Link"]) ? trim($input["Link"]) : "";


if ($id != null) {
    try {
        $query = "UPDATE Timeline SET Date = ?, Title = ?, Description = ?, Link = ? WHERE ID = ?";
        $params = [$date, $title, $description, $link, $id];
        $types = "ssssi";

        $updateStmt = executeStatement($query, $params, $types);

        if ($updateStmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'FAQ erfolgreich gespeichert.']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'FAQ konnte nicht gespeichert werden.']);
        }

        $updateStmt->close();
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Fehler: ' . $e->getMessage()]);
    }
} else {
    try {
        $query = "INSERT INTO Timeline (Date, Title, Description, Link) VALUES (?, ?, ?, ?)";
        $params = [$date, $title, $description, $link];
        $types = "ssss";

        $insertStmt = executeStatement($query, $params, $types);

        if ($insertStmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Timeline erfolgreich gespeichert.']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Timeline konnte nicht gespeichert werden.']);
        }

        $insertStmt->close();
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Fehler: ' . $e->getMessage()]);
    }
}
