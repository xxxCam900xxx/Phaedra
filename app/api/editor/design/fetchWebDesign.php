<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/editor/design/getEditorStyles.php";

header('Content-Type: application/json');

$design = getWebDesign();
if ($design) {
    echo json_encode($design);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Kein WebDesign gefunden']);
}