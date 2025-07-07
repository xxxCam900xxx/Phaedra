<?php
require_once '../../config/database.php';
header('Content-Type: application/json');

// Validierung
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['layoutId'], $input['slot'], $input['widgetType'], $input['layoutType'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

$layoutId = (int) $input['layoutId'];
$slot = (int) $input['slot'];
$widgetType = $input['widgetType'];
$layoutType = $input['layoutType']; // Direkt aus data-layout-type

// Widget in der Widget-Tabelle anlegen
$conn = getConnection();
$stmtWidget = $conn->prepare("INSERT INTO {$widgetType} () VALUES ()");
$stmtWidget->execute();
$newWidgetId = $stmtWidget->insert_id;
$stmtWidget->close();

// Spaltennamen für den Slot
$colId = "No{$slot}_WidgetID";
$colType = "No{$slot}_WidgetType";

// Layout aktualisieren
$sql = "
    UPDATE {$layoutType}
    SET {$colId} = ?, {$colType} = ?
    WHERE ID = ?
";
$stmtUpdate = $conn->prepare($sql);
if (!$stmtUpdate) {
    echo json_encode(['error' => 'Prepare failed: ' . $conn->error, 'sql' => $sql]);
    exit;
}
$stmtUpdate->bind_param("isi", $newWidgetId, $widgetType, $layoutId);
$stmtUpdate->execute();
$stmtUpdate->close();

// Erfolgsantwort
echo json_encode([
    'success' => true,
    'widgetId' => $newWidgetId,
    'widgetType' => $widgetType
]);