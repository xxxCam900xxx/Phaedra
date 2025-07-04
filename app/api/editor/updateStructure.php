<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/api/config/database.php";
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['order']) || !is_array($input['order'])) {
    echo json_encode(['success' => false, 'message' => 'Ungültige Eingabe']);
    exit;
}

$conn = getConnection();
$stmt = $conn->prepare("UPDATE Layout SET Sort = ? WHERE ID = ?");

$sortValue = 10;

foreach ($input['order'] as $item) {
    if (!isset($item['id'])) continue;

    $id = (int)$item['id'];

    $stmt->bind_param("ii", $sortValue, $id);
    $stmt->execute();

    $sortValue += 10;
}

$stmt->close();

echo json_encode(['success' => true]);
