<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['order']) || !is_array($input['order'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Ungültige Eingabe']);
    exit;
}

$conn = getConnection();
$stmt = $conn->prepare("UPDATE Pages SET Sort = ? WHERE ID = ?");

foreach ($input['order'] as $item) {
    if (!isset($item['id'], $item['sort'])) {
        continue; // Überspringe ungültige Einträge
    }

    $sort = (int)$item['sort'];
    $id = (int)$item['id'];
    $stmt->bind_param("ii", $sort, $id);
    $stmt->execute();
}


$stmt->close();
echo json_encode(['success' => true]);