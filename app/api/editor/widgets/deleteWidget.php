<?php
require_once '../config/database.php';

header('Content-Type: application/json');

// 1. Nur POST erlauben
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// 2. JSON-Input lesen und decodieren
$data = json_decode(file_get_contents('php://input'), true);
if (
    !isset($data['layoutId'], $data['widgetId'], $data['widgetType']) ||
    empty($data['layoutId']) || empty($data['widgetId']) || empty($data['widgetType'])
) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

$layoutId = (int)$data['layoutId'];
$widgetId = (int)$data['widgetId'];
$widgetType = $data['widgetType']; // String

$conn = getConnection();

// 3. Layout aus DB laden, um zu prüfen, wo das Widget drin ist
$stmt = $conn->prepare("SELECT * FROM Layout WHERE ID = ?");
$stmt->bind_param("i", $layoutId);
$stmt->execute();
$result = $stmt->get_result();
$layout = $result->fetch_assoc();
$stmt->close();

if (!$layout) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Layout not found']);
    exit;
}

// 4. Ermitteln, in welchem Widget-Slot das Widget steckt
// Beispielspalten in Layout: no1_widget_id, no1_widget_type, no2_widget_id, no2_widget_type, no3_widget_id, no3_widget_type
$slots = ['no1', 'no2', 'no3'];

$foundSlot = null;
foreach ($slots as $slot) {
    $idField = "{$slot}_widget_id";
    $typeField = "{$slot}_widget_type";

    if (
        isset($layout[$idField], $layout[$typeField]) &&
        (int)$layout[$idField] === $widgetId &&
        $layout[$typeField] === $widgetType
    ) {
        $foundSlot = $slot;
        break;
    }
}

if (!$foundSlot) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Widget not found in layout']);
    exit;
}

// 5. Widget-Felder im Layout auf NULL setzen (Widget "entfernen")
$idField = "{$foundSlot}_widget_id";
$typeField = "{$foundSlot}_widget_type";

$sql = "UPDATE Layout SET $idField = NULL, $typeField = NULL WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $layoutId);
$success = $stmt->execute();
$stmt->close();

if ($success) {
    echo json_encode(['success' => true, 'message' => 'Widget erfolgreich gelöscht']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Fehler beim Löschen des Widgets']);
}
