<?php
require_once '../../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['token'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing token']);
    exit;
}

$token = trim($data['token']);
$conn = getConnection();

$stmt = $conn->prepare("SELECT ID FROM Users WHERE SessionToken = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$isValid = $result->num_rows > 0;
$stmt->close();

echo json_encode(['success' => $isValid]);