<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/media/getAllMedia.php";

// Wenn als API aufgerufen (z. B. durch fetch())
if ($_SERVER['REQUEST_METHOD'] === 'GET' && basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    try {
        $images = getAllImages();
        echo json_encode($images);
        exit;
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Fehler beim Laden der Bilder']);
        exit;
    }
}