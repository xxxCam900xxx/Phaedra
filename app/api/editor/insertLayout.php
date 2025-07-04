<?php
require_once '../config/database.php';

// Validierung
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['pageContentId'], $data['type'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

$pageContentId = (int)$data['pageContentId'];
$pointingTable = $data['type'];

// 1️⃣ Höchsten Sort-Wert ermitteln
$conn = getConnection();
$stmtSort = $conn->prepare("SELECT MAX(Sort) as maxSort FROM Layout WHERE PageContentID = ?");
$stmtSort->bind_param("i", $pageContentId);
$stmtSort->execute();
$resSort = $stmtSort->get_result();
$rowSort = $resSort->fetch_assoc();
$stmtSort->close();

$newSort = ($rowSort && $rowSort['maxSort'] !== null) ? ((int)$rowSort['maxSort'] + 10) : 10;

// 2️⃣ Layout-Tabelle einfügen
$stmt1 = null;
if ($pointingTable === "NoSplitLayout") {
    $stmt1 = executeStatement(
        "INSERT INTO NoSplitLayout (No1_WidgetID, No1_WidgetType) VALUES (NULL, NULL)"
    );
} elseif ($pointingTable === "TwoSplitLayout") {
    $stmt1 = executeStatement(
        "INSERT INTO TwoSplitLayout (No1_WidgetID, No1_WidgetType, No2_WidgetID, No2_WidgetType) VALUES (NULL, NULL, NULL, NULL)"
    );
} elseif ($pointingTable === "ThreeSplitLayout") {
    $stmt1 = executeStatement(
        "INSERT INTO ThreeSplitLayout (No1_WidgetID, No1_WidgetType, No2_WidgetID, No2_WidgetType, No3_WidgetID, No1_WidgetType) VALUES (NULL, NULL, NULL, NULL, NULL, NULL)"
    );
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid type']);
    exit;
}

$LayoutTypID = $stmt1->insert_id;

// 3️⃣ Layout-Eintrag anlegen mit korrektem Sort-Wert
$stmt2 = executeStatement(
    "INSERT INTO Layout (PageContentID, Type, Sort) VALUES (?, ?, ?)",
    [$pageContentId, $pointingTable, $newSort],
    "isi"
);

$layoutId = $stmt2->insert_id;

// Ergebnis zurückgeben
echo json_encode([
    'success' => true,
    'layoutId' => $layoutId,
    'layoutTypID' => $LayoutTypID
]);