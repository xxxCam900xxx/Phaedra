<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/api/config/database.php';
header('Content-Type: application/json');

// Nur POST zulassen
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// JSON einlesen
$data = json_decode(file_get_contents('php://input'), true);
if (
    !isset($data['layoutId'], $data['widgetId'], $data['widgetType'], $data['layoutType'], $data['widgetSlot']) ||
    empty($data['layoutId']) || empty($data['widgetId']) || empty($data['widgetType']) ||
    empty($data['layoutType']) || empty($data['widgetSlot'])
) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing or invalid parameters']);
    exit;
}

// Werte extrahieren
$layoutId = (int)$data['layoutId'];
$widgetId = (int)$data['widgetId'];
$widgetType = $data['widgetType'];
$layoutType = $data['layoutType'];
$widgetSlot = $data['widgetSlot']; // z. B. 'no2'

// Sicherheitsprüfung
$allowedSlots = ['1', '2', '3'];
$allowedWidgets = ['TextWidget'];
$allowedLayoutTypes = ['TwoSplitLayout', 'ThreeSplitLayout', 'NoSplitLayout'];

if (!in_array($widgetSlot, $allowedSlots, true)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Ungültiger Widget-Slot']);
    exit;
}

if (!in_array($widgetType, $allowedWidgets, true)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Ungültiger Widget-Typ']);
    exit;
}

if (!in_array($layoutType, $allowedLayoutTypes, true)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Ungültiger Layout-Typ']);
    exit;
}

$conn = getConnection();

// 1. Slot leeren im LayoutType-Table
$idField = "No{$widgetSlot}_WidgetID";
$typeField = "No{$widgetSlot}_WidgetType";

$clearStmt = $conn->prepare("UPDATE {$layoutType} SET $idField = NULL, $typeField = NULL WHERE ID = ?");
$clearStmt->bind_param("i", $layoutId);

if (!$clearStmt->execute()) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Fehler beim Leeren des Slots']);
    exit;
}
$clearStmt->close();

// 2. Widget löschen aus WidgetType-Tabelle
$deleteStmt = $conn->prepare("DELETE FROM {$widgetType} WHERE ID = ?");
$deleteStmt->bind_param("i", $widgetId);

if (!$deleteStmt->execute()) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Fehler beim Löschen des Widgets']);
    exit;
}
$deleteStmt->close();

// Erfolg
echo json_encode(['success' => true, 'message' => 'Widget erfolgreich gelöscht']);