<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/api/config/database.php'; // Pfad anpassen

header('Content-Type: application/json');

if (!isset($_FILES['media'])) {
    echo json_encode(['success' => false, 'message' => 'Keine Datei hochgeladen']);
    exit;
}

$file = $_FILES['media'];

// Upload-Ordner im Root-Verzeichnis deiner Webseite
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/upload/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Dateiname sicher machen und Zeitstempel anhängen
$filename = basename($file['name']);
$safeFilename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);

$targetFile = $uploadDir . $safeFilename;
$relativePath = '/upload/' . $safeFilename;

if (move_uploaded_file($file['tmp_name'], $targetFile)) {
    $conn = getConnection();

    $stmt = $conn->prepare("INSERT INTO Media (MediaURL) VALUES (?)");
    $stmt->bind_param("s", $relativePath);
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Fehler beim Speichern in der Datenbank']);
        exit;
    }
    $stmt->close();

    echo json_encode(['success' => true, 'message' => 'Datei erfolgreich hochgeladen', 'path' => $relativePath]);
} else {
    echo json_encode(['success' => false, 'message' => 'Fehler beim Verschieben der Datei']);
}