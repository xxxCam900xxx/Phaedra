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
$pointingTable = $data['type'];
$stmt1;

if ($pointingTable == "NoSplitLayout") {
    $stmt1 = executeStatement(
        "INSERT INTO NoSplitLayout (No1_WidgetID) VALUES (NULL)"
    );
} else if ($pointingTable == "TwoSplitLayout") {
    $stmt1 = executeStatement(
        "INSERT INTO TwoSplitLayout (No1_WidgetID, No2_WidgetID) VALUES (NULL, NULL)"
    );
} else if ($pointingTable == "ThreeSplitLayout") {
    $stmt1 = executeStatement(
        "INSERT INTO ThreeSplitLayout (No1_WidgetID, No2_WidgetID, No3_WidgetID) VALUES (NULL, NULL, NULL)"
    );
}

// Neue ID holen
$LayoutTypID = $stmt1->insert_id;

// 2️⃣ Neuen Eintrag in Layout erstellen
$stmt2 = executeStatement(
    "INSERT INTO Layout (PageContentID, Type, Sort) VALUES (?, '$pointingTable', ?)",
    [$pageContentId, 0],
    "ii"
);

// Neue Layout-ID holen
$layoutId = $stmt2->insert_id;

// Erfolg zurückgeben
echo json_encode([
    'success' => true,
    'layoutId' => $layoutId,
    'layoutTypID' => $LayoutTypID
]);
