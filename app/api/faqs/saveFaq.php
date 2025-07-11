<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";

header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

// Eingaben mit Defaults
$id = isset($input["ID"]) ? trim($input["ID"]) : null;
$question = isset($input["Question"]) ? trim($input["Question"]) : null;
$answer   = isset($input["Answer"]) ? trim($input["Answer"]) : null;
$isShown  = isset($input["IsShown"]) ? (bool)$input["IsShown"] : "false";

// Validierung
if (empty($question)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Frage darf nicht leer sein.']);
    exit;
}
if ($id != null) {
    try {
        $query = "UPDATE Faqs SET Question = ?, Answer = ?, IsShown = ? WHERE ID = ?";
        $params = [$question, $answer, $isShown, $id];
        $types = "sssi";

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
        $query = "INSERT INTO Faqs (Question, Answer, IsShown) VALUES (?, ?, ?)";
        $params = [$question, $answer, $isShown];
        $types = "sss";

        $insertStmt = executeStatement($query, $params, $types);

        if ($insertStmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'FAQ erfolgreich gespeichert.']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'FAQ konnte nicht gespeichert werden.']);
        }

        $insertStmt->close();
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Fehler: ' . $e->getMessage()]);
    }
}
