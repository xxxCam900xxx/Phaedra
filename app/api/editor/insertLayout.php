<?php
require_once '../config/database.php';

header('Content-Type: application/json');

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

$conn = getConnection();

// Höchsten Sort-Wert ermitteln
$stmtSort = $conn->prepare("SELECT MAX(Sort) as maxSort FROM Layout WHERE PageContentID = ?");
$stmtSort->bind_param("i", $pageContentId);
$stmtSort->execute();
$resSort = $stmtSort->get_result();
$rowSort = $resSort->fetch_assoc();
$stmtSort->close();

$newSort = ($rowSort && $rowSort['maxSort'] !== null) ? ((int)$rowSort['maxSort'] + 10) : 10;

// 1️⃣ Zuerst in Layout einfügen und neue layoutId holen
$stmtLayout = $conn->prepare("INSERT INTO Layout (PageContentID, Type, Sort) VALUES (?, ?, ?)");
$stmtLayout->bind_param("isi", $pageContentId, $pointingTable, $newSort);
if (!$stmtLayout->execute()) {
    echo json_encode(['error' => 'Insert Layout failed: ' . $stmtLayout->error]);
    exit;
}
$layoutId = $conn->insert_id;
$stmtLayout->close();

// Platzhalter-Werte (kein echtes Widget)
$placeholderWidgetId = null;  // NULL, da erlaubt
$placeholderWidgetType = null; // NULL, da erlaubt

// 2️⃣ Jetzt in Detail-Tabelle mit layoutId einfügen
if ($pointingTable === "NoSplitLayout") {
    $stmtDetail = $conn->prepare(
        "INSERT INTO NoSplitLayout (ID, No1_WidgetID, No1_WidgetType) VALUES (?, ?, ?)"
    );
    $stmtDetail->bind_param("iis", $layoutId, $placeholderWidgetId, $placeholderWidgetType);
} elseif ($pointingTable === "TwoSplitLayout") {
    $stmtDetail = $conn->prepare(
        "INSERT INTO TwoSplitLayout (ID, No1_WidgetID, No1_WidgetType, No2_WidgetID, No2_WidgetType) VALUES (?, ?, ?, ?, ?)"
    );
    $stmtDetail->bind_param("iisis", $layoutId, $placeholderWidgetId, $placeholderWidgetType, $placeholderWidgetId, $placeholderWidgetType);
} elseif ($pointingTable === "ThreeSplitLayout") {
    $stmtDetail = $conn->prepare(
        "INSERT INTO ThreeSplitLayout (ID, No1_WidgetID, No1_WidgetType, No2_WidgetID, No2_WidgetType, No3_WidgetID, No3_WidgetType) VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    $stmtDetail->bind_param(
        "iisisis",
        $layoutId,
        $placeholderWidgetId,
        $placeholderWidgetType,
        $placeholderWidgetId,
        $placeholderWidgetType,
        $placeholderWidgetId,
        $placeholderWidgetType
    );
} elseif ($pointingTable === "BigLeftSplitLayout") {
    $stmtDetail = $conn->prepare(
        "INSERT INTO BigLeftSplitLayout (ID, No1_WidgetID, No1_WidgetType, No2_WidgetID, No2_WidgetType) VALUES (?, ?, ?, ?, ?)"
    );
    $stmtDetail->bind_param("iisis", $layoutId, $placeholderWidgetId, $placeholderWidgetType, $placeholderWidgetId, $placeholderWidgetType);
} elseif ($pointingTable === "BigRightSplitLayout") {
    $stmtDetail = $conn->prepare(
        "INSERT INTO BigRightSplitLayout (ID, No1_WidgetID, No1_WidgetType, No2_WidgetID, No2_WidgetType) VALUES (?, ?, ?, ?, ?)"
    );
    $stmtDetail->bind_param("iisis", $layoutId, $placeholderWidgetId, $placeholderWidgetType, $placeholderWidgetId, $placeholderWidgetType);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid type']);
    exit;
}

if (!$stmtDetail->execute()) {
    echo json_encode(['error' => 'Insert Detail failed: ' . $stmtDetail->error]);
    exit;
}
$stmtDetail->close();

echo json_encode([
    'success' => true,
    'layoutId' => $layoutId,
    'layoutTypID' => $layoutId // Die ID ist gleich der Layout ID wegen Fremdschlüssel
]);
