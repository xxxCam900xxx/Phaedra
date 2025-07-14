<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['socialId'])
) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing or invalid parameters']);
    exit;
}

$socialId = $data['socialId'];

$query = "DELETE FROM Socials WHERE ID = ?";
$params = [$socialId];
$types = "i";
$deleteStmt = executeStatement($query, $params, $types);
$deleteStmt->close();

echo json_encode(['success' => true, 'message' => 'Social wurde erfolgreich gelöscht!']);