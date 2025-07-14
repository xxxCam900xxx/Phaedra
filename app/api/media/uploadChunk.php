<?php
header('Content-Type: application/json');

// Upload-Ordner (anpassen, falls nötig)
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/upload/';

// Verzeichnis erstellen, falls nicht vorhanden
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Prüfen ob alle nötigen Parameter vorhanden sind
if (
    !isset($_FILES['chunk']) ||
    !isset($_POST['uploadId']) ||
    !isset($_POST['chunkIndex']) ||
    !isset($_POST['totalChunks']) ||
    !isset($_POST['fileName'])
) {
    echo json_encode(['success' => false, 'message' => 'Ungültige Anfrage']);
    exit;
}

$chunk = $_FILES['chunk'];
$uploadId = preg_replace('/[^a-zA-Z0-9_\-]/', '', $_POST['uploadId']);
$chunkIndex = intval($_POST['chunkIndex']);
$totalChunks = intval($_POST['totalChunks']);
$fileName = basename($_POST['fileName']);

// Temporärer Ordner für Chunks
$tempDir = $uploadDir . 'temp_' . $uploadId . '/';

if (!is_dir($tempDir)) {
    mkdir($tempDir, 0755, true);
}

// Speicherort für den aktuellen Chunk
$chunkFile = $tempDir . 'chunk_' . $chunkIndex;

if (!move_uploaded_file($chunk['tmp_name'], $chunkFile)) {
    echo json_encode(['success' => false, 'message' => 'Chunk konnte nicht gespeichert werden']);
    exit;
}

// Wenn letzter Chunk hochgeladen wurde, Dateien zusammensetzen
$allChunksUploaded = true;
for ($i = 0; $i < $totalChunks; $i++) {
    if (!file_exists($tempDir . 'chunk_' . $i)) {
        $allChunksUploaded = false;
        break;
    }
}

if ($allChunksUploaded) {
    $finalFilePath = $uploadDir . $uploadId . '_' . $fileName;
    if (($out = fopen($finalFilePath, 'wb')) === false) {
        echo json_encode(['success' => false, 'message' => 'Zieldatei konnte nicht erstellt werden']);
        exit;
    }

    // Alle Chunks anfügen
    for ($i = 0; $i < $totalChunks; $i++) {
        $chunkPath = $tempDir . 'chunk_' . $i;
        if (($in = fopen($chunkPath, 'rb')) === false) {
            fclose($out);
            echo json_encode(['success' => false, 'message' => 'Chunk konnte nicht gelesen werden']);
            exit;
        }

        while ($buff = fread($in, 8192)) {
            fwrite($out, $buff);
        }
        fclose($in);
        unlink($chunkPath); // Chunk löschen
    }
    fclose($out);
    rmdir($tempDir);

    echo json_encode(['success' => true, 'message' => 'Datei erfolgreich hochgeladen', 'path' => '/upload/' . basename($finalFilePath)]);
    exit;
}

// Falls noch nicht alle Chunks hochgeladen sind, Erfolg melden (für diesen Chunk)
echo json_encode(['success' => true, 'message' => "Chunk $chunkIndex erfolgreich hochgeladen"]);
exit;