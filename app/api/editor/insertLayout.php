<?php
require_once '../config/database.php';

// Validierung (im echten Einsatz sollten Sie mehr prüfen!)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Beispiel: PageContentID aus POST
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['pageContentId'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing pageContentId']);
    exit;
}
$pageContentId = $data['pageContentId'];

// 1️⃣ Neuen Eintrag in NoSplitLayout erstellen
$stmt1 = executeStatement(
    "INSERT INTO NoSplitLayout (No1_WidgetID) VALUES (NULL)"
);

// Neue ID holen
$noSplitLayoutId = $stmt1->insert_id;

// 2️⃣ Neuen Eintrag in Layout erstellen
$stmt2 = executeStatement(
    "INSERT INTO Layout (PageContentID, Type, Sort) VALUES (?, 'NoSplitLayout', ?)",
    [$pageContentId, 0],
    "ii"
);

// Neue Layout-ID holen
$layoutId = $stmt2->insert_id;

// Erfolg zurückgeben
echo json_encode([
    'success' => true,
    'layoutId' => $layoutId,
    'noSplitLayoutId' => $noSplitLayoutId
]);