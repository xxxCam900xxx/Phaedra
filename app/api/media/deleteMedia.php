<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Nur POST erlaubt']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['id']) || empty($data['id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Bild-ID fehlt']);
    exit;
}

$imageId = (int)$data['id'];

$conn = getConnection();

// Bildpfad aus DB holen
$stmt = $conn->prepare("SELECT ImageURL FROM Images WHERE ID = ?");
$stmt->bind_param("i", $imageId);
$stmt->execute();
$stmt->bind_result($imagePath);
if (!$stmt->fetch()) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Bild nicht gefunden']);
    exit;
}
$stmt->close();

// Datei löschen (optional)
$fullPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
if (file_exists($fullPath)) {
    unlink($fullPath);
}

// DB-Eintrag löschen
$stmt = $conn->prepare("DELETE FROM Images WHERE ID = ?");
$stmt->bind_param("i", $imageId);
$stmt->execute();
$stmt->close();

echo json_encode(['success' => true]);